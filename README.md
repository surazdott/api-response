<p align="center">
    <img src="https://raw.githubusercontent.com/surazdott/api-response/main/art/example.png" width="600" alt="Laravel API Response">
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

`response(string $message, mixed $data = [], int $status = 200)`

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
Method for a successful operation with HTTP status code 200.

`success(string $message, mixed $data = [])`

```php
public function index()
{
    $users = User::take(2)->get();

    return api()->success('Request processed successfully.', $users);
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

#### `paginate`
Return for a successful operation with HTTP paginated data.

`paginate(string $message, mixed $data = [])`

```php
public function index()
{
    $users = UserResource::collection(User::active()->paginate(10));

    return api()->paginate('Data fetched successfully.', $users);
}

// Result
{
    "success": true,
    "message": "Data fetched successfully.",
    "data": [
        {
            "id": 1",
            "name": "Suraj....",
        },
        {
            "id": 2",
            "name": "Rabin....",
        }
    ],
    "links": {
        "first": "http://example.com/api/v1/users?page=1",
        "last": "http://example.com/api/v1/users?page=1",
        "prev": null,
        "next": null
    },
    "meta": {
        "total": 0,
        "current_page": 1,
        "total_pages": 1,
        "per_page": 10
    }
}
```

#### `created`
Returns a response indicating that a resource has been successfully created  with HTTP status code 201.

`created(string $message, mixed $data = [])`

```php
public function store()
{
    $user = User::create(['name' => 'Suraj']);

    return api()->created('Resource created successfully', $user);
}

// Result
{
    "success": true,
    "message": "Resource created successfully",
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

`error(string $message, int $status = 400)`

```php
public function foo()
{
    return api()->error('Bad request');
}

// Result
{
    "success": false,
    "message": "Bad request"
}
```

#### `unauthorized`
Returns an unauthorized response with HTTP status code 401.

`unauthorized(string $message)`

```php
public function edit()
{
    if ($user->isNotAdmin()) {
        return api()->unauthorized('Authentication is required to access this resource.');
    }
}

// Result 
{
    "success": false,
    "message": "Authentication is required to access this resource"
}
```

#### `forbidden`
Returns an unauthorized response with HTTP status code 401.

`forbidden(string $message)`

```php
public function edit()
{
    if ($user->isNotAdmin()) {
        return api()->unauthorized('You do not have permission to access this resource.');
    }
}

// Result 
{
    "success": false,
    "message": "You do not have permission to access this resource"
}
```

#### `notFound`
Returns a not found response with HTTP status code 404.

`notFound(string $message)`

```php
public function edit()
{
    $post = Post::find(1);

    if (! $post) {
        return api()->notFound('Requested resource could not be found');
    }
}

// Result
{
    "success": false,
    "message": "Requested resource could not be found"
}
```

#### `notAllowed`
Returns a method not allowed response with HTTP status code 405.

`notAllowed(string $message)`

```php
Route::fallback(function() {
    return api()->notAllowed('Method type is not currently supported');
});

// Result
{
    "success": false,
    "message": "Method type is not currently supporte."
}
```

#### `validation`
Generates a response indicating validation errors with HTTP status code 400.

`validation(string $message, mixed $errors = [])`

```php
public function login()
{
    $validator = Validator::make($request->all(), [
        'email' => 'required',
        'password' => 'required',
    ]);

    if ($validator->fails()) {
        return api()->validation('Validation failed for the request.', $validator->errors());
    }
}

// Result 
{
    "success": false,
    "message": "Validation failed for the request",
    "errors": {
        "password": [
            "The password field is required."
        ]
    }
}
```

#### `serverError`
Returns an error response with HTTP status code 4xx.

`serverError(string $message, int $status = 500)`

```php
public function index()
{
    try {
        $users = \App\Models\User::find($id); // Undefined $id
    } catch (\Exception $e) {
        return api()->error('Invalid syntax for this request was provided');
    }
}

// Result
{
    "success": false,
    "message": "Invalid syntax for this request was provided"
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
    "message": "Validation failed for the request",
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
        throw new ApiResponseException('User must be an admin', 403);
    }
}

// Result
{
    "success": false,
    "message": "User must be an admin"
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
        throw new ApiValidationException('Validation failed for the request', $validator->errors());
    }
}

// Result
{
    "success": false,
    "message": "Validation failed for the request",
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
