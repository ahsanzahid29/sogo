<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //--
        $user = User::where('email', 'superadmin@yopmail.com')->first();
        if (empty($user)) {
            User::create(
                [
                    'name'     => 'Super Admin',
                    'email'    => 'superadmin@yopmail.com',
                    'password' => Hash::make('123456789'),
                    'role_id'  => 1,
                    'status'   => 'Active',
                ]
            );
        }
    }
}
