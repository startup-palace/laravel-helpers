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
        if ($foreignModel = $request->route()->parameter($foreignRelation)) {
            $ownerModel = $request->route()->parameter($ownerRelation);

            $foreignKey = $foreignModel->{$ownerRelation}()->getForeignKey();
            $ownerKey = $foreignModel->{$ownerRelation}()->getOwnerKey();

            if ($foreignModel->{$foreignKey} !== $ownerModel->{$ownerKey}) {
                throw new ModelNotFoundException();
            }
        }

        return $next($request);
    }
}
