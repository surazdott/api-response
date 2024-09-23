<p align="center">
    <img src="https://raw.githubusercontent.com/surazdott/api-response/main/art/image.png" width="600" alt="Laravel API Response">
    <p align="center"><a href="https://github.com/surazdott/api-response/actions"><img alt="GitHub Workflow Status (main)" src="https://img.shields.io/github/actions/workflow/status/surazdott/api-response/tests.yml?branch=main&label=tests&style=round-square"></a> <a href="https://packagist.org/packages/surazdott/api-response"><img alt="Latest Version" src="https://img.shields.io/packagist/v/surazdott/api-response"></a> <a href="https://packagist.org/packages/surazdott/api-response"><img alt="License" src="https://img.shields.io/github/license/surazdott/api-response"></a>
    </p>
</p>

# Laravel API Response

Laravel API Response package simplifies the process of generating standardized JSON responses in Laravel applications. It provides a consistent and intuitive API through the package, offering a variety of methods to manage different types of HTTP responses effectively.

## Installation

> **Requires [PHP 8.1+](https://php.net/releases/)**

To install the package, you can use Composer:

```bash
composer require surazdott/api-response
```

You can publish the config, languages and resources from with the help of command.

```
php artisan vendor:publish --tag=api-response
```

## Basic usage
After installing the package, you can use the Api facade or helper function to generate JSON responses in your controllers or anywhere within your application. The following methods are available:

#### Facade

Generates a generic JSON response with facade.

```php
use Api;

....

public function index()
{
    $posts = Post::take(10)->get();

    return Api::success($posts);
}
```

#### Helper function

Generates a generic JSON response with helper function.

```php
public function index()
{
    $posts = Post::take(10)->get();

    return api()->response($posts);
}
```

This is the result.

```bash
{
    "success": true,
    "message": "Request processed successfully.",
    "data": [
        {"title": "Post Title", ...}
    ]
}
```

### Methods

#### `response`
Generates a generic JSON response with a customizable status code.

`response(mixed $data = [], ?string $message, int $status = 200)`

```php
return api()->response($data = [], 'Operation completed successfully', $status = 200);

// Result
{
    "success": true,
    "message": "Operation completed successfully",
    "data": []
}
```
#### `success`
Shortcut for a successful operation with HTTP status code 200.

`success(mixed $data = [], ?string $message)`

```php
public function index()
{
    $users = User::take(2)->get();

    return api()->success($users);
}

// Result
{
    "success": true,
    "message": "Request processed successfully.",
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

`created(mixed $data = [], ?string $message)`

```php
public function store()
{
    $user = User::create(['name' => 'Suraj']);

    return api()->created($user);
}

// Result
{
    "success": true,
    "message": "Resource created successfully.",
    "data": [
        {
            "id": 1,
            "name": "Suraj Datheputhe",
        }
    ]
}
```

#### `error`
Returns an error response with HTTP status code 4xx.

`error(?string $message = null, int $status = 400)`

```php
public function index()
{
    try {
        $users = \App\Models\User::find($id); // Undefined $id
    } catch (\Exception $e) {
        return api()->error();
    }
}

// Result
{
    "success": false,
    "message": "Invalid syntax for this request was provided."
}
```

#### `unauthorized`
Returns an unauthorized response with HTTP status code 401.

`unauthorized(?string $message)`

```php
public function edit()
{
    if ($user->isNotAdmin()) {
        return api()->unauthorized();
    }
}

// Result 
{
    "success": false,
    "message": "Authentication is required to access this resource."
}
```

#### `forbidden`
Returns an unauthorized response with HTTP status code 401.

`forbidden(?string $message)`

```php
public function edit()
{
    if ($user->isNotAdmin()) {
        return api()->unauthorized();
    }
}

// Result 
{
    "success": false,
    "message": "You do not have permission to access this resource."
}
```

#### `notFound`
Returns a not found response with HTTP status code 404.

`notFound(?string $message)`

```php
public function edit()
{
    $post = Post::find(1);

    if (! $post) {
        return api()->notFound();
    }
}

// Result
{
    "success": false,
    "message": "Requested resource could not be found."
}
```

#### `notAllowed`
Returns a method not allowed response with HTTP status code 405.

`notAllowed(?string $message)`

```php
Route::fallback(function() {
    return api()->notAllowed();
});

// Result
{
    "success": false,
    "message": "Method type is not currently supported."
}
```

#### `validation`
Generates a response indicating validation errors with HTTP status code 400.

`validation(mixed $errors = [], ?string $message)`

```php
public function login()
{
    $validator = Validator::make($request->all(), [
        'email' => 'required',
        'password' => 'required',
    ]);

    if ($validator->fails()) {
        return api()->validation($validator->errors());
    }
}

// Result 
{
    "success": false,
    "message": "Validation failed for the request.",
    "errors": {
        "password": [
            "The password field is required."
        ]
    }
}
```

#### `unprocessable`
Generates a unprocessable response with HTTP status code 422.

`unprocessable(mixed $errors = [], ?string $message)`

```php
$errors = ['details' => 'Invalid request data'];

return api()->unprocessable($errors);

// Result 
{
    "success": false,
    "message": "Server was unable to process the request.",
    "errors": {
        "details": "Invalid request data"
    }
}
```

Note: API response messages are predefined and can be changed from parameters or from the language file.

## Request Validation
Laravel's request validation can be used for both web and API. You can call the trait

`SurazDott\ApiResposne\Concerns\HasApiResponse;`

```php
<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use SurazDott\ApiResposne\Concerns\HasApiResponse;

class UserStoreRequest extends FormRequest
{
    use HasApiResponse;
    
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
        ];
    }
}

// Result
{
    "success": false,
    "message": "Validation failed for the request.",
    "errors": {
        "name": [
            "The name field is required."
        ]
    }
}
```

## API Exceptions
If you want to throw the custom exceptionl, you can use the following classes:

`ApiResponseException(string $message, ?int status)` 

```php
use SurazDott\ApiResponse\Exceptions\ApiResponseException;

public function login(Request $request)
{
    if ($user->isNotAdmin()) {
        throw new ApiResponseException('User must be an admin.', 400);
    }
}

// Result
{
    "success": false,
    "message": "User must be an admin."
}
```

`ApiValidationException(mixed $errors, ?string $message)`

```php
use SurazDott\ApiResponse\Exceptions\ApiValidationException;

public function validation(Request $request)
{
    $validator = Validator::make($request->all(), [
        'email' => ['required', 'email', 'max:255', 'unique:users,email'],
    ]);

    if ($validator->fails()) {
        throw new ApiValidationException($validator->errors());
    }
}

// Result
{
    "success": false,
    "message": "Validation failed for the request.",
    "errors": {
        "email": [
            "The email field is required."
        ]
    }
}
```

## Contributing
If you find any issues or have suggestions for improvements, feel free to open an issue or create a pull request. Contributions are welcome!

## License
This package is open-sourced software licensed under the [MIT license](https://opensource.org/license/mit/).
