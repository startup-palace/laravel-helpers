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

### `RelationshipHelpers`

A list of helpers for your Eloquent relations.

#### `syncHasManyRelation`

Synchronize a hasMany relation, deleting old items, updating existing and
creating new ones.

##### Usage

Let's start from this model:

```php
namespace App;

use App\Cat;
use Illuminate\Database\Eloquent\Model;
use StartupPalace\LaravelHelpers\Eloquent\RelationshipHelpersTrait;

class User extends Model
{
    use RelationshipHelpersTrait;

    protected $fillable = [
        'name', 'email', 'cats',
    ];

    protected static function boot()
    {
        parent::boot();

        self::saved(function ($user) {
            $user->syncRelation('cats');
        });
    }

    public function cats()
    {
        return $this->hasMany(Cat::class);
    }

    public function setCatsAttribute($cats)
    {
        $this->setRelationItems('cats', $cats);
    }
}
```

Based on this, you can directly add cats to you user like that:

```php
$user->create([
    'name' => 'John Doe',
    'email' => 'john.doe@example.com',
    'cats' => [
        [
            'name' => 'Garfield',
            'color' => 'orange',
        ],
        [
            'number' => 'Fuzzy',
            'color' => 'yellow',
        ],
    ],
]);
```

When you update your model, if you pass a `cats` key, cats will automatically be
created if not existing, updated, or deleted if not in your `cats` array.
