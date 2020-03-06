<?php

namespace Kblais\LaravelHelpers\Routing\Middleware;

use Closure;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class AreRelated
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param string                   $ownerParameter
     * @param string                   $foreignParameter
     * @param string                   $relationName
     *
     * @return mixed
     */
    public function handle(
        $request,
        Closure $next,
        $ownerParameter,
        $foreignParameter,
        $relationName = null
    ) {
        if ($foreignModel = $request->route($foreignParameter)) {
            $ownerModel = $request->route($ownerParameter);

            $foreignKey = $foreignModel->{$relationName ?: $ownerParameter}()->getForeignKeyName();
            $ownerKey = $foreignModel->{$relationName ?: $ownerParameter}()->getOwnerKeyName();

            if ($foreignModel->{$foreignKey} !== $ownerModel->{$ownerKey}) {
                throw new ModelNotFoundException();
            }
        }

        return $next($request);
    }
}
