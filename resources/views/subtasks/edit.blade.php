@extends('layouts.master')

@section('content')

    <h1>Edit '{{ $subtask->title }}' Subtask</h1>
    <p class="lead">Edit this subtask below. <a href="{{ route('tasks.show', $subtask->task_id) }}">Go back to task.</a></p>
    <hr>

    {!! Form::model($subtask, [
        'method' => 'PATCH',
        'route' => ['subtasks.update', $subtask->id]
    ]) !!}

    <div class="form-group @if ($errors->get('title')): has-error @endif">
        {!! Form::label('title', 'Title:', ['class' => 'control-label']) !!}
        {!! Form::text('title', null, ['class' => 'form-control']) !!}
        @if ($errors->has('title'))
            <p class="help-block">{{ $errors->first('title') }}</p>
        @endif
    </div>

    <div class="form-group @if ($errors->get('status')): has-error @endif">
        {!! Form::label('description', 'Status:', ['class' => 'control-label']) !!}
        {!! Form::select('status', ['0' => 'Completed', '1' => 'Active', '2' => 'Pending'], $subtask->status, ['class' => 'form-control']); !!}
        @if ($errors->has('description'))
            <p class="help-block">{{ $errors->first('description') }}</p>
        @endif
    </div>

    <div class="form-group @if ($errors->get('description')): has-error @endif">
        {!! Form::label('description', 'Description:', ['class' => 'control-label']) !!}
        {!! Form::textarea('description', null, ['class' => 'form-control']) !!}
        @if ($errors->has('description'))
            <p class="help-block">{{ $errors->first('description') }}</p>
        @endif
    </div>

    {!! Form::submit('Update Subtask', ['class' => 'btn btn-primary']) !!}

    {!! Form::close() !!}

@stop