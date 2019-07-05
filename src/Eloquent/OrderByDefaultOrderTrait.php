<?php

namespace Kblais\LaravelHelpers\Eloquent;

use Illuminate\Database\Eloquent\Model;
use Kblais\LaravelHelpers\Eloquent\Scopes\OrderByScope;

/**
 * Apply a default order on your model based on an attribute.
 */
trait OrderByDefaultOrderTrait
{
    /**
     * Boot the trait
     */
    public static function bootOrderByDefaultOrderTrait()
    {
        static::addGlobalScope(static::getOrderScope());
    }

    /**
     * Create the order global scope
     * @return Illuminate\Database\Eloquent\Scope
     */
    protected static function getOrderScope()
    {
        $defaultOrder = with(new static)->getDefaultOrder();

        return new OrderByScope(
            array_get($defaultOrder, 'column'),
            array_get($defaultOrder, 'asc', true)
        );
    }

    /**
     * Query without default order
     * @return Illuminate\Database\Eloquent\Builder
     */
    public static function withoutDefaultOrder()
    {
        return with(new static)->newQueryWithoutScope(static::getOrderScope());
    }

    public function getDefaultOrder()
    {
        return [
            'column' => self::CREATED_AT,
            'asc' => null,
        ];
    }
}
