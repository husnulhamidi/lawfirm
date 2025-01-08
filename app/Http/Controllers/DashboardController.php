<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use NumberFormatter;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

use App\Models\Batubara;
use App\Models\Bbm;
use App\Models\Biomasa;
use App\Models\Delivery;
use App\Models\GasPipa;
use App\Models\Hba;
use App\Models\Icp;
use App\Models\Kurs;
use App\Models\Lng;
use App\Models\MotherVessel;
use App\Models\MotherVesselStatus;
use App\Models\StrategicObjectives;
use App\Models\RunningText;

use App\Traits\DashboardService;

class DashboardController extends Controller
{
    use DashboardService;

    public function __construct() {
        date_default_timezone_set('asia/jakarta');
    }

    public function index()
    {
        /* dashboard admin */
        $page_title =" Dashboard";
        $startDate =date("Y-m-d");
        $endDate =date("Y-m-d");
        $role_id = auth()->user()->role_id;
        //$dt = $this->dashboardadmin();
        //$latest_date = $this->latestDate();
        //return response()->json($latest_date);die;
        return view('pages.dashboard.dashboard',compact('page_title','role_id','startDate','endDate'));
    }

    public function dashboard()
    {
        
        $page_title =" Dashboard";
        $startDate =date("Y-m-d");
        $endDate =date("Y-m-d");
        $type =1;
        //$top_rt = $this->topRunningText();
        //$bottom_rt =$this->bottomRunningText();
        $latest_date = $this->latestDate();
        $running_text = $this->runningText();
        //return response()->json($running_text);die;
        return view('frontend.dashboard',compact('page_title','startDate','endDate','running_text','type','latest_date'));
    }

    public function dashboardDetail()
    {
        
        $page_title =" Dashboard";
        $startDate =date("Y-m-d");
        $endDate =date("Y-m-d");
        $type =2;
        $running_text = $this->runningText();
        $latest_date = $this->latestDate();
        return view('frontend.dashboard',compact('page_title','startDate','endDate','running_text','type','latest_date'));
    }

    private function latestDate(){
        $date = "updated_at";
        $jamali = Batubara::select($date)->where("realisasi",">",0)->where("area","Jamali")->latest($date)->first();
        $sumkal = Batubara::select($date)->where("realisasi",">",0)->where("area","Sumkal")->latest($date)->first();
        $sulmapa = Batubara::select($date)->where("realisasi",">",0)->where("area","Sulmapa")->latest($date)->first();
        $biomasa = Biomasa::select($date)->where("realisasi",">",0)->latest($date)->first();
        $gaspipa = GasPipa::select($date)->where("realisasi",">",0)->latest($date)->first();
        $lng = Lng::select($date)->where("realisasi",">",0)->latest($date)->first();
        $bbm = Bbm::select($date)->where("realisasi",">",0)->latest($date)->first();

       if(!empty($jamali)){
            $latest_jamali = $jamali->updated_at;
       }
       if(!empty($sumkal)){
            $latest_sumkal = $sumkal->updated_at;
       }
       if(!empty($sulmapa)){
            $latest_sulmapa = $sulmapa->updated_at;
       }
       if(!empty($biomasa)){
         $latest_biomasa = $biomasa->updated_at;
        }

        if(!empty($gaspipa)){
            $latest_gaspipa = $gaspipa->updated_at;
        }

        if(!empty($lng)){
            $latest_lng = $lng->updated_at;
        }
        if(!empty($bbm)){
            $latest_bbm = $bbm->updated_at;
        }

        $dates = array(
            @$latest_jamali, @$latest_sumkal,@$latest_sulmapa,@$latest_biomasa,@$latest_gaspipa,@$latest_lng,@$latest_bbm 
        );

        $unix = array_map('strtotime', $dates);

        $data = array(
            "earliest"  => date('d F Y', min($unix)),
            "latest"    => date('d F Y', max($unix)),
            "dates"     => $dates
        );

        return $data;


    }

