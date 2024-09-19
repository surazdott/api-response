<p align="center">
    <img src="https://raw.githubusercontent.com/surazdott/api-response/main/art/example.png" width="600" alt="Laravel API Response">
    <p align="center"><a href="https://github.com/surazdott/api-response/actions"><img alt="GitHub Workflow Status (main)" src="https://img.shields.io/github/actions/workflow/status/surazdott/api-response/tests.yml?branch=main&label=tests&style=round-square"></a> <a href="https://packagist.org/packages/surazdott/api-response"><img alt="Latest Version" src="https://img.shields.io/packagist/v/surazdott/api-response"></a> <a href="https://packagist.org/packages/surazdott/api-response"><img alt="License" src="https://img.shields.io/github/license/surazdott/api-response"></a>
    </p>
</p>

# Laravel API Response

Laravel API Response package simplifies the process of generating standardized JSON responses in Laravel applications. It provides a consistent and intuitive API through the package, offering a variety of methods to manage different types of HTTP responses effectively.

## Installation

To install the package, you can use Composer:

> **Requires [PHP 8.1+](https://php.net/releases/)**

```bash
composer require surazdott/api-response
```

## Basic usage
After installing the package, you can use the Api facade or helper function to generate JSON responses in your controllers or anywhere within your application. The following methods are available:

#### Facade

Generates a generic JSON response with facade.

```php
use API;

....

public function index()
{
    $posts = Post::take(10)->get();

    return Api::response('Data fetched successfully', $posts);
}
```

#### Helper function

Generates a generic JSON response with helper function.

```php
public function index()
{
    $posts = Post::take(10)->get();

    return api()->response('Data fetched successfully', $posts);
}
```

This is the result.

```bash
{
    "success": true,
    "message": "Data fetched successfully",
    "data": [
        {"title": "Post Title", ...}
    ]
}
```

### Methods

#### `response`
Generates a generic JSON response with a customizable status code.

```php
return api()->response('Operation completed successfully', $data = [], $status = 200);

// Result
{
    "success": true,
    "message": "Operation completed successfully",
    "data": []
}
```
#### `success`
Shortcut for a successful operation with HTTP status code 200.

```php
public function index()
{
    $users = User::take(2)->get();

    return api()->success('Operation completed successfully', $users);
}

// Result
{
    "success": true,
    "message": "Data fetched successfully",
    "data": [
        {
            "id": 1",
            "name": "Suraj....",
        },
        {
            "id": 2",
            "name": "Rabin....",
        }
    ]
}
```

#### `created`
Returns a response indicating that a resource has been successfully created  with HTTP status code 201.

```php
public function store()
{
    $user = User::create(['name' => 'Suraj']);

    return api()->created('Data stored successfully', $user);
}

// Result
{
    "success": true,
    "message": "Data stored successfully",
    "data": [
        {
            "id": 1,
            "name": "Suraj Datheputhe",
        }
    ]
}
```

#### `validation`
Generates a response indicating validation errors with HTTP status code 400.

```php
public function login()
{
    $validator = Validator::make($request->all(),
    [
        'email' => 'required',
        'password' => 'required',
    ]);

    if ($validator->fails()) {
        return api()->validation('Validation failed', $validator->errors());
    }
}

// Result 
{
    "success": false,
    "message": "Validation failed",
    "errors": {
        "password": [
            "The password field is required."
        ]
    }
}
```

#### `unauthorized`
Returns an unauthorized response with HTTP status code 401.

```php
public function edit()
{
    if ($user->isNotAdmin()) {
        return api()->unauthorized('You are not authorized to access this resource');
    }
}

// Result 
{
    "success": false,
    "message": "You are not authorized to access this resource"
}
```

#### `notFound`
Returns a not found response with HTTP status code 404.

```php
public function edit()
{
    $post = Post::find(1);

    if (! $post) {
        return api()->notFound('Post not found');
    }
}

// Result
{
    "success": false,
    "message": "Post not found"
}
```

#### `notAllowed`
Returns a method not allowed response with HTTP status code 405.

```php
Route::fallback(function() {
    return api()->notAllowed('Method not allowed for this endpoint');
});

// Result
{
    "success": false,
    "message": "Method not allowed for this endpoint"
}
```

#### `error`
Generates a generic error response with HTTP status code 400.

```php
return api()->error('An error occurred', ['details' => 'Invalid request data']);

// Result 
{
    "success": false,
    "message": "An error occurred",
    "errors": {
        "details": "Invalid request data"
    }
}
```

#### `serverError`
Returns an internal server error response with HTTP status code 5xx.

```php
public function index()
{
    try {
        $users = \App\Models\User::find($id); // Undefined $id
    } catch (\Exception $e) {
        return api()->serverError('Internal server error occurred', $status = 500);
    }
}

// Result
{
    "success": false,
    "message": "Internal server error occurred"
}
```

## Contributing
If you find any issues or have suggestions for improvements, feel free to open an issue or create a pull request. Contributions are welcome!

## License
This package is open-sourced software licensed under the [MIT license](https://opensource.org/license/mit/).
