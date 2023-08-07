<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $user = new User();
        $user->name     = 'admin';
        $user->email    = 'admin@hellofritz.com';
        $user->password = Hash::make('password');
        $user->save();

        $roles = Role::whereIn('id', ['1'])->get();

        // Assign the role to the user
        $user->roles()->sync($roles);        
    }
}
