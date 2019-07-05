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
use Kblais\LaravelHelpers\Eloquent\SingularTableNameTrait;

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
use Kblais\LaravelHelpers\Eloquent\OrderByDefaultOrderTrait;
use Kblais\LaravelHelpers\Eloquent\OrderByDefaultOrderInterface;

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
use Kblais\LaravelHelpers\Eloquent\RelationshipHelpersTrait;

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
            $user->syncHasManyRelation('cats');
        });
    }

    public function cats()
    {
        return $this->hasMany(Cat::class);
    }

    public function setCatsAttribute($cats)
    {
        $this->setHasManyItems('cats', $cats);
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

#### `syncHasOneRelation`

Synchronize a hasOne relation, creating the new relation item or updating it.

##### Usage

```php
namespace App;

use App\Cat;
use Illuminate\Database\Eloquent\Model;
use Kblais\LaravelHelpers\Eloquent\RelationshipHelpersTrait;

class User extends Model
{
    use RelationshipHelpersTrait;

    protected $fillable = [
        'name', 'email', 'address',
    ];

    protected static function boot()
    {
        parent::boot();

        self::saved(function ($user) {
            $user->syncHasOneRelation('address');
        });
    }

    public function address()
    {
        return $this->hasOne(Address::class);
    }

    public function setAddressAttribute($address)
    {
        $this->setHasOneItem('address', $address);
    }
}
```

To create your user with its address, you just need the following:

```php
$user->create([
    'name' => 'John Doe',
    'email' => 'john.doe@example.com',
    'address' = [
        'number' => '18',
        'street' => 'rue Scribe',
        'city' => 'Nantes',
        'country' => 'France',
    ],
]);
```

Passing an `address` array in your `update()` method will also update your
user's address.

### `Routing\Middleware\AreRelated`

The `AreRelated` middleware allows you to check if two route resources are
related. It currently only works with `HasOneOrMany`/`BelongsTo` relations.

##### Usage

In your `app/Http/Kernel.php`, add the following line in the `$routeMiddleware`
array:

```php
'areRelated' => \Kblais\LaravelHelpers\Routing\Middleware\AreRelated::class,
```

Then, let's imagine we have two models `Channel` and `Message`:

```php
use \Illuminate\Database\Model;

class Channel extends Model
{
    //
}

class Message extends Model
{
    public function channel()
    {
        return $this->belongsTo(Channel::class);
    }
}
```

And, in your routes:

```php
Route::resource('channel.message', 'MessageController');
```

Because your resources and your relations have the same name (`channel` and
`message`), you can add the middleware to your resource route to assure that the
message you try to access belongs to it's channel:

```php
Route::resource('channel.message', 'MessageController')
    ->middleware('areRelated:channel,message');
