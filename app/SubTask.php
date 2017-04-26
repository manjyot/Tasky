<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SubTask extends Model
{	
	protected $fillable = [
        'title',
        'description',
        'task_id',
        'status'
    ];
    protected $table = 'subtasks';

    public function task(){
	    return $this->belongsTo('App\Task');
	}
}

