<?php

namespace App\Traits;
use Illuminate\Support\Facades\DB;
use App\Models\Batubara;
use App\Models\HopBatubara;
use App\Models\Unit;

use Carbon\Carbon;

trait DashboardService
{
    /**
     * Send a JSON response with success message.
     *
     * @param  mixed  $data
     * @param  string  $message
     * @param  int  $status
     * @return \Illuminate\Http\JsonResponse
     */

     public function databatubara($cluster,$date){
        $unit = Unit::select("cluster","unit","date","hop")
                ->leftJoin("hop_batubara as hb","hb.unit","=","units.name")
                ->where("cluster",$cluster)
                ->where("hb.date",$date)
                ->get();
        $categories = array();
        $hop = array();
        $total_kritis=0;
        $total_siaga=0;
        $total_normal=0;
        $total =0;
        foreach ($unit as $key => $val) {
            $total = $total+1;
            $categories[] = str_replace("PLTU","",$val->unit);
            
            if($val->hop<10){
                $status="Kritis";
                $total_kritis= $total_kritis+1;
            }else if($val->hop>=10 AND $val->hop<=15){
                $status="Siaga";
                $total_siaga =  $total_siaga+1;
            }else{
                $status="Normal";
                $total_normal =  $total_normal+1;
            }
          
            $hop[] = array(
                "y"         => (float)$val->hop,
                "date"      => Carbon::parse($val->date)->format("d-m-Y"),
                "status"    => $status,
                "ket"    => "Hop"
            );
            $apg = rand(1,10).'.'.rand(1,10);
            $slg = rand(1,10).'.'.rand(1,10);
            $apung[] = array(
                "y"         => (float)$apg,
                "date"      => Carbon::parse($val->date)->format("d-m-Y"),
                "status"    => "Apung",
                "ket"    => "Apung"
            );

            $sailing[] = array(
                "y"         => (float)$slg,
                "date"      => Carbon::parse($val->date)->format("d-m-Y"),
                "status"    => "Sailing",
                "ket"    => "Sailing"
            );
        }   
       
        $return = array( 
            "success"       =>true,
            "date"          => $date,
            "total"         => $total,
            "total_normal"  => $total_normal,
            "total_siaga"   => $total_siaga,
            "total_kritis"  => $total_kritis,
            "categories"    => $categories,
            "data"          => $hop,
            "apung"         => $apung,
            "sailing"       => $sailing
        );

        return $return;
   }

   public function databatubaraMonth($cluster,$date){
        list($y,$m)=explode("-",$date);
        //Bbm::whereMonth("tanggal",$value)->whereYear("tanggal",$arr_year[$i])->sum("realisasi");
        $unit = Unit::select("cluster","unit","date","hop",DB::raw("ROUND(avg(hop),2) as hopavg"))
                ->leftJoin("hop_batubara as hb","hb.unit","=","units.name")
                ->where("cluster",$cluster)
                ->whereMonth("hb.date",$m)
                ->whereYear("hb.date",$y)
                ->groupBy("hb.unit")
                ->get();
        $categories = array();
        $hop = array();
        $total_kritis=0;
        $total_siaga=0;
        $total_normal=0;
        $total =0;
        foreach ($unit as $key => $val) {
            $total = $total+1;
            $categories[] = str_replace("PLTU","",$val->unit);
            
            if($val->hop<10){
                $status="Kritis";
                $total_kritis= $total_kritis+1;
            }else if($val->hop>=10 AND $val->hop<=15){
                $status="Siaga";
                $total_siaga =  $total_siaga+1;
            }else{
                $status="Normal";
                $total_normal =  $total_normal+1;
            }
        
            $hop[] = array(
                "y"         => (float)$val->hopavg,
                "date"      => $m."-".$y,
                "status"    => $status
            );
        }   
    
        $return = array( 
            "success" =>true,
            "date" => $date,
            "total" => $total,
            "total_normal" => $total_normal,
            "total_siaga" => $total_siaga,
            "total_kritis" => $total_kritis,
            "categories" => $categories,
            "data" => $hop
        );

        return $return;
    }

