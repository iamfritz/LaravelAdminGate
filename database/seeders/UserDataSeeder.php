<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;

class UserDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $user = new User();
        $user->name     = 'Admin';
        $user->email    = 'admin@hellofritz.com';
        $user->password = Hash::make('password');
        $user->save();

        $roles = Role::whereIn('name', ['admin'])->get();     
        // Assign the role to the user
        $user->roles()->sync($roles);
        
        // Testing Dummy User
        $roles = Role::whereIn('name', ['user'])->get();
        User::factory(10)->create()->each(function ($user) use ($roles) {
            $user->roles()->sync($roles);
        });
    }
}
