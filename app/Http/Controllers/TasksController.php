<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;
use App\Task;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;

class TasksController extends Controller
{   
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        $user = Auth::user();

        if($user->hasAnyRoles(['Admin', 'Moderator'])){
            $tasks = Task::with('user')->with('subtasks')->latest('updated_at')->get();
        }
        else{
            $tasks = Task::where('user_id', $user->id)->with('subtasks')->latest('updated_at')->get();
        }

        return view('tasks.index', compact('tasks'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('tasks.create');
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
            'description' => 'required'                                                              
        ]);

        $input = $request->all();
        $input['user_id'] = Auth::user()->id;

        Task::create($input);

        Session::flash('flash_message', 'Task successfully added!');

        return redirect()->route('tasks.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {   
        $user = Auth::user();
        $task = Task::findOrFail($id);
        $subtasks = $task->subtasks()->latest('created_at')->get();                                                                                                                      
        if(!$user->hasAnyRoles(['Admin', 'Moderator']) && $task->user_id != $user->id){
            return Redirect::back()->with('message', 'Insufficient permissions');
        }
        return view('tasks.show', compact('task', 'subtasks'));
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
        $task = Task::findOrFail($id);

        if(!$user->hasAnyRoles(['Admin', 'Moderator']) && $task->user_id != $user->id){
            return Redirect::back()->with('message', 'Insufficient permissions');
        }
        return view('tasks.edit', compact('task'));
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
        $task = Task::findOrFail($id);

        if(!$user->hasAnyRoles(['Admin', 'Moderator']) && $task->user_id != $user->id){
            return Redirect::back()->with('message', 'Insufficient permissions');
        }
        $this->validate($request, [
            'title' => 'required',
            'description' => 'required',
            'status' => 'required'
        ]);

        $input = $request->all();

        $task->fill($input)->save();

        Session::flash('flash_message', 'Task successfully modified!');

        return redirect()->route('tasks.index');
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
        $task = Task::findOrFail($id);

        if(!$user->hasRole('Admin') && $task->user_id != $user->id){
            return Redirect::back()->with('message', 'Insufficient permissions');
        }

        $deleted = $task->delete();
        
        Session::flash('flash_message', 'Task successfully deleted!');

        return redirect()->route('tasks.index');
    }
}