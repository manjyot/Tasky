<?php

use Illuminate\Database\Seeder;
use App\Role;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role_user = new Role();
        $role_user->name = 'User';
        $role_user->description = 'A normal user';
        $role_user->save();

        $role_author = new Role();
        $role_author->name = 'Moderator';
        $role_author->description = 'A Moderator';
        $role_author->save();

        $role_admin = new Role();
        $role_admin->name = 'Admin';
        $role_admin->description = 'An admin';
        $role_admin->save();
    }
}
