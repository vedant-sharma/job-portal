<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    protected $fillable = [
    	'title',
    	'description',
    	'company',
    	'user_id',
    	'uuid'
    ];

    public function user(){

    	return $this->belongsTo('App\Models\User');
    }

    public function applications()
    {
        return $this->hasMany('App\Models\AppliedJob', 'job_id');
    }

     public function userapplications()
    {
        return $this->belongsToMany('App\Models\User', 'applied_jobs');
    }
}
