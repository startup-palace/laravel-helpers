# laravel-helpers

Laravel-helpers is a collection of helpers for your Laravel application.

## Installation

Require this package with Composer :

```
composer require startup-palace/laravel-helpers
```

## List of helpers

### `SingularTableNameTrait`

Use a singular table name instead of default plural table name.

#### Usage

Add the trait in your model :

```php
<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use StartupPalace\LaravelHelpers\Eloquent\SingularTableNameTrait;

class User extends Model
{
    use SingularTableNameTrait;
}
```

### `OrderByDefaultOrderTrait` and `OrderByDefaultOrderInterface`

A global scope to apply a default order on your Eloquent model, and a trait you
can use to define your default order directly in your model attributes.

#### Usage

```php
namespace App;

use Illuminate\Database\Eloquent\Model;
use StartupPalace\LaravelHelpers\Eloquent\OrderByDefaultOrderTrait;
use StartupPalace\LaravelHelpers\Eloquent\OrderByDefaultOrderInterface;

class User extends Model implements OrderByDefaultOrderInterface
{
    use OrderByDefaultOrderTrait;

    public function getDefaultOrder()
    {
        /**
         * Defaults to
         * column: self::CREATED_AT
         * asc: true
         */
        return [
            'column' => 'last_login_at',
            'asc' => 'desc',
        ];
    }
}
```
