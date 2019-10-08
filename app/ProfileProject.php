<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Eloquent\Relations\Pivot;

class ProfileProject extends Model
// class ProfileProject extends Pivot
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'profile_project';

    /*
        Projects associated with the Profile
        Without the second paramenter the Pivot table name: 'profile_project'
        Validate the 3rd and 4rd Paramenters They are switched in each linked Model
    */
    public function profiles() {
        return $this->belongsToMany('App\Profile','profiles','id','profile_id');
    }
    /*
        Projects associated with the Profile
        Without the second paramenter the Pivot table name: 'profile_project'
        Validate the 3rd and 4rd Paramenters They are switched in each linked Model
    */
    public function projects() {
       return $this->belongsToMany('App\Project','projects','id','project_id');
    }

}
