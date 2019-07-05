<?php

namespace Kblais\LaravelHelpers\Eloquent;

use Illuminate\Support\Str;

/**
 * Use a singular table name instead of default plural table name.
 */
trait SingularTableNameTrait
{
    public function getTable()
    {
        if (isset($this->table)) {
            return $this->table;
        }

        return str_replace('\\', '', Str::snake(class_basename($this)));
    }
}
