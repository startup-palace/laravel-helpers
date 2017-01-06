<?php

namespace StartupPalace\LaravelHelpers\Tests\Models;

use Illuminate\Database\Eloquent\Model;
use StartupPalace\LaravelHelpers\Eloquent\SingularTableNameTrait;

class User extends Model
{
    use SingularTableNameTrait;
}
