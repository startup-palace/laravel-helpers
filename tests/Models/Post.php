<?php

namespace Kblais\LaravelHelpers\Tests\Models;

use Illuminate\Database\Eloquent\Model;
use Kblais\LaravelHelpers\Eloquent\SingularTableNameTrait;

class Post extends Model
{
    use SingularTableNameTrait;

    protected $table = 'user_posts';
}
