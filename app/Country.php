<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
	/**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name','full_name',
		'cca2', 'cca3', 'ccn3', 
		'capital',
		'region_code','region','subregion_code','subregion',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
    ];

}
