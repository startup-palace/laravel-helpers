<?php

namespace Kblais\LaravelHelpers\Eloquent;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Kblais\LaravelHelpers\Eloquent\Scopes\OrderByScope;

/**
 * Apply a default order on your model based on an attribute.
 */
trait OrderByDefaultOrderTrait
{
    /**
     * Boot the trait.
     */
    public static function bootOrderByDefaultOrderTrait()
    {
        static::addGlobalScope(static::getOrderScope());
    }

    /**
     * Query without default order.
     *
     * @return Illuminate\Database\Eloquent\Builder
     */
    public static function withoutDefaultOrder()
    {
        return with(new static())->newQueryWithoutScope(static::getOrderScope());
    }

    public function getDefaultOrder()
    {
        if (property_exists($this, 'defaultOrder')) {
            return $this->defaultOrder;
        }

        return [
            'column' => self::CREATED_AT,
            'asc' => true,
        ];
    }

    /**
     * Create the order global scope.
     *
     * @return Illuminate\Database\Eloquent\Scope
     */
    protected static function getOrderScope()
    {
        $defaultOrder = with(new static())->getDefaultOrder();

        return new OrderByScope(
            Arr::get($defaultOrder, 'column'),
            Arr::get($defaultOrder, 'asc')
        );
    }
}
