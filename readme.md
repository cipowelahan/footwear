# Web Akuntansi
build from `Laravel 5.5`

## Server Requirements
- MySQL 
- PHP ^7
- OpenSSL PHP Extension
- PDO PHP Extension
- Mbstring PHP Extension
- Tokenizer PHP Extension
- XML PHP Extension
- Gd PHP Extension
- Zip PHP Extension
- Mysql PHP Extension

## Installation
clone this project and run this on console/terminal
```
cp .env.example .env
(or copy file .env.example to .env in file manager)

php artisan key:generate
```

## Environment Configuration

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE={your database}
DB_USERNAME={username for access database}
DB_PASSWORD={password for access database}
```

## Migration for Auth
after update enviroment, migrate the database for authentication
`php artisan migrate --seed`

default user:
username `admin1234`
password `admin1234`

## Cache Configuration
after making changes to the .env file, use the following command
```
php artisan config:cache
```

## Run Application
just place it in htdocs