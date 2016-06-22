<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Auth;
use App\Cart;
use App\Wishlist;
use App\Comparison;
use Redirect;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    protected $redirectTo = '/';

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'getLogout']);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|confirmed|min:6',
            'address' => 'required',
            'phone' => 'required'
            ]);
    }


    public function getAdminLogin() {
        return view('admin.login');
    }

    public function authenticate() {
      if (Auth::attempt(['email' => $_POST['email'], 'password' => $_POST['password']])) {
        Cart::cookieToCart();
        Wishlist::cookieToWishlist();
        Comparison::cookieToComparison();
        return redirect()->intended('/');
    } else {
            return redirect('login')->with('error', 1);
        }

        // return Redirect::to('login')->with('error', 1);
}


    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'phone' => $data['phone'],
            'address' => $data['address'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'role' => 'retail'

            ]);
    }
}
