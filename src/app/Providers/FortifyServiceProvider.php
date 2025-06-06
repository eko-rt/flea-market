<?php

namespace App\Providers;

use App\Actions\Fortify\CreateNewUser;
use App\Http\Requests\LoginRequest;
use App\Actions\Fortify\ResetUserPassword;
use App\Actions\Fortify\UpdateUserPassword;
use App\Actions\Fortify\UpdateUserProfileInformation;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Fortify;
use Laravel\Fortify\Contracts\RegisterResponse as RegisterResponseContract;
use Laravel\Fortify\Contracts\UpdateProfileInformationResponse as UpdateProfileInformationResponseContract;

class FortifyServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->app->singleton(\Laravel\Fortify\Contracts\CreatesNewUsers::class, CreateNewUser::class);

        Fortify::createUsersUsing(CreateNewUser::class);
        Fortify::updateUserProfileInformationUsing(UpdateUserProfileInformation::class);
        Fortify::updateUserPasswordsUsing(UpdateUserPassword::class);
        Fortify::resetUserPasswordsUsing(ResetUserPassword::class);
        Fortify::registerView(fn () => view('auth.register'));
        Fortify::loginView(fn () => view('auth.login'));

        // 会員登録後のリダイレクト先を設定
        $this->app->singleton   (RegisterResponseContract::class, function () {
        return new class implements     RegisterResponseContract {
            public function toResponse($request):   RedirectResponse
             {
                    return redirect('/mypage/profile'); 
                }
            };
        });

        // プロフィール更新後のリダイレクト先を設定
        $this->app->singleton(UpdateProfileInformationResponseContract::class, fn () =>
            new class implements UpdateProfileInformationResponseContract {
            public function toResponse($_): RedirectResponse 
                {
                    return redirect('/');
                }
            }
        );;

        Fortify::authenticateUsing(function (Request $request) {
            $loginRequest = new LoginRequest();
            $loginRequest->setContainer(app())->setRedirector(app('redirect'));
        
            $validator = Validator::make(
                $request->all(),
                $loginRequest->rules(),
                $loginRequest->messages()
            );
        
            if ($validator->fails()) {
                throw new ValidationException($validator);
            }
        
            $validated = $validator->validated();
        
            if (Auth::attempt([
                'email' => $validated['email'],
                'password' => $validated['password'],
            ])) {
                return Auth::user();
            }
        
            throw ValidationException::withMessages([
                'email' => ['ログイン情報が正しくありません。'],
            ]);
        });

        // ログインのレートリミットを緩和（例: 100回/1分）
        RateLimiter::for('login', fn (Request $request) =>
    Limit::perMinute(100)->by($request->ip())
);

        RateLimiter::for('two-factor', function (Request $request) {
            return Limit::perMinute(5)->by($request->session()->get('login.id'));
        });
    }
}
