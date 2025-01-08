<?php

use App\Models\SysMenu;

function menuAside()
{
    $role_id = auth()->user()->role_id;
    $data = SysMenu::select('title', 'root', 'icon', 'page', 'parent_id', 'id', 'arrow','bullet')
    ->with(['submenu' => function ($builder) use ($role_id ) {
        $builder->select('id', 'parent_id', 'title', 'page');
        $builder->whereHas('menu_action', function ($builder) use ($role_id) {
            $builder->whereHas('role_menu_access',function ($builder) use ($role_id) {
                $builder->where('role_id',$role_id);
            });
        });
    }, 'labelmenu' => function ($builder) {
        $builder->select('id', 'type', 'value', 'menu_id');
    }])
    ->whereHas('menu_action', function( $query ) use ( $role_id ){
        $query->whereHas('role_menu_access', function ($query) use ($role_id) {
            $query->where('role_id',$role_id);
        });
    })
    ->where([['is_parent', '=', '1'], ['status_code', '=', 'active']])
    ->orderBy('order','ASC')
    ->get();

    $tmp = array();
    foreach ($data as $key => $value) {
        $menu = [
            'title' => $value['title'],
            'root' => true,
            'icon' => $value['icon'], 
            'page' => $value['page'],
            'new-tab' => false,
        ];

        $tmp[$key]['items'] = $menu;
        if(!empty($value['labelmenu'])){
            foreach ($value['labelmenu'] as $label) {
                $tmp[$key]['items']['label'] = [
                    'type' => $label['type'],
                    'value' => $label['value']
                ];
            }
        }

        if(isset($value['submenu']) && !empty($value['submenu']) && !empty($value['arrow'])) {
            $tmp[$key]['items'] = array_merge($menu, [
                'bullet' => $value['bullet'],
                'arrow' => true,
                'submenu' => $value['submenu']->toArray(),
            ]);
        }
    }
    
    return $tmp;
}
