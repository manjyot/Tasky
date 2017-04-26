@extends('layouts.master')

@section('content')

    <h1>Task List</h1>
    <p class="lead">Here's a list of @if(Auth::user()->hasRole('User')) your @else all @endif tasks. <a href="{{ route('tasks.create') }}">Add a new one?</a></p>
    <hr>

    @if(Session::has('flash_message'))
        <div class="alert alert-success fade in">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            {{ Session::get('flash_message') }}
        </div>
    @endif

    @if($tasks->count() == 0)
        <div class="well text-center">No tasks added</div>
    @endif

    @foreach($tasks as $task)
    <div class="task">
        <h3>
            {{ $task->title }} <span class="subtask-count lead">(No. of Subtasks - {{ count($task->subtasks)}})</span>
            <span class="task-status">
                @if ($task->status == 2) 
                    <span class="label label-warning">Pending</span>
                @elseif ($task->status == 1)
                    <span class="label label-primary">Active</span>
                @else
                    <span class="label label-success">Completed</span>
                @endif
            </span>
            @if (Auth::user()->hasAnyRoles(['Admin', 'Moderator'])) 
                <span class="task-user">
                    <span class="glyphicon glyphicon-user"></span> {{$task->user->name}} @if($task->user_id == Auth::user()->id) (My Task) @endif
                </span>
            @endif
        </h3>
        <p>{{ $task->description}}</p>

        <div class="row">
            <div class="col-md-6">
                <a href="{{ route('tasks.show', $task->id) }}" class="btn btn-info">View Task</a>
                <a href="{{ route('tasks.edit', $task->id) }}" class="btn btn-primary">Edit Task</a>
            </div>
            <div class="col-md-6 text-right">
                @if (!Auth::user()->hasRole('Admin') AND $task->user_id == Auth::user()->id) 
                    {!! Form::open([
                        'method' => 'DELETE',
                        'route' => ['tasks.destroy', $task->id]
                    ]) !!}
                    {!! Form::submit('Delete this task?', ['class' => 'btn btn-danger']) !!}
                    {!! Form::close() !!}
                @endif

                @if (Auth::user()->hasRole(['Admin']))
                    {!! Form::open([
                        'method' => 'DELETE',
                        'route' => ['tasks.destroy', $task->id]
                    ]) !!}
                    {!! Form::submit('Delete this task?', ['class' => 'btn btn-danger']) !!}
                    {!! Form::close() !!}
                @endif 
            </div>
        </div>
    </div>
    <hr>
    @endforeach

@stop