<?php

namespace Illuminate\Support\Facades;

/**
 * @see \Illuminate\Auth\AuthManager
 * @see \Illuminate\Auth\Guard
 */
class Auth extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'auth';
    }


    public static function getRole() {
    	if(Auth::user()->role == 'retail' || Auth::user()->role == 'admin') {
    		return 'retail';
    	} else {
    		return 'wholesaler';
    	}
    }
}
