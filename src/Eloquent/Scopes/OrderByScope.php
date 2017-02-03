<?php

namespace StartupPalace\LaravelHelpers\Eloquent\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

/**
 * Global scope to apply a default order on your Eloquent model.
 */
class OrderByScope implements Scope
{
    protected $column;

    protected $asc;

    public function __construct($column, $asc = true)
    {
        $this->column = $column;
        $this->asc = $asc;
    }

    public function apply(Builder $builder, Model $model)
    {
        $builder->orderBy($this->column, $this->asc ? 'ASC' : 'DESC');
    }

    public function remove(Builder $builder, Model $model)
    {
        $query = $builder->getQuery();

        foreach ((array) $query->orders as $key => $order) {
            if ($order['column'] == $this->column) {
                unset($query->orders[$key]);

                $query->orders = array_values($query->orders);
            }
        }
    }
}
