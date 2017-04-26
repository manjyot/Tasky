@extends('layouts.master')

@section('content')

    @if(Session::has('flash_message'))
        <div class="alert alert-success fade in">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            {{ Session::get('flash_message') }}
        </div>
    @endif
    
    <table class="table table-striped table-bordered">
        <thead>
        <th>E-Mail</th>
        <th>User</th>
        <th>Moderator</th>
        <th>Admin</th>
        <th>Submit</th>
        </thead>
        <tbody>
        @foreach($users as $user)
            <tr>
                <form action="{{ url('admin/assign') }}" method="post">
                    <td>{{ $user->email }} <input type="hidden" name="email" value="{{ $user->email }}"></td>
                    <td><input type="checkbox" {{ $user->hasRole('User') ? 'checked' : '' }} name="role_user"></td>
                    <td><input type="checkbox" {{ $user->hasRole('Moderator') ? 'checked' : '' }} name="role_moderator"></td>
                    <td><input type="checkbox" {{ $user->hasRole('Admin') ? 'checked' : '' }} name="role_admin"></td>
                    {{ csrf_field() }}
                    <td><button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-ok"></span> Save</button></td>
                </form>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection