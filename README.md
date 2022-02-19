# Laravel multi-auth with CRUD

## Setup

Download or clone this repo

```shell
$ git clone https://github.com/haithamassoli/Upscale-Task.git
```

Install all dependency required by Laravel.

```shell
$ composer install
```

Generate app key, configure `.env` file and do migration.

```shell
# create copy of .env
$ cp .env.example .env

# create Laravel key
$ php artisan key:generate
```

Next, add your database credentials in `.env` file and then run migrations.

```shell
# run migration
$ php artisan migrate --seed
```

```shell
# link storage
$ php artisan storage:link
```
