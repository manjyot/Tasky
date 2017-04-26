<?php

namespace App\Http\Controllers;

use App\User;
use App\Role;
use Illuminate\Http\Request;
use Auth;
use Session;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){

        if(Auth::check()){
            return redirect()->to('tasks');
        }
        return view('home');
    }

    public function getAdminPage()
    {
        $users = User::all();
        return view('admin', ['users' => $users]);
    }

    public function postAdminAssignRoles(Request $request)
    {
        $user = User::where('email', $request['email'])->first();
        $user->roles()->detach();
        if ($request['role_user']) {
            $user->roles()->attach(Role::where('name', 'User')->first());
        }
        if ($request['role_moderator']) {
            $user->roles()->attach(Role::where('name', 'Moderator')->first());
        }
        if ($request['role_admin']) {
            $user->roles()->attach(Role::where('name', 'Admin')->first());
        }
        Session::flash('flash_message', 'Changes successfully saved!');
        return redirect()->back();
    }
}
