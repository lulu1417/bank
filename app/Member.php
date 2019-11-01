<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Member extends Authenticatable
{
    protected $fillable = [
        'account', 'password', 'balance', 'api_token'
    ];
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'api_token',
    ];

    function record()
    {
        $information = Member::where(function ($query) {
            $query->where('remittance', 'account')->orWhere('payee', 'account');
        });
    }

}
