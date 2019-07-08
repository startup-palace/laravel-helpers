<?php

namespace Kblais\LaravelHelpers\Tests;

use Kblais\LaravelHelpers\Eloquent\OrderByDefaultOrderInterface;
use Kblais\LaravelHelpers\Eloquent\OrderByDefaultOrderTrait;
use Kblais\LaravelHelpers\Tests\Models\User;

/**
 * @internal
 * @covers \Kblais\LaravelHelpers\Eloquent\OrderByDefaultOrderTrait
 */
final class OrderByDefaultTest extends TestCase
{
    public function testModelHasDefaultDefaultOrder()
    {
        $user = new class() extends User implements OrderByDefaultOrderInterface {
            use OrderByDefaultOrderTrait;

            protected $table = 'user';
        };

        $query = $user::query();

        static::assertSame('select * from `user` order by `created_at` asc', $query->toSql());
    }

    public function testRemoveDefaultOrder()
    {
        $user = new class() extends User implements OrderByDefaultOrderInterface {
            use OrderByDefaultOrderTrait;

            protected $table = 'user';
        };

        $query = $user::withoutDefaultOrder();

        static::assertSame('select * from `user`', $query->toSql());
    }

    public function testModelHasCustomDefaultOrder()
    {
        $user = new class() extends User implements OrderByDefaultOrderInterface {
            use OrderByDefaultOrderTrait;

            protected $table = 'user';

            protected $defaultOrder = [
                'column' => 'id',
                'asc' => false,
            ];
        };

        $query = $user::query();

        static::assertSame('select * from `user` order by `id` desc', $query->toSql());
    }
}
