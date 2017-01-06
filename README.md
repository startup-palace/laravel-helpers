# laravel-helpers

Laravel-helpers is a collection of helpers for your Laravel application.

## Installation

Require this package with Composer :

```
composer require kblais/laravel-helpers
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
