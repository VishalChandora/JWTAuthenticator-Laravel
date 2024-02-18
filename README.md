<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

## JWTAuthenticator-Laravel
JWTAuthenticator-Laravel is a secure authentication system built on the Laravel framework, utilizing JSON Web Tokens (JWT) for user authentication. This project provides a robust and easy-to-use API for user registration, login, profile retrieval, token refreshing, and logout functionalities.

# Laravel JWT Authentication Project Setup Guide

## PART A: Project Setup and Database Connectivity

### Step 1: Create Laravel Project

```bash
composer create-project laravel/laravel your-project-name
```

### Step 2: Start Development Server

```bash
php artisan serve
```

URL: [http://127.0.0.1:8000](http://127.0.0.1:8000)

### Step 3: Create Database & Connect

```sql
CREATE DATABASE laravel_app;
```

Update `.env` file:

```plaintext
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laravel_app
DB_USERNAME=root
DB_PASSWORD=root
```

## PART B: Setup JWT Token

### Step 1: Install JWT Auth Package

```bash
composer require tymon/jwt-auth
```

### Step 2: Configure JWT Auth

Open `app.php` and add provider:

```php
Tymon\JWTAuth\Providers\LaravelServiceProvider::class,
```

Add aliases:

```php
'Jwt' => Tymon\JWTAuth\Providers\LaravelServiceProvider::class,
'JWTFactory' => Tymon\JWTAuth\Facades\JWTFactory::class,
'JWTAuth' => Tymon\JWTAuth\Facades\JWTAuth::class,
```

### Step 3: Publish JWT Configuration

```bash
php artisan vendor:publish --provider="Tymon\JWTAuth\Providers\LaravelServiceProvider"
```

### Step 4: Run Migration

```bash
php artisan migrate
```

### Step 5: Generate JWT Secret

```bash
php artisan jwt:secret
```

### Step 6: Update Auth Configuration

Open `auth.php` and add JWT guard:

```php
'api' => [
    'driver' => 'jwt',
    'provider' => 'users',
],
```

### Step 7: Update User Model

Open `User.php` and implement JWTSubject:

```php
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject {
    // Add methods getJWTIdentifier() and getJWTCustomClaims() here

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

}
```

Congratulations! You have successfully set up JWT authentication in your Laravel project.
