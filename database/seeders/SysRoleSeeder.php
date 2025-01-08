<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\DB;

class SysRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $sysRole= array(
            [
                "role"                  => "Admin",
                "is_disposisi"          => 0,
                "is_approval"           => 0,
                "is_back_document"      => 0,
                "is_confirm_document"   => 0,
                "is_update_document"    => 0,
                "is_update_text"        => 0,
            ],
            [
                "role"                  => "User BB Jamali",
                "is_disposisi"          => 0,
                "is_approval"           => 0,
                "is_back_document"      => 0,
                "is_confirm_document"   => 0,
                "is_update_document"    => 0,
                "is_update_text"        => 0,
            ],
            [
                "role"                  => "User BB Sukmal",
                "is_disposisi"          => 0,
                "is_approval"           => 0,
                "is_back_document"      => 0,
                "is_confirm_document"   => 0,
                "is_update_document"    => 0,
                "is_update_text"        => 0,
            ],
            [
                "role"                  => "User BB Sulmapa",
                "is_disposisi"          => 0,
                "is_approval"           => 0,
                "is_back_document"      => 0,
                "is_confirm_document"   => 0,
                "is_update_document"    => 0,
                "is_update_text"        => 0,
            ],
            [
                "role"                  => "User Biomasa",
                "is_disposisi"          => 0,
                "is_approval"           => 0,
                "is_back_document"      => 0,
                "is_confirm_document"   => 0,
                "is_update_document"    => 0,
                "is_update_text"        => 0,
            ],
            [
                "role"                  => "User Gas Pipa",
                "is_disposisi"          => 0,
                "is_approval"           => 0,
                "is_back_document"      => 0,
                "is_confirm_document"   => 0,
                "is_update_document"    => 0,
                "is_update_text"        => 0,
            ],
            [
                "role"                  => "User LNG",
                "is_disposisi"          => 0,
                "is_approval"           => 0,
                "is_back_document"      => 0,
                "is_confirm_document"   => 0,
                "is_update_document"    => 0,
                "is_update_text"        => 0,
            ],
            [
                "role"                  => "User BBM",
                "is_disposisi"          => 0,
                "is_approval"           => 0,
                "is_back_document"      => 0,
                "is_confirm_document"   => 0,
                "is_update_document"    => 0,
                "is_update_text"        => 0,
            ],
            [
                "role"                  => "Management",
                "is_disposisi"          => 0,
                "is_approval"           => 0,
                "is_back_document"      => 0,
                "is_confirm_document"   => 0,
                "is_update_document"    => 0,
                "is_update_text"        => 0,
            ],
            
            
           
        );
        DB::table('sys_roles')->insert($sysRole);
    }
}
