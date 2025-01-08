<?php

use App\Models\Invoice;
use App\Models\InvoiceHistory;
use App\Models\Pajak;
use App\Models\PajakHistory;
use App\Models\RefLiburNasional;
use App\Models\SysRoleMenuAction;
use App\Models\DelegasiPlh;
use App\Models\Saldo;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

function checkAccess($act)
{
    $role_id = auth()->user()->role_id;
    $page    = request()->path();
    $action  =  strtolower($act);
    $data = SysRoleMenuAction::select('sys_role_menu_actions.menu_action_id')
            ->leftJoin('sys_menu_actions as sma','sma.id','sys_role_menu_actions.menu_action_id')
            ->leftJoin('sys_menus as sm','sm.id','sma.menu_id')
            ->leftJoin('sys_actions as sa','sa.id','sma.action_id')
            ->where('sys_role_menu_actions.role_id',$role_id)
            ->where('sm.page',$page)
            ->where('sa.action_function',$action)
            ->first();

    if(!empty($data)){
        $return = 'true';
    }else{
        $return = 'false';
    }

    return $return;
}

function checkAccessMenu($url="")
{
    $role_id = auth()->user()->role_id;
    $page    = $url!=""?$url:request()->path();
    $data = SysRoleMenuAction::select(DB::raw('GROUP_CONCAT(sa.action_function SEPARATOR ",") as action_function'))
            ->leftJoin('sys_menu_actions as sma','sma.id','sys_role_menu_actions.menu_action_id')
            ->leftJoin('sys_menus as sm','sm.id','sma.menu_id')
            ->leftJoin('sys_actions as sa','sa.id','sma.action_id')
            ->where('sys_role_menu_actions.role_id',$role_id)
            ->where('sm.page',$page)
            ->first();

    if(!empty($data)){
        $return = $data;
    }else{
        $return = array();
    }

    return $return;
}

function libmonth($type=1){
    $now = date("Y-m");
    $bln = date("m");
    $tahun = date("Y");
    if($type==1){
        $bln_min3 =  date('m',strtotime('-3 months',strtotime($now)));
        $bln_min2 =  date('m',strtotime('-2 months',strtotime($now)));
        $bln_min1 =  date('m',strtotime('-1 months',strtotime($now)));
        $bln_plus1 =  date('m',strtotime('+1 months',strtotime($now)));
        $bln_plus2 =  date('m',strtotime('+2 months',strtotime($now)));
    
        $bln_name = date("M");
        $min3 =  date('M-Y',strtotime('-3 months',strtotime($now)));
        $min2 =  date('M-Y',strtotime('-2 months',strtotime($now)));
        $min1 =  date('M-Y',strtotime('-1 months',strtotime($now)));
        $plus1 =  date('M-Y',strtotime('+1 months',strtotime($now)));
        $plus2 =  date('M-Y',strtotime('+2 months',strtotime($now)));

        list($bln_min3_name,$bln_min3_year)= explode("-",$min3);
        list($bln_min2_name,$bln_min2_year)= explode("-",$min2);
        list($bln_min1_name,$bln_min1_year)= explode("-",$min1);
        list($bln_plus1_name,$bln_plus1_year)= explode("-",$plus1);
        list($bln_plus2_name,$bln_plus2_year)= explode("-",$plus2);
    
        $array_ori = [$bln_min3,$bln_min2,$bln_min1,$bln,$bln_plus1];
        $array_name = [$bln_min3_name,$bln_min2_name,$bln_min1_name,$bln_name,$bln_plus1_name];
        $array_year = [$bln_min3_year,$bln_min2_year,$bln_min1_year,$tahun,$bln_plus1_year];
        
    }else{
        $array_ori = ["01","02","03","04","05","06","07","08","09","10","11","12"];
        $array_name = ["Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","oct","Nov","Dec"];
        $array_year = [$tahun,$tahun,$tahun,$tahun,$tahun,$tahun,$tahun,$tahun,$tahun,$tahun,$tahun,$tahun];
    }

    $return = array(
        "month" => $bln,
        "year"  => $tahun,
        "month_ori" => $array_ori,
        "month_name" => $array_name,
        "years" => $array_year
    );
    return $return;
}

