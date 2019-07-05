<?php

namespace Kblais\LaravelHelpers\Tests\Models;

use Illuminate\Database\Eloquent\Model;
use Kblais\LaravelHelpers\Eloquent\SingularTableNameTrait;

class User extends Model
{
    use SingularTableNameTrait;
}
