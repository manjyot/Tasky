<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;
use App\Task;
use App\SubTask;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;

class SubtasksController extends Controller
{   
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($task_id)
    {
        $task = Task::where('id', $task_id)->first();
        return view('subtasks.create', compact('task'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
            'description' => 'required',
            'task_id' => 'required'
        ]);

        $input = $request->all();

        SubTask::create($input);

        Session::flash('flash_message', 'Subtask successfully added!');

        return redirect()->route('tasks.show', $input['task_id']);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = Auth::user();
        $subtask = Subtask::findOrFail($id);

        $usersubtasks = $user->subtasks()->get();
        $flag = 0;
        foreach($usersubtasks as $usub){
            if($usub->id == $subtask->id){
                $flag++;
            }
        }

        if(!$user->hasAnyRoles(['Admin', 'Moderator']) && $flag == 0){
            return Redirect::back()->with('message', 'Insufficient permissions');
        }
        
        return view('subtasks.edit', compact('subtask'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = Auth::user();
        $subtask = SubTask::findOrFail($id);

        $usersubtasks = $user->subtasks()->get();
        $flag = 0;
        foreach($usersubtasks as $usub){
            if($usub->id == $subtask->id){
                $flag++;
            }
        }

        if(!$user->hasAnyRoles(['Admin', 'Moderator']) && $flag == 0){
            return Redirect::back()->with('message', 'Insufficient permissions');
        }

        $this->validate($request, [
            'title' => 'required',
            'description' => 'required',
            'status' => 'required'
        ]);

        $input = $request->all();

        $subtask->fill($input)->save();

        Session::flash('flash_message', 'Subtask successfully modified!');
        
        return redirect()->route('tasks.show', $subtask->task_id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = Auth::user();
        $subtask = SubTask::findOrFail($id);

        $usersubtasks = $user->subtasks()->get();
        $flag = 0;
        foreach($usersubtasks as $usub){
            if($usub->id == $subtask->id){
                $flag++;
            }
        }

        if(!$user->hasRole('Admin') && $flag == 0){
            return Redirect::back()->with('message', 'Insufficient permissions');
        }
        
        $subtask->delete();

        Session::flash('flash_message', 'Subtask successfully deleted!');

        return redirect()->back();
    }
}