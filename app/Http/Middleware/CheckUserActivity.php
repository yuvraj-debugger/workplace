<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Session\Store;


class CheckUserActivity
{
    protected $session;
    protected $timeout = 1200;
    
    public function __construct(Store $session){
        $this->session = $session;
    }

    public function handle($request, Closure $next)
    {
        if(! session('lastActivityTime'))
            $this->session->put('lastActivityTime', time());
            elseif(time() - $this->session->get('lastActivityTime') > $this->timeout){
                $this->session->forget('lastActivityTime');
                Auth::guard('web')->logout();
                return redirect('/login')->with('status', 'You have been logged out due to inactivity.');
            }
            
            $this->session->put('last_activity', time());
            return $next($request);
    }
}


