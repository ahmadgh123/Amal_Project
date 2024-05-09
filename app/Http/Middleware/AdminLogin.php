<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Authcontroller\Basecontroller as BaseController;

class AdminLogin extends BaseController
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $request->validate([
            'name' => 'required',
            'password' => 'required',
        ]);

        if ($request->name == 'ahmad' && $request->password == '123456') {
            //return $this->sendresponse('Admin login successfly', 200);
            return $next($request);
        } else
            return $this->senderror('un', ['error', 'un']);
    }
}
