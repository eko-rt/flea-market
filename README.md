# 1. Flea Market Project（COACHTECHフリマアプリ）

## 1.1. Dockerビルド

1. `git clone git@github.com:eko-rt/flea-market.git`  
2. DockerDesktopアプリを立ち上げる  
3. `docker-compose up -d --build`  

## 1.2. Laravel環境構築  

1. `docker-compose exec php bash`  
2. `composer install`  
3. 「.env.example」ファイルを 「.env」ファイルに命名を変更。または、新しく.envファイルを作成  
4. .envに以下の環境変数を追加  

```dotenv
DB_CONNECTION=mysql  
DB_HOST=mysql  
DB_PORT=3306  
DB_DATABASE=laravel_db  
DB_USERNAME=laravel_user  
DB_PASSWORD=laravel_pass  

# — メール認証機能 （mailtrapを使用）—
MAIL_MAILER=smtp  
MAIL_HOST=（MailtrapのHost）  
MAIL_PORT=2525=（Mailtrap の Port）
MAIL_USERNAME=（Mailtrap の Username）  
MAIL_PASSWORD=（Mailtrap の Password）  
MAIL_ENCRYPTION=null  
MAIL_FROM_ADDRESS=hello@example.com  
MAIL_FROM_NAME="${APP_NAME}"  
MAILTRAP_INBOX_URL=https://mailtrap.io/inboxes/123456  
```  

※MAILTRAP_INBOX_URLの123456 は自分の Inbox ID に置き換えてください


5. アプリケーションキーの作成  

``` bash
php artisan key:generate  
```


6. マイグレーションの実行  

``` bash
php artisan migrate
```


7. シーディングの実行  

``` bash
php artisan db:seed  
```

8. シンボリックリンクを作成  

``` bash
php artisan storage:link  
```

## 1.3. 開発用テストユーザー情報

メールアドレス：ファクトリでのランダム作成のためDB参照  
パスワード：password


## 1.4. 使用技術(実行環境)  

- nginx1.21.1  
- PHP7.4.9  
- Laravel8.83.27  
- MySQL8.0.26  
- Mailtrap（メール認証テスト用）

## 1.5. ER図  

![ER図](https://github.com/eko-rt/flea-market/raw/main/public/images/er_diagram.drawio.png)

## 1.6. URL  

- 開発環境：http://localhost/  
- phpMyadmin:http://localhost:8080