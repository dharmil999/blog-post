<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Permission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        
        
        if(($request->is('admin/users') || $request->is('admin/users/*')) && auth()->user()->role_id != config('const.ADMIN_ROLE')) {
            abort(403,'You are not allowed to access this page');
        }
        // dd($request->is('admin/users'));
        // if ($reque) {
        //     # code...
        // }
        return $next($request);
    }
}
