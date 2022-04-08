<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class IsProdi
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
        if (\Auth::user() &&  \Auth::user()->roles == 'prodi' || \Auth::user()->roles == 'admin') {
            return $next($request);
        }
        else if(\Auth::user()->roles == 'mahasiswa'){
            return redirect('perkuliahan');
        }else{
            return redirect('dashboard');
        }
    }
}
