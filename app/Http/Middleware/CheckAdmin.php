<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * //     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     * @return \Illuminate\Http\RedirectResponse|mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (Auth::user()->roles_id !== 1){
//            notify()->success('test');
//            connectify('success','error','error');
//            drakify('success');
//            smilify('success', 'You are successfully reconnected');
//            emotify('success', 'You are awesome, your data was successfully created');
            return back()->with('denied','Access denied !');
//            return back()->notify()->success('test');
        }
        return $next($request);
    }
}
