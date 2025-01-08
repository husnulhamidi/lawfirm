<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\DB;

class SysMenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $menu= array(
            [
                "parent_id"      => null,
                "order"          => 1,
                "title"          => "Dashboard",
                'icon'           => 'media/svg/icons/Design/Layers.svg', 
                'page'           => 'home',
                'bullet'         => null,
                'arrow'          => null,
                'root'           => true,
                'is_parent'      => '1'
            ],
            [
                "parent_id"      => null,
                "order"          => 2,
                'title'          => 'Batubara',
                'icon'          => 'media/svg/icons/Layout/Layout-grid.svg',
                'page'          => null,
                'bullet'        => 'line',
                'arrow'         => true,
                'root'          => true,
                'is_parent'      => '1'
                
            ],
            [
                "parent_id"      => null,
                "order"          => 3,
                'title'          => 'Biomasa',
                'icon'           => 'media/svg/icons/Design/Layers.svg', 
                'page'           => 'biomasa',
                'bullet'         => null,
                'arrow'          => null,
                'root'           => true,
                'is_parent'      => '1'
            ],
            [
                "parent_id"      => null,
                "order"          => 4,
                'title'          => 'Gas Pipa',
                'icon'           => 'media/svg/icons/Layout/Layout-4-blocks.svg', 
                'page'           => 'gaspipa',
                'bullet'         => null,
                'arrow'          => null,
                'root'           => true,
                'is_parent'      => '1'
            ],
           
            [
                "parent_id"      => null,
                "order"          => 5,
                'title'          => 'LNG',
                'icon'           => 'media/svg/icons/Shopping/Money.svg',
                'page'           => 'lng',
                'bullet'         => null,
                'arrow'          => null,
                'root'           => true,
                'is_parent'      => '1'
                
            ],
            [
               
                "parent_id"      => null,
                "order"          => 6,
                'title'         => 'BBM',
                'icon' => 'media/svg/icons/Design/Layers.svg', // or can be 'flaticon-home' or any flaticon-*
                'page'          => 'bbm',
                'bullet'         => null,
                'arrow'          => null,
                'root'          => true,
                'is_parent'      => '1'
            ],
            [
                "parent_id"      => null,
                "order"          => 7,
                'title'         => 'Auto Fill Data',
                'icon'          => 'media/svg/icons/Navigation/Arrow-to-right.svg', // or can be 'flaticon-home' or any flaticon-*
                'page'          => null,
                'bullet'        => 'line',
                'arrow'         => true,
                'root'          => true,
                'is_parent'      => '1'
            ],
            [
                "parent_id"      => null,
                "order"          => 8,
                'title'         => 'Delivery Plan',
                'icon'          => 'media/svg/icons/Navigation/Arrow-to-left.svg', // or can be 'flaticon-home' or any flaticon-*
                'page'          => 'delivery',
                'bullet'         => null,
                'arrow'          => null,
                'root'          => true,
                'is_parent'      => '1'
            ],
            [
                "parent_id"      => null,
                "order"          => 9,
                'title'         => 'Unit Pembangkit',
                'icon'          => 'media/svg/icons/Communication/Share.svg',
                'page'          => 'unit/pembangkit',
                'bullet'         => null,
                'arrow'          => null,
                'root'          => true,
                'is_parent'      => '1'
            ],
            [
                "parent_id"      => null,
                "order"          => 10,
                'title'         => 'Vessel',
                'icon'          => 'media/svg/icons/Communication/Share.svg',
                'page'          => null,
                'bullet'        => 'line',
                'arrow'         => true,
                'root'          => true,
                'is_parent'      => '1'
            ],
            [
                "parent_id"      => null,
                "order"          => 11,
                'title'          => 'Sistem',
                'icon'          => 'media/svg/icons/General/Settings-1.svg',
                'page'          => null,
                'bullet'        => 'line',
                'arrow'         => true,
                'root'          => true,
                'is_parent'      => '1'
                
            ],
            [
                'parent_id'     => 11,
                "order"          => 1,
                'title'         => 'Users',
                'icon'          => null,
                'page'          => 'system/users',
                'bullet'         => null,
                'arrow'          => null,
                'root'           => true,
                'is_parent'     =>'0',
            ],
            [
                'parent_id'     => 11,
                "order"          => 2,
                'title'         => 'Roles',
                'icon'          => null,
                'page'          => 'system/role',
                'bullet'         => null,
                'arrow'          => null,
                'root'           => true,
                'is_parent'      => '0',
            ],
            [
                'parent_id'     => 2,
                "order"          => 1,
                'title'         => 'Batubara Jamali',
                'icon'          => null,
                'page'          => 'batubara/jamali',
                'bullet'         => null,
                'arrow'          => null,
                'root'          => true,
                'is_parent'     =>'0',
            ],
            [
                'parent_id'     => 2,
                "order"          => 2,
                'title'         => 'Batubara Sumkal',
                'icon'          => null,
                'page'          => 'batubara/sumkal',
                'bullet'         => null,
                'arrow'          => null,
                'root'          => true,
                'is_parent'     =>'0',
            ],
            [
                'parent_id'     => 2,
                "order"          => 3,
                'title'         => 'Batubara Sulmapa',
                'icon'          => null,
                'page'          => 'batubara/sulmapa',
                'bullet'         => null,
                'arrow'          => null,
                'root'          => true,
                'is_parent'     =>'0',
            ],
            [
                'parent_id'     => 7,
                "order"          => 1,
                'title'         => 'Kurs USD',
                'icon'          => null,
                'page'          => 'kurs/usd',
                'bullet'         => null,
                'arrow'          => null,
                'root'          => true,
                'is_parent'     =>'0',
            ],
            [
                'parent_id'     => 7,
                "order"          => 2,
                'title'         => 'HBA',
                'icon'          => null,
                'page'          => 'hba',
                'bullet'         => null,
                'arrow'          => null,
                'root'          => true,
                'is_parent'     =>'0',
            ],
            [
                'parent_id'     => 7,
                "order"          => 3,
                'title'         => 'ICP',
                'icon'          => null,
                'page'          => 'icp',
                'bullet'         => null,
                'arrow'          => null,
                'root'          => true,
                'is_parent'     =>'0',
            ],
            [
                'parent_id'     => 10,
                "order"          => 1,
                'title'         => 'List Vessel',
                'icon'          => null,
                'page'          => 'vessel',
                'bullet'         => null,
                'arrow'          => null,
                'root'          => true,
                'is_parent'     =>'0',
            ],
            [
                'parent_id'     => 10,
                "order"          => 2,
                'title'         => 'Status Vessel',
                'icon'          => null,
                'page'          => 'vessel/status',
                'bullet'         => null,
                'arrow'          => null,
                'root'          => true,
                'is_parent'     =>'0',
            ],
          
           
           
        );
        DB::table('sys_menus')->insert($menu);
    }
}
