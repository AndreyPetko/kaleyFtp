<?php

namespace Illuminate\Foundation\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Cart;
use App\Wishlist;
use App\Comparison;

trait RegistersUsers
{
    use RedirectsUsers;

    /**
     * Show the application registration form.
     *
     * @return \Illuminate\Http\Response
     */
    public function getRegister()
    {
        $breadcrumbs = ['/register' => 'Регистрация'];
        return view('auth.register')->with('breadcrumbs', $breadcrumbs);
    }

    /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function postRegister(Request $request)
    {
        $validator = $this->validator($request->all());

        if ($validator->fails()) {
            $this->throwValidationException(
                $request, $validator
                );
        }

        Auth::login($this->create($request->all()));

        Cart::cookieToCart();
        Wishlist::cookieToWishlist();
        Comparison::cookieToComparison();

        return redirect($this->redirectPath())->with('register', 1);
    }
}
