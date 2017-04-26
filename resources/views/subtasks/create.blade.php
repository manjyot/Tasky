@extends('layouts.master')

@section('content')

    <h1>Add a New Subtask</h1>
    <p class="lead">Adding to your task - '{{$task->title}}'. <a href="{{ route('tasks.show', $task->id) }}">Go back to task.</a></p>
    <hr>

    {!! Form::open([
        'route' => 'subtasks.store'
    ]) !!}

    <div class="form-group @if ($errors->get('title')): has-error @endif">
        {!! Form::label('title', 'Title:', ['class' => 'control-label']) !!}
        {!! Form::text('title', null, ['class' => 'form-control']) !!}
        @if ($errors->has('title'))
            <p class="help-block">{{ $errors->first('title') }}</p>
        @endif
    </div>

    <div class="form-group @if ($errors->get('description')): has-error @endif">
        {!! Form::label('description', 'Description:', ['class' => 'control-label']) !!}
        {!! Form::textarea('description', null, ['class' => 'form-control']) !!}
        @if ($errors->has('description'))
            <p class="help-block">{{ $errors->first('description') }}</p>
        @endif
    </div>

    {!! Form::hidden('task_id', $task->id) !!}

    {!! Form::submit('Create New Subtask', ['class' => 'btn btn-primary']) !!}

    {!! Form::close() !!}
@stop