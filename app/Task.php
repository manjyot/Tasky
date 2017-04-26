<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{	
	protected $fillable = [
        'title',
        'description',
        'user_id',
        'status'
    ];
    protected $table = 'tasks';

    public function user(){
	    return $this->belongsTo('App\User');
	}

    public function subtasks(){
        return $this->hasMany('App\SubTask');
    }

    public function delete()
    {
        $this->subtasks()->delete();
        return parent::delete();
    }
}