   public function databatubaraMonthx($cluster,$month){
        list($y,$m)=explode($month);
        Bbm::whereMonth("tanggal",$value)->whereYear("tanggal",$arr_year[$i])->sum("realisasi");

   }
   public function dashboardadmin(){
        $bln = date("m");
        $thn = date("Y");
        $date = date("Y-m-d");

        $vessel = MotherVessel::count();
        $UnitPembangkit = UnitPembangkit::count();
        //$deliv = Delivery::where("eta",">=",$date)->count();
        $deliv = Delivery::whereRaw("eta >= CONCAT(DATE_SUB(SUBSTR(NOW(),1,10), INTERVAL 30 DAY), ' 00:00:00')")->count();

        $rencana_jamali = Batubara::select('rencana')->where("realisasi",">",0)->where("area","Jamali")->whereMonth("tanggal",$bln)->whereYear("tanggal",$thn)->latest()->first();
        $realisasi_jamali = Batubara::where("area","Jamali")->where("realisasi",">",0)->whereMonth("tanggal",$bln)->whereYear("tanggal",$thn)->sum("realisasi");
        $latest_jamali = Batubara::where("area","Jamali")->where("realisasi",">",0)->latest("tanggal")->first();

        $rencana_sumkal = Batubara::select('rencana')->where("realisasi",">",0)->where("area","Sumkal")->whereMonth("tanggal",$bln)->whereYear("tanggal",$thn)->latest()->first();
        $realisasi_sumkal = Batubara::where("area","Sumkal")->where("realisasi",">",0)->whereMonth("tanggal",$bln)->whereYear("tanggal",$thn)->sum("realisasi");
        $latest_sumkal = Batubara::where("area","Sumkal")->where("realisasi",">",0)->latest("tanggal")->first();

        $rencana_sulmapa = Batubara::select('rencana')->where("realisasi",">",0)->where("area","Sulmapa")->whereMonth("tanggal",$bln)->whereYear("tanggal",$thn)->latest()->first();
        $realisasi_sulmapa = Batubara::where("area","Sulmapa")->where("realisasi",">",0)->whereMonth("tanggal",$bln)->whereYear("tanggal",$thn)->sum("realisasi");
        $latest_sulmapa = Batubara::where("area","Sulmapa")->where("realisasi",">",0)->latest("tanggal")->first();

        $rencana_biomasa = Biomasa::select('rencana')->where("realisasi",">",0)->where("realisasi",">",0)->whereMonth("tanggal",$bln)->whereYear("tanggal",$thn)->latest()->first();
        $realisasi_biomasa = Biomasa::whereMonth("tanggal",$bln)->where("realisasi",">",0)->where("realisasi",">",0)->whereYear("tanggal",$thn)->sum("realisasi");
        $latest_biomasa = Biomasa::latest("tanggal")->where("realisasi",">",0)->first();

        $rencana_gaspipa = GasPipa::select('rencana')->where("realisasi",">",0)->whereMonth("tanggal",$bln)->whereYear("tanggal",$thn)->latest()->first();
        $realisasi_gaspipa = GasPipa::whereMonth("tanggal",$bln)->where("realisasi",">",0)->whereYear("tanggal",$thn)->sum("realisasi");
        $latest_gaspipa = GasPipa::latest("tanggal")->where("realisasi",">",0)->first();

        $rencana_lng = Lng::select('rencana')->where("realisasi",">",0)->whereMonth("tanggal",$bln)->whereYear("tanggal",$thn)->latest()->first();
        $realisasi_lng = Lng::whereMonth("tanggal",$bln)->where("realisasi",">",0)->whereYear("tanggal",$thn)->sum("realisasi");
        $latest_lng = Lng::latest("tanggal")->where("realisasi",">",0)->first();

        $rencana_bbm = Bbm::select('rencana')->where("realisasi",">",0)->whereMonth("tanggal",$bln)->whereYear("tanggal",$thn)->latest()->first();
        $realisasi_bbm = Bbm::whereMonth("tanggal",$bln)->where("realisasi",">",0)->whereYear("tanggal",$thn)->sum("realisasi");
        $latest_bbm = Bbm::latest("tanggal")->where("realisasi",">",0)->first();

        $return = array(
            "jumlah_vessel" => $vessel,
            "jumlah_unit_pembangkit" => $UnitPembangkit,
            "jumlah_delivery" => $deliv,

            "rencana_jamali"   => @$rencana_jamali?number_format($rencana_jamali->rencana,2,',','.'):0,
            "realisasi_jamali" => number_format($realisasi_jamali,2,',','.'),
            "latest_jamali"    => @$latest_jamali?Carbon::parse($latest_jamali->tanggal)->format("d-m-Y"):"",

            "rencana_sumkal"  => @$rencana_sumkal?number_format($rencana_sumkal->rencana,2,',','.'):0,
            "realisasi_sumkal"  => number_format($realisasi_sumkal,2,',','.'),
            "latest_sumkal"    => @$latest_sumkal?Carbon::parse($latest_sumkal->tanggal)->format("d-m-Y"):"",

            "rencana_sulmapa"  => @$rencana_sulmapa?number_format($rencana_sulmapa->rencana,3,',','.'):0,
            "realisasi_sulmapa"  => number_format($realisasi_sulmapa,3,',','.'),
            "latest_sulmapa"    => @$latest_sulmapa?Carbon::parse($latest_sulmapa->tanggal)->format("d-m-Y"):"",

            "rencana_biomasa"  => @$rencana_biomasa?number_format($rencana_biomasa->rencana,1,',','.'):0,
            "realisasi_biomasa"  => number_format($realisasi_biomasa,1,',','.'),
            "latest_biomasa"    => @$latest_biomasa?Carbon::parse($latest_biomasa->tanggal)->format("d-m-Y"):"",

            "rencana_gaspipa"  => @$rencana_gaspipa?number_format($rencana_gaspipa->rencana,1,',','.'):0,
            "realisasi_gaspipa"  => number_format($realisasi_gaspipa,1,',','.'),
            "latest_gaspipa"    => @$latest_gaspipa?Carbon::parse($latest_gaspipa->tanggal)->format("d-m-Y"):"",

            "rencana_lng"  => @$rencana_lng?number_format($rencana_lng->rencana,1,',','.'):0,
            "realisasi_lng"  => number_format($realisasi_lng,1,',','.'),
            "latest_lng"    => @$latest_lng?Carbon::parse($latest_lng->tanggal)->format("d-m-Y"):"",

            "rencana_bbm"  => @$rencana_bbm?number_format($rencana_bbm->rencana,1,',','.'):0,
            "realisasi_bbm"  => number_format($realisasi_bbm,1,',','.'),
            "latest_bbm"    => @$latest_bbm?Carbon::parse($latest_bbm->tanggal)->format("d-m-Y"):"",


        );

        return $return;

    }



