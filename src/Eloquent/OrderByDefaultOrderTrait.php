<?php

namespace Kblais\LaravelHelpers\Eloquent;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
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
     */
    public static function withoutDefaultOrder(): Builder
    {
        return with(new self())->newQueryWithoutScope(static::getOrderScope());
    }

    public function getDefaultOrder(): array
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
     */
    protected static function getOrderScope(): Scope
    {
        $defaultOrder = with(new self())->getDefaultOrder();

        return new OrderByScope(
            Arr::get($defaultOrder, 'column'),
            Arr::get($defaultOrder, 'asc')
        );
    }
}
