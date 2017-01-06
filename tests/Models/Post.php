<?php

namespace StartupPalace\LaravelHelpers\Tests\Models;

use Illuminate\Database\Eloquent\Model;
use StartupPalace\LaravelHelpers\Eloquent\SingularTableNameTrait;

class Post extends Model
{
    use SingularTableNameTrait;

    protected $table = 'user_posts';
}
