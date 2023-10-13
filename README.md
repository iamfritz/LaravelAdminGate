<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains over 1500 video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the Laravel [Patreon page](https://patreon.com/taylorotwell).

### Premium Partners

- **[Vehikl](https://vehikl.com/)**
- **[Tighten Co.](https://tighten.co)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Cubet Techno Labs](https://cubettech.com)**
- **[Cyber-Duck](https://cyber-duck.co.uk)**
- **[Many](https://www.many.co.uk)**
- **[Webdock, Fast VPS Hosting](https://www.webdock.io/en)**
- **[DevSquad](https://devsquad.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel/)**
- **[OP.GG](https://op.gg)**
- **[WebReinvent](https://webreinvent.com/?utm_source=laravel&utm_medium=github&utm_campaign=patreon-sponsors)**
- **[Lendio](https://lendio.com)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).


# Laravel React App

This is a simple Member app with multiple user role.

This is built on Laravel Framework 8. This was built for demonstrate purpose.

### Language & Framework Used:
1. PHP-8
1. Laravel-10

### Architecture Used:
1. Laravel 10.x
1. Interface-Repository Pattern
1. Model Based Eloquent Query
1. Laravel API
1. Laravel API Key
1. Laravel Sanctum
1. Laravel Gate and Policy
1. Swagger API Documentation - https://github.com/DarkaOnLine/L5-Swagger
1. JWT Auth - https://github.com/tymondesigns/jwt-auth
1. PHP Unit Testing - Some basic unit testing added.
1. SweetAlert2

### API List:
##### Authentication Module
1. [x] Register User with API Key
1. [x] Login  with API Key to generate token
1. [x] Authenticated User Profile
1. [x] Refresh Data
1. [x] Logout
1. [x] Post
1. [ ] Category
1. [ ] User
1. [] Todo

##### Post API Module
1. [x] Post List
1. [x] Post List [Public] <!-- except not working -->
1. [x] Create Post
1. [x] Create Post - findorcreate category field by title
1. [x] Edit Post
1. [x] View Post
1. [x] Delete Post
1. [ ] Post custom field - pending
1. [ ] Image field - pending

##### Category Module
1. [x] Category List
1. [ ] Category List [Public]
1. [ ] Create Category
1. [ ] Edit Category
1. [ ] View Category
1. [ ] Delete Category

##### Todo Module
1. [ ] Todo List
1. [ ] Create Todo
1. [ ] Edit Todo
1. [ ] View Todo by User Auth
1. [ ] Delete Todo
1. [ ] Permission CRUD, Status Change
1. [ ] Assign Task


## Installation

Clone the repository-
```
git clone https://github.com/iamfritz/LaravelAdminGate
```

Then cd into the folder with this command-
```
cd LaravelAdminGate
```

Then do a composer install
```
composer install
```

Then create a environment file using this command-
```
cp .env.example .env
```

Then edit `.env` file with appropriate credential for your database server. Just edit these two parameter(`DB_USERNAME`, `DB_PASSWORD`).

Then create a database named `laravel8` and then do a database migration using this command-
```
php artisan migrate
```

Then do database seeder RoleTableSeeder, UserTableSeeder, ApiDataSeeder
```
php artisan migrate:refresh --seed

```
OR
```
php artisan db:seed --class=RolesDataSeeder
```
php artisan db:seed --class=UserDataSeeder
```
Default admin -  admin@hellofritz.com / password
```
php artisan db:seed --class=ApiDataSeeder
```
Default API key - 1234abc5678
```
php artisan db:seed --class=PostCategoryDataSeeder
```

Then do a npm install
```
npm install
```

## Run server

Run server using this command-
```
php artisan serve
```

Then go to `http://127.0.0.1:8000` from your browser and see the app.

## Unit test

```
php artisan migrate:refresh --seed --env=testing
```
php artisan test --env=testing
```

### Commands

Create New User with Roles
```
hello:AddUser
```
```
Select Roles
Enter Name, Email Address and Password
```


## Ask a question?

If you have any query please contact at link4anything@gmail.com
