<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

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
                    'uuid'     => (string) Str::uuid(),
                ]
            );
        }
        $user = User::where('email', 'firstadmin@yopmail.com')->first();
        if (empty($user)) {
            User::create(
                [
                    'name'     => 'First Admin',
                    'email'    => 'firstadmin@yopmail.com',
                    'password' => Hash::make('123456789'),
                    'role_id'  => 2,
                    'status'   => 'Active',
                    'uuid'     => (string) Str::uuid(),
                ]
            );
        }
        $user = User::where('email', 'firstdealer@yopmail.com')->first();
        if (empty($user)) {
            User::create(
                [
                    'name'     => 'First Dealer',
                    'email'    => 'firstdealer@yopmail.com',
                    'password' => Hash::make('123456789'),
                    'role_id'  => 3,
                    'status'   => 'Active',
                    'uuid'     => (string) Str::uuid(),
                ]
            );
        }
        $user = User::where('email', 'firstsc@yopmail.com')->first();
        if (empty($user)) {
            User::create(
                [
                    'name'     => 'First Service User',
                    'email'    => 'firstsc@yopmail.com',
                    'password' => Hash::make('123456789'),
                    'role_id'  => 4,
                    'status'   => 'Active',
                    'uuid'     => (string) Str::uuid(),
                ]
            );
        }
    }
}
