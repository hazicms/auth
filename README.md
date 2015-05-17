AuthBasicMiddleware has the next permissions:

- All user with role 'admin', has all permissions.
- index action: none permission.appear only our resources. all if in 'admin' role.
- create action: need to be 'create.MODEL' permission.
- edit action: need to be 'edit.MODEL' permission and be creator of this resource.
- delete action: need to be 'delete.MODEL' permission and be creator of this resource.

Steps to Get Started
--------------------


1. Add this package to your composer.json:
  
        "require": {
            "hazicms/auth": "dev-master"
        }
  
2. Run composer update

        composer update
    
3. Add the ServiceProviders to the providers array in ```config/app.php```.<br>

        'HaziCms\Auth\AuthServiceProvider'


4. Publish config files for generators, modules and images:

        php artisan vendor:publish --provider="HaziCms\Generator\Generator\GeneratorServiceProvider"

        php artisan vendor:publish

        php artisan vendor:publish --provider="Intervention\Image\ImageServiceProviderLaravel5"

4. Modify ```app\Http\Kernel.php``` file:

    Add :
        protected $routeMiddleware = [
            'hazicms.basic' => 'HaziCms\Http\Middleware\AuthBasicMiddleware',
        ];
5. Add middleware to route: 

    Route::group(['prefix' => 'admin', ```'middleware' => 'hazicms.basic'``` ,'namespace' => 'HaziCms\\Modules\Blog\Http\Controllers'], function()
    {
        Route::resource('posts', 'PostController');
    });

6. You are ready! :-)

Credits
--------

This module is created by [Aitor Ibañez](https://github.com/aitiba).

**Bugs & Forks are welcomed :)**
