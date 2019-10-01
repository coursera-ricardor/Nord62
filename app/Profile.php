<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

// Notifications
// use Illuminate\Notifications\Notifiable;

// Access Control List
use Spatie\Permission\Traits\HasRoles;


class Profile extends Model
{

    // use Notifiable;

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
        'user_id',
        'name','first_name','last_name','email',
        'status',
        'language_id','language_code','language',
        'country_id','country_code','country','state_id','state_code','state','zip_code',
        'street','street_number','city',
        'latitude','longitude','owner_id','updated_by','status',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        // 'owner_id' => 'integer',
    ];


    /*
        Get the User associated with the Profile
    */
    public function user() {
        return $this->belongsTo('App\User');
    }
}
