<?php

namespace Kblais\LaravelHelpers\Tests;

use Illuminate\Http\Request;
use Ramsey\Uuid\Uuid;
use Kblais\LaravelHelpers\Tests\Models\Post;
use Kblais\LaravelHelpers\Tests\Models\User;

class UuidTest extends TestCase
{
    public function testModelHasSingularTableName()
    {
        $user = new User;

        $this->assertEquals($user->getTable(), 'user');
    }

    public function testModelHasCustomTableName()
    {
        $post = new Post;

        $this->assertEquals($post->getTable(), 'user_posts');
    }
}
