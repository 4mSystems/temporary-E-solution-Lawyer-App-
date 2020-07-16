<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'type', 'password','email','cat_id','parent_id','phone','address','package_id','status'
    ];

    public function
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getStatusAttribute($value)
    {

        if ($value == 'Demo') {
            return trans('site_lang.statusDemo');
        } else if ($value == 'Active'){
            return trans('site_lang.statusActive');
        }else{
            return trans('site_lang.statusDeactive');
        }
    }
}
