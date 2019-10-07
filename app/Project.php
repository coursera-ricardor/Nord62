<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    //


    /* -----------------------------------------------------
     * Relationships
    /* -----------------------------------------------------

    /*
        Profiles associated with the Project
        Without the second paramenter the Pivot table name: 'profile_project'
        Validate the 3rd and 4rd Paramenters They are switched in each linked Model
    */
    public function profiles() {
        return $this->belongsToMany('App\Profile','profile_has_projects','project_id','profile_id');
    }

}
