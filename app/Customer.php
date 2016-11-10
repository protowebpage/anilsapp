<?php

namespace App;

use App\Notifications\CustomerResetPassword;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Http\Requests\CustomerLoginRequest;

use Illuminate\Http\Request;
use Auth;
use Validator;

class Customer extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public static function findOrCreate(Request $request)
    {

        if(Auth::guard('customer')->check()){
            $customer = Auth::guard('customer')->user();
        } else {

            Validator::make($request->all(), [
                'email' => 'required|email|max:255|unique:customers',
                'password' => 'required|confirmed',
            ])->validate();

            $customer = Customer::create([
                'email' => $request->email,
                'password' => $request->password,
            ]);

            $customer->save();
        }
        
        return $customer;        
    }

    public static function login(Request $request)
    {

        Validator::make($request->all(), [
            'email' => 'required|email|max:255|exists:customers,email',
            'password' => 'required',
        ])->validate();


        if($request->ajax()){

            if (Auth::guard('customer')->attempt(['email' => $request->email, 'password' => $request->password])) {
                return [
                    'result' => 'success',
                ];
            } else {
                return [
                    'result' => 'error',
                ];
            }

        } else {
        }

    }


    /**
     * Send the password reset notification.
     *
     * @param  string  $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new CustomerResetPassword($token));
    }

    public function setPasswordAttribute($value){
        $this->attributes['password'] = bcrypt($value);
    }

    public function orders()
    {
        return $this->hasMany('App\Order');
    }
    public function addresses()
    {
        return $this->hasMany('App\Address');
    }


}
