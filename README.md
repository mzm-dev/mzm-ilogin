# Build Laravel Package using Composer
A Laravel package is a set of reusable classes created to add extra functionality to a Laravel website. In clearer terms, a package is to Laravel, what plugins are to WordPress. The primary goal of Laravel packages is to reduce development time by making reusable features into a set of standalone classes that can be used within any Laravel project.

## Getting Started
- Create a fresh laravel package

```
composer create-project --prefer-dist laravel/laravel packagetestapp
```
- change directory to the new folder

```
cd packagetestapp
```

- When it's done you need to configure your env file and set your app key and other necessary details. In your terminal type:

```
cp .env.example .env
```

- generate the app key

```
php artisan key:generate
```
- create a folder called `packages`, then create a new folder called usama. 
> Note that you can subtitute usama with your own vendor name. Be sure to change the refrence in every other aspect of the app

- clone this repository to the newly created folder

```
git clone https://github.com/patelusama/contact-form-laravel-package-demo.git packages/usama/contactform
```
- Tell Laravel how to load our package and use it's functions, so inside the root of your Laravel app in the composer.json add this code:

```

"autoload": {
        "classmap": [
            "database/seeds",
            "database/factories"
        ],
        "psr-4": {
            "Usama\\Contactform\\": "packages/usama/contactform/src",
            "App\\": "app/"
        }
    },
    "autoload-dev": {
        "psr-4": {
            "Usama\\Contactform\\": "packages/usama/contactform/src",
            "Tests\\": "tests/"
        }
    },
```
- Dump the composer autoloader

```
composer dump-autoload
```

- Next, we need to add our new Service Provider in our `config/app.php` inside the `providers` array:

```
'providers' => [
         ...,
            App\Providers\RouteServiceProvider::class,
            // Our new package class
            Usama\Contactform\ContactFormServiceProvider::class,
        ],
```
- Migrate the database tables

```
php artisan migrate
```

And finally, start the application by running:

```
php artisan serve
```

Visit http://localhost:8000/contact in your browser to view the demo.

If you want to include the project as a package to your app, run:

```
composer require usama/contactform
```

## Built With

* [Laravel](https://laravel.com/) - The PHP framework for web artisans.
        

* php artisan vendor:publish --provider="Mzm\Ilogin\IloginServiceProvider" --tag="ilogin-config"     
