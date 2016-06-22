<?php namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;

class isAdmin {

    protected $auth;

    public function __construct(Guard $auth){
        $this->auth = $auth;
    }

    public function handle($request, Closure $next){
        //Если юзер не авторизован
        if ($this->auth->guest()) {
            //Если запрос был послан через ajax
            if ($request->ajax()) 
                return response('Unauthorized.', 401);
            else
                return redirect()->guest('auth/login'); 
        }

        //Проверяем является ли пользователь администратором
        if(\Auth::User()->role !== 'admin' && \Auth::User()->role !== 'ander'){
            //Если нет, перебрасываем просто в ЛК
            return redirect('/');
        }

        return $next($request);
    }
}