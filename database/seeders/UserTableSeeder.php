<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\DB;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users= array(
            [
                "name"      => "Administrator",
                "username"  => "Admin",
                "email"     => "admin@gmail.com",
                "password"  => Hash::make(12345678),
                "role_id"   => 1
            ],
            [
                
                "name"      => "User Jamali",
                "username"  => "jamali",
                "email"     => "jamali@gmail.com",
                "password"  => Hash::make(12345678),
                "role_id"   => 2
            ],
            [
                
                "name"      => "User Sukmal",
                "username"  => "sukmal",
                "email"     => "sukmal@gmail.com",
                "password"  => Hash::make(12345678),
                "role_id"   => 2
            ],
            [
                
                "name"      => "User Sulmapa",
                "username"  => "sulmapa",
                "email"     => "sulmapa@gmail.com",
                "password"  => Hash::make(12345678),
                "role_id"   => 2
            ],
            [
                
                "name"      => "User Biomasa",
                "username"  => "biomasa",
                "email"     => "biomasa@gmail.com",
                "password"  => Hash::make(12345678),
                "role_id"   => 2
            ],
            [
                
                "name"      => "User Gas Pipa",
                "username"  => "gaspipa",
                "email"     => "gaspipa@gmail.com",
                "password"  => Hash::make(12345678),
                "role_id"   => 2
            ],
            [
                
                "name"      => "User LNG",
                "username"  => "lng",
                "email"     => "lng@gmail.com",
                "password"  => Hash::make(12345678),
                "role_id"   => 2
            ],
            [
                
                "name"      => "User BBM",
                "username"  => "bbm",
                "email"     => "bbm@gmail.com",
                "password"  => Hash::make(12345678),
                "role_id"   => 2
            ],
            [
                
                "name"      => "Manegement",
                "username"  => "manegement",
                "email"     => "manegement@gmail.com",
                "password"  => Hash::make(12345678),
                "role_id"   => 3
            ],
            
        );
        DB::table('users')->insert($users);
    }
}