    private function runningText(){
        $posisi = RunningText::all();
        $kurs_hba_icp = $this->kurs_hba_icp();
        $statusVessel = $this->statusVessel();
        $deliveryPlan = $this->deliveryPlan();
        $so = $this->so();
        $top = array();
        $bottomTop = array();
        $bottom = array();
        foreach ($posisi as $key => $val) {
            if($val->position=='Top'){
                if($val->object_name=='Kurs-HBA-ICP'){
                    $top_rt = $kurs_hba_icp;
                }
                else if($val->object_name=='Status Vessel'){
                    $top_rt = $statusVessel;
                }
                else if($val->object_name=='Delivery Plan'){
                    $top_rt = $deliveryPlan;
                }
                else if($val->object_name=='Status SO'){
                    $top_rt = $so;
                }
                else{
                    $top_rt = array();
                }

                // if($val->object_name=='Status Vessel'){
                //     $vessel_top = $statusVessel;
                // }else{
                //     $vessel_top = array();
                // }
                $top[] =$top_rt;
            }

            if($val->position=='Bottom Top'){
                if($val->object_name=='Kurs-HBA-ICP'){
                    $bottomTop_rt = $kurs_hba_icp;
                }
                else if($val->object_name=='Status Vessel'){
                    $bottomTop_rt = $statusVessel;
                }
                else if($val->object_name=='Delivery Plan'){
                    $bottomTop_rt = $deliveryPlan;
                }
                else if($val->object_name=='Status SO'){
                    $bottomTop_rt = $so;
                }
                else{
                    $bottomTop_rt = array();
                }

                $bottomTop[] =$bottomTop_rt;
            }

            if($val->position=='Bottom'){
                if($val->object_name=='Kurs-HBA-ICP'){
                    $bottom_rt = $kurs_hba_icp;
                }
                else if($val->object_name=='Status Vessel'){
                    $bottom_rt = $statusVessel;
                }
                else if($val->object_name=='Delivery Plan'){
                    $bottom_rt = $deliveryPlan;
                }
                else if($val->object_name=='Status SO'){
                    $bottom_rt = $so;
                }
                else{
                    $bottom_rt = array();
                }

                $bottom[] =$bottom_rt;
            }

        }

        $top_data = array();
        foreach ($top as $key => $value) {
            foreach ($value as $key => $val) {
                $top_data[] = $val;
            }
        }

        $bottom_top_data = array();
        foreach ($bottomTop as $key => $value) {
            foreach ($value as $key => $val) {
                $bottom_top_data[] = $val;
            }
        }

        $bottom_data = array();
        foreach ($bottom as $key => $value) {
            foreach ($value as $key => $val) {
                $bottom_data[] = $val;
            }
        }

        $result = array(
            "top" => $top_data,
            "bottom_top" =>$bottom_top_data,
            "bottom"  =>$bottom_data,
            "top_count" => count($top_data),
            "bottom_top_count" =>count($bottom_top_data),
            "bottom_count"  =>count($bottom_data),
        );
        return $result;
    }

    private function kurs_hba_icp(){
        $kurs = Kurs::latest()->first();
        $Icp = Icp::latest()->first();
        $Hba = Hba::latest()->first();
        $data = array(
            "USD~IDR ".number_format($kurs->rate,2,',','.')." ",
            "HBA USD ".number_format($Hba->hba,2,',','.')." ",
            "ICP USD ".number_format($Icp->icp,2,',','.')." "
        );

        return $data;
    }

    private function statusVessel(){
        $mvessel = MotherVessel::get();
        $data_status = array();
        foreach ($mvessel as $key => $val) {
            # code...
            $data_status[] = $val->name." : ".$val->status;
        }

        return $data_status;
    }

    private function deliveryPlan(){
        $date = Carbon::now()->format("Y-m-d");
        $deliv = Delivery::with(["pembangkit"])->whereRaw("eta >= CONCAT(DATE_SUB(SUBSTR(NOW(),1,10), INTERVAL 30 DAY), ' 00:00:00')")->get();
        $delivery = array();
        foreach ($deliv as $key => $val) {
            # code...
            $delivery[] = $val->pembangkit->name." ".number_format($val->jumlah,0,',','.')." Ton (ETA ".Carbon::parse($val->eta)->format("d F Y").")";
        }

        return $delivery;
    }

    private function so(){
        $so = StrategicObjectives::all();
        $data_status = array();
        foreach ($so as $key => $val) {
            $label = $val->no!=""?$val->no."-".$val->name:$val->name;
            if(strtolower($val->status)=='in progress' OR strtolower($val->status)=='inprogress'){
                $percent=" (".$val->persentase."%)";
            }else{
                $percent="";
            }
            $data_status[] = $label." : ".$val->status.$percent;
        }

        return $data_status;
    }


    public function batubara(Request $req){
        $type = $req->input("type");
        $area = $req->input("area");
        $lib = libmonth($type);

        $data = $this->databatubara($area,$type,$lib);

        $data = array(
            "categories" => $lib['month_name'],
            "rencana"    => $data['rencana'],
            "realisasi"  => $data['realisasi'],
        );
        return response()->json($data);
    }

    public function biomasa(Request $req){
        $type = $req->input("type");
        $area = $req->input("area");
        $lib = libmonth($type);

        $data = $this->databiomasa($area,$type,$lib);

        $data = array(
            "categories" => $lib['month_name'],
            "rencana"    => $data['rencana'],
            "realisasi"  => $data['realisasi'],
        );
        return response()->json($data);
    }

    public function gaspipa(Request $req){
        $type = $req->input("type");
        $area = $req->input("area");
        $lib = libmonth($type);

        $data = $this->datagaspipa($area,$type,$lib);

        $data = array(
            "categories" => $lib['month_name'],
            "rencana"    => $data['rencana'],
            "realisasi"  => $data['realisasi'],
        );
        return response()->json($data);
    }

    public function lng(Request $req){
        $type = $req->input("type");
        $area = $req->input("area");
        $lib = libmonth($type);

        $data = $this->datalng($area,$type,$lib);

        $data = array(
            "categories" => $lib['month_name'],
            "rencana"    => $data['rencana'],
            "realisasi"  => $data['realisasi'],
        );
        return response()->json($data);
    }

    public function bbm(Request $req){
        $type = $req->input("type");
        $area = $req->input("area");
        $lib = libmonth($type);

        $data = $this->databbm($area,$type,$lib);

        $data = array(
            "categories" => $lib['month_name'],
            "rencana"    => $data['rencana'],
            "realisasi"  => $data['realisasi'],
        );
        return response()->json($data);
    }

    

}
