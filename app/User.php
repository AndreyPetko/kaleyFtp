<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Auth;
use DB;

class User extends Model implements AuthenticatableContract,
AuthorizableContract,
CanResetPasswordContract
{
    use Authenticatable, Authorizable, CanResetPassword;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'email', 'password', 'role', 'phone', 'address', 'discount'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];


    public static function editItem($request) {
        self::find(Auth::user()->id)->update($request);
    }


    public static function getRetail() {
        $users = DB::table('users')->where('role', 'retail')->orderby('id', 'desc')->get();
        return $users;
    }


    public static function getWholesalers() {
        $users = DB::table('users')->where('role', 'wholesaler')->orderBy('id', 'desc')->get();
        return $users;
    }

    public static function deleteItem($id) {
        DB::table('users')->where('id', $id)->delete();
    }

    public static function makeWholesaler($id) {
        DB::table('users')->where('id', $id)->update(['role' => 'wholesaler']);
    }

    public static function getByQuery($query, $role) {
        return DB::table('users')->where('name', 'like', '%' . $query . '%')->where('role', $role)->get();
    }

    public  function setDiscount($total) {
        if($total > 2000) {
            $this->update(['discount' => 2]);
        }

        if($total > 3000) {
            $this->update(['discount' => 3]);
        }
    }


    public static function getCount($type) {
        if($type == 'admin') {
            $count = self::where('role', 'retail')->count();
        } else {
            $count = self::where('role', 'wholesaler')->count();
        }

        return $count;
    }

}
