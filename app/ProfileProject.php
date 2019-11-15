<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Eloquent\Relations\Pivot;

// Access Control List
use Spatie\Permission\Traits\HasRoles;



class ProfileProject extends Model
// class ProfileProject extends Pivot
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'profile_project';

    /**
     * @todo: Add the Spatie\Permission\Traits\HasRoles trait
     *
    */
    use HasRoles;
    protected $guard_name = 'web';


    /*
        Projects associated with the Profile
        Without the second paramenter the Pivot table name: 'profile_project'
        Validate the 3rd and 4rd Paramenters They are switched in each linked Model
    */
    public function profile() {
        return $this->hasOne('App\Profile','id','profile_id');
    }
    /*
        Projects associated with the Profile
        Without the second paramenter the Pivot table name: 'profile_project'
        Validate the 3rd and 4rd Paramenters They are switched in each linked Model
    */
    public function project() {
       return $this->hasOne('App\Project','id','project_id');
    }

}
