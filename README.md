<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

## Project setup

![Product vs links](./gitassets/product-links.png)

```
$ docker-compose exec backend bash
$ php artisan migrate
```

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
- Add the authenticate cookie to bearer token by modifying middleware/authenticate
```php
 public function handle($request, Closure $next, ...$guards)
    {
        // Get the token from cookie
        if($jwt = $request->cookie('jwt')){
            // Manually set the authorization headers
            $request->headers->set('Authorization', 'Bearer '. $jwt);
        }

        $this->authenticate($request, $guards);

        return $next($request);
    }
```

#### Ambassador Controller
```
$ php artisan make:controller AmbassadorController
$ php artisan make:seeder AmbassadorSeeder
$ php artisan db:seed
```

Check method generation in models
```
$ php artisan ide:models
```