   public function databiomasa($area,$type,$lib){
        $arr_month = $lib['month_ori'];
        $arr_year = $lib['years'];
        $i=0;
        $rencana = array();
        $realisasi = array();
        foreach ($arr_month as $key => $value) {
            # code...
            $rencana1 = Biomasa::select('rencana')->whereMonth("tanggal",$value)->whereYear("tanggal",$arr_year[$i])->latest()->first();
            $realisasi1 = Biomasa::whereMonth("tanggal",$value)->whereYear("tanggal",$arr_year[$i])->sum("realisasi");
            if(!empty($rencana1)){
                $renc = $rencana1->rencana;
            }else{
                $renc= 0;
            }
            $rencana[] = (float) $renc;
            $realisasi[] = (float) $realisasi1;
            $i++;
        }
       
        $return = array(
            "rencana" => $rencana,
            "realisasi" => $realisasi
        );

        return $return;
    }

    public function datagaspipa($area,$type,$lib){
        $arr_month = $lib['month_ori'];
        $arr_year = $lib['years'];
        $i=0;
        $rencana = array();
        $realisasi = array();
        foreach ($arr_month as $key => $value) {
            # code...
            $rencana1 = GasPipa::select('rencana')->whereMonth("tanggal",$value)->whereYear("tanggal",$arr_year[$i])->latest()->first();
            $realisasi1 = GasPipa::whereMonth("tanggal",$value)->whereYear("tanggal",$arr_year[$i])->sum("realisasi");
            if(!empty($rencana1)){
                $renc = $rencana1->rencana;
            }else{
                $renc= 0;
            }
            $rencana[] = (float) $renc;
            $realisasi[] = (float) $realisasi1;
            $i++;
        }
       
        $return = array(
            "rencana" => $rencana,
            "realisasi" => $realisasi
        );

        return $return;
    }

    public function datalng($area,$type,$lib){
        $arr_month = $lib['month_ori'];
        $arr_year = $lib['years'];
        $i=0;
        $rencana = array();
        $realisasi = array();
        foreach ($arr_month as $key => $value) {
            # code...
            $rencana1 = Lng::select('rencana')->whereMonth("tanggal",$value)->whereYear("tanggal",$arr_year[$i])->latest()->first();
            $realisasi1 = Lng::whereMonth("tanggal",$value)->whereYear("tanggal",$arr_year[$i])->sum("realisasi");
            if(!empty($rencana1)){
                $renc = $rencana1->rencana;
            }else{
                $renc= 0;
            }
            $rencana[] = (float) $renc;
            $realisasi[] = (float) $realisasi1;
            $i++;
        }
       
        $return = array(
            "rencana" => $rencana,
            "realisasi" => $realisasi
        );

        return $return;
    }

    public function databbm($area,$type,$lib){
        $arr_month = $lib['month_ori'];
        $arr_year = $lib['years'];
        $i=0;
        $rencana = array();
        $realisasi = array();
        foreach ($arr_month as $key => $value) {
            # code...
            $rencana1 = Bbm::select('rencana')->whereMonth("tanggal",$value)->whereYear("tanggal",$arr_year[$i])->latest()->first();
            $realisasi1 = Bbm::whereMonth("tanggal",$value)->whereYear("tanggal",$arr_year[$i])->sum("realisasi");
            if(!empty($rencana1)){
                $renc = $rencana1->rencana;
            }else{
                $renc= 0;
            }
            $rencana[] = (float) $renc;
            $realisasi[] = (float) $realisasi1;
            $i++;
        }
       
        $return = array(
            "rencana" => $rencana,
            "realisasi" => $realisasi
        );

        return $return;
    }


}
