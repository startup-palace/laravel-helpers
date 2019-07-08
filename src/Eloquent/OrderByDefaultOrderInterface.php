<?php

namespace Kblais\LaravelHelpers\Eloquent;

interface OrderByDefaultOrderInterface
{
    /**
     * Get default order column and asc/desc parameter.
     *
     * @return array
     */
    public function getDefaultOrder();
}
