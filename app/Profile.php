<?php

namespace App;

// use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

// Notifications
// use Illuminate\Notifications\Notifiable;

// Access Control List
use Spatie\Permission\Traits\HasRoles;


// class Profile extends Model
// class Profile extends Authenticatable
class Profile extends Model implements AuthorizableContract, AuthenticatableContract
{
    use HasRoles, Authorizable, Authenticatable;

    /**
     * @todo: Add the Spatie\Permission\Traits\HasRoles trait
     *
    */
    protected $guard_name = 'web';

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
        'latitude','longitude','created_by','updated_by','status',
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
        // 'created_by' => 'integer',
    ];

    /* -----------------------------------------------------
     * Relationships
    /* -----------------------------------------------------

    /*
        Get the User associated with the Profile
    */
    public function user() {
        return $this->belongsTo('App\User');
    }

    /*
        Projects associated with the Profile
        Without the second paramenter the Pivot table name: 'profile_project'
        Validate the 3rd and 4rd Paramenters They are switched in each linked Model
    */
    public function projects() {
        return $this->belongsToMany('App\Project','profile_project','profile_id','project_id')
            ->withPivot('created_by','updated_by','status')
            ->withTimestamps();
    }

}
