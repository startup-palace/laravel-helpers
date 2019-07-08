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
     * @param \Closure                 $next
     * @param string                   $ownerRelation
     * @param string                   $foreignRelation
     *
     * @return mixed
     */
    public function handle($request, Closure $next, $ownerRelation, $foreignRelation)
    {
        if ($foreignModel = $request->route($foreignRelation)) {
            $ownerModel = $request->route($ownerRelation);

            $foreignKey = $foreignModel->{$ownerRelation}()->getForeignKeyName();
            $ownerKey = $foreignModel->{$ownerRelation}()->getOwnerKeyName();

            if ($foreignModel->{$foreignKey} !== $ownerModel->{$ownerKey}) {
                throw new ModelNotFoundException();
            }
        }

        return $next($request);
    }
}
