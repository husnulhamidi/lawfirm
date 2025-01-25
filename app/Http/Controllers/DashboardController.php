<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use NumberFormatter;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

use App\Models\Piutang;
use App\Models\PiutangDetail;
use App\Models\Order;

class DashboardController extends Controller
{
   
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
        $static = $this->dashlet();
       
        return view('pages.dashboard.dashboard',compact('page_title','role_id','startDate','endDate','static'));
    }

    private function dashlet(){
        $total_utang = Piutang::sum('nominal');
        $terbayar = PiutangDetail::sum("nominal");
        $sisa_utang = (int)$total_utang-(int)$terbayar;

        $total_invoice = Order::sum('invoice');
        $total_pengeluaran = Order::sum('pengeluaran');
        $total_keuntungan =  $total_invoice-$total_pengeluaran;

        $total_invoice_inprogres = Order::where("tahapan_proses_id",'<',9)->sum('invoice');
        $total_pengeluaran_inprogres   = Order::where("tahapan_proses_id",'<',9)->sum('pengeluaran');
        $total_inprogres_selesai = $total_invoice-$total_invoice_inprogres;
        $total_pengeluaran_selesai = $total_pengeluaran-$total_pengeluaran_inprogres;

        $keuntungan_inprogres = $total_invoice_inprogres-$total_pengeluaran_inprogres;
        $keuntungan_selesai = $total_inprogres_selesai-$total_pengeluaran_selesai;

        $jumlah_order_inprogres = Order::where("tahapan_proses_id",'<',9)->count();
        $jumlah_order_selesai = Order::where("tahapan_proses_id",9)->count();

        $result = array(
            "sisa_utang"=> "Rp. ".number_format($sisa_utang,0,",","."),
            "jumlah_order_inprogres"=> $jumlah_order_inprogres,
            "jumlah_order_selesai"  => $jumlah_order_selesai,
            "total_invoice" => "Rp. ".number_format($total_invoice,0,",","."),
            "total_pengeluaran" => "Rp. ".number_format($total_pengeluaran,0,",","."),
            "total_keuntungan" => "Rp. ".number_format($total_keuntungan,0,",","."),
            "total_invoice_inprogres" => "Rp. ".number_format($total_invoice_inprogres,0,",","."),
            "total_inprogres_selesai" => "Rp. ".number_format($total_inprogres_selesai,0,",","."),
            "total_pengeluaran_inprogres" => "Rp. ".number_format($total_pengeluaran_inprogres,0,",","."),
            "total_pengeluaran_selesai" => "Rp. ".number_format($total_pengeluaran_selesai,0,",","."),

            "total_keuntungan_inprogres" => "Rp. ".number_format($keuntungan_inprogres,0,",","."),
            "total_keuntungan_selesai" => "Rp. ".number_format($keuntungan_selesai,0,",","."),
        );
        return $result ;
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
