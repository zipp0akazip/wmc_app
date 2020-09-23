<?php

namespace App\Http\Middleware;

use App\Exceptions\PermissionsControl\ProcedureHaveNoPermissions;
use App\Exceptions\PermissionsControl\ProcedureHaveNoTrait;
use App\Exceptions\PermissionsControl\ProcedurePermissionsEmpty;
use Closure;
use Illuminate\Http\Request;

class PermissionControl
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $procedure = $request->route()->parameters()['procedures'][0];
        $method = explode('@', $request->toArray()['method'])[1];

        if ($this->isProcedureValidForPermissions($procedure)) {
            $permission = $procedure::getPermissionsForMethod($method);

            if ($permission && $request->user()->can($permission)) {
                return $next($request);
            } else {
                abort(403, 'Access denied');
            }
        }
    }

    private function isProcedureValidForPermissions($procedure): bool
    {
        if (in_array('App\Traits\ProcedurePermissionControl', class_uses($procedure))) {
            if (property_exists($procedure, 'permissions')) {
                if (!empty($procedure::getPermissions())) {
                    return true;
                }
                throw new ProcedurePermissionsEmpty($procedure);
            }
            throw new ProcedureHaveNoPermissions($procedure);
        }
        throw new ProcedureHaveNoTrait($procedure);
    }
}
