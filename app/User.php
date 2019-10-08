<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

// Access Control List
use Spatie\Permission\Traits\HasRoles;


class User extends Authenticatable
{
    use Notifiable;

    /**
     * @todo: Add the Spatie\Permission\Traits\HasRoles trait
     *
    */
    use HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username', // @todo: enable the field to be updated
        'name', 'email', 'password',
        'status', // A-ctive P-rotected  B-locked R-estricted C-onfirmation Required
    ];

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

    /**
    *
    * Profile Relationship
    */
    public function profile(){
        return $this->hasOne('App\Profile');
    }



}
