<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel


$ docker-compose exec backend bash
$ php artisan migrate


### API Endpoints
* POST /api/admin/register
* POST /api/admin/login
* GET /api/admin/user
* POST /api/admin/logou

$ php artisan make:controller AuthController

When API's are created, use Symfony\Component\HttpFoundation\Response so you could use constants for status codes as in
```php
    return response($user, Response::HTTP_CREATED)
```

* Package required for JWT token generation
$ composer require laravel/sanctum 
$ php artisan migrate (execute it inside the docker container)
- Add HasApiTokens for laravel jwt token generation in the controller
- - In config/cors.php set support_credentials to true to support passing the values to frontend
