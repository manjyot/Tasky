@extends('layouts.master')

@section('content')
    
    @if(Session::has('flash_message'))
        <div class="alert alert-success fade in">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            {{ Session::get('flash_message') }}
        </div>
    @endif

    <div class="show-task">
        <h1>{{ $task->title }}</h1>
        <span class="task-status">
            @if ($task->status == 2) 
                <span class="label label-warning">Pending</span>
            @elseif ($task->status == 1)
                <span class="label label-primary">Active</span>
            @else
                <span class="label label-success">Completed</span>
            @endif
        </span>
        <p class="lead">{{ $task->description }}</p>

        <div class="row">
            <div class="col-md-6">
                <a href="{{ route('tasks.index') }}" class="btn btn-info">Back to all tasks</a>
                <a href="{{ route('tasks.edit', $task->id) }}" class="btn btn-primary">Edit Task</a>
                <a href="{{ route('subtasks.create', $task->id) }}" class="btn btn-warning">Add Subtask</a>
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

    @if($subtasks->count() == 0)
        <div class="well text-center no-subtasks">No subtasks added</div>
    @else
        <table class="table table-bordered table-striped subtasks">
            <thead>
                <th>S.no</th>
                <th>Subtask</th>
                <th>Action</th>
            </thead>
            <tbody>
    @endif
            @foreach($subtasks as $subtask)
                <tr>
                    <td>
                        {{ $loop->iteration }}
                    </td>
                    <td style="width: 80%;">
                        <h3>
                            {{ $subtask->title }} 
                            <span class="subtask-status">
                                @if ($subtask->status == 2) 
                                    <span class="label label-warning">Pending</span>
                                @elseif ($subtask->status == 1)
                                    <span class="label label-primary">Active</span>
                                @else
                                    <span class="label label-success">Completed</span>
                                @endif
                            </span>
                        </h3>
                        <p>{{ $subtask->description}}</p>
                    </td>
                    <td>
                        <a href="{{ route('subtasks.edit', $subtask->id) }}" class="btn btn-primary">Edit</a>
                        {!! Form::open([
                            'method' => 'DELETE',
                            'route' => ['subtasks.destroy', $subtask->id]
                        ]) !!}
                        {!! Form::submit('Delete', ['class' => 'btn btn-danger']) !!}
                        {!! Form::close() !!}  
                    </td>
                </tr>
            @endforeach
            @if($subtasks->count() != 0)
            </tbody>
        </table>
    @endif
@stop