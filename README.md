
# Employee Management Package ( Laravel 5.8 )

A basic laravel package aims to show a list of employees along with some basic management operations

## Getting Started

These instructions will get you a copy of the project up and running on your local machine for development and testing purposes. See deployment for notes on how to deploy the project on a live system.

### Prerequisites

What things you need to install the software and how to install them

```
PHP >= 7.1.3
Laravel 5.8 
```

### Installing

```
issue the following command in your laravel root directory :

composer require bahraminekoo/employee

```

In laravel <=5.4  :

add the line below to the **providers** array of the config/app.php configuration file :

Bahraminekoo\Employee\EmployeeServiceProvider::class

In laravel >=5.5 this service provider will be automatically added to the providers array .

And then

```
run the following commands also in the laravel root directory respectively:

php artisan vendor:publish --tag=migrations

php artisan vendor:publish --tag=factories

php artisan vendor:publish --tag=public

php artisan vendor:publish --tag=config

php artisan migrate

```

In this application there is the ability (with form) to add new employees
into the DB and app but in order to get you started faster I have provided
related seeder , issue the commands below to seed your database : 

```
php artisan db:seed --class=Bahraminekoo\Employee\Database\Seeds\EmployeesTableSeeder
```

##### Configuration

in the config/employee.php there is an item "items_per_page" in order to 
specifies how many items you want to show on each page in terms of pagination .

##### Logging 

You are able to see the application logs in storage/logs folder of laravel 
application .

##### Caching 

This application uses caching in order to speed up the database queries . 

##### Localization

at the moment the default language for the package is english but there is the ability to 
add as many language as you wish , if you need to override the English translation strings 
in messages.php for the package, you should place a language file at:  
resources/lang/bahraminekoo/employee/en/messages.php. Within this file, you should only define 
the translation strings you wish to override. Any translation strings you don't override 
will still be loaded from the package's original language file.

##### Testing 

Run the following command at the root of laravel application to execute the related unit tests for this package :

```
phpunit vendor/bahraminekoo/employee
```



