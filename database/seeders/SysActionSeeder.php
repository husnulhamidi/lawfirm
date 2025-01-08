<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\DB;

class SysActionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $act= array(
            [
                "action_name"          => "View",
                "action_function"      => "index",
            ],
            [
                "action_name"          => "Add",
                "action_function"      => "add",
            ],
            [
                "action_name"          => "Update",
                "action_function"      => "update",
            ],
            [
                "action_name"          => "Delete",
                "action_function"      => "delete",
            ],
            
           
        );
        DB::table('sys_actions')->insert($act);
    }
}
