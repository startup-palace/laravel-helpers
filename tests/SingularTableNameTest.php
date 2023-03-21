<?php

namespace Kblais\LaravelHelpers\Tests;

use Kblais\LaravelHelpers\Tests\Models\Post;
use Kblais\LaravelHelpers\Tests\Models\User;

/**
 * @internal
 *
 * @covers \Kblais\LaravelHelpers\Eloquent\SingularTableNameTrait
 */
final class SingularTableNameTest extends TestCase
{
    public function testUserModelHasSingularTableName()
    {
        $user = new User();

        static::assertSame($user->getTable(), 'user');
    }

    public function testPostModelHasCustomTableName()
    {
        $post = new Post();

        static::assertSame($post->getTable(), 'user_posts');
    }
}
