<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string ...$guards): Response
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                // Anyone who isn't an actual student (super admins and staff
                // accounts alike) lands on the dashboard; only real students
                // get redirected to the student materials page.
                if (is_null(Auth::user()->student_id)) {
                    return redirect(RouteServiceProvider::HOME);
                }else {
                    return redirect(RouteServiceProvider::STUDENT);
                }
            }
        }

        return $next($request);
    }
}
