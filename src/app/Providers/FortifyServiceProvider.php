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

        Fortify::ignoreRoutes();
        $this->app->singleton(\Laravel\Fortify\Contracts\CreatesNewUsers::class, CreateNewUser::class);

        Fortify::createUsersUsing(CreateNewUser::class);
        Fortify::updateUserProfileInformationUsing(UpdateUserProfileInformation::class);
        Fortify::updateUserPasswordsUsing(UpdateUserPassword::class);
        Fortify::resetUserPasswordsUsing(ResetUserPassword::class);
        Fortify::registerView(fn () => view('auth.register'));
        Fortify::verifyEmailView(fn() => view('auth.verify-email'));

        $this->app->singleton(RegisterResponseContract::class, function () {
            return new class implements RegisterResponseContract {
                public function toResponse($request): RedirectResponse
                {
                    return redirect()->route('verification.notice');
                }
            };
        });


        // レートリミット
        RateLimiter::for('login', fn (Request $request) =>
            Limit::perMinute(100)->by($request->ip())
        );

        RateLimiter::for('two-factor', fn (Request $request) =>
            Limit::perMinute(5)->by($request->session()->get('login.id'))
        );
    }
}
