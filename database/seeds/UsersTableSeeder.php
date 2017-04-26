<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Role;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role_user = Role::where('name','=','User')->first();
        $role_admin = Role::where('name','=','Admin')->first();
        $role_moderator = Role::where('name','=','Moderator')->first();

        $user = new User();
        $user->name = 'Manjyot Singh';
        $user->email = 'manjyot.luv@gmail.com';
        $user->password = bcrypt('test1234');
        $user->save();
        $user->roles()->attach($role_admin);

        $admin = new User();
        $admin->name = 'John Doe';
        $admin->email = 'john@doe.com';
        $admin->password = bcrypt('johndoe');
        $admin->save();
        $admin->roles()->attach($role_user);

        $author = new User();
        $author->name = 'Jane Doe';
        $author->email = 'jane@doe.com';
        $author->password = bcrypt('janedoe');
        $author->save();
        $author->roles()->attach($role_moderator);


    }
}
