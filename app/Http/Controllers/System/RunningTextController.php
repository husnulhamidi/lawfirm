<?php

namespace App\Http\Controllers\System;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use DataTables;
use Carbon\Carbon;
use App\Models\RunningText;

class RunningTextController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $page_title = 'Running Text';
        $title = 'Daftar Running Text';
        $accessMenu = $this->accessMenu();
        return view('pages.system.runningtext.index',compact('page_title','title','accessMenu'));

    }

    private function accessMenu(){
        $result = array(
            'add'           => checkAccess('add'),
            'update'        => checkAccess('update'),
            'delete'        => checkAccess('delete')
        );
        return $result;
    }


    public function getListRunningText(){
        $rt = RunningText::all();
        $no=1;
        $data_ves ="";
        $data_ves.="<table class='table table-bordered' width='100%' border='1'>";
        $data_ves.="<thead><tr><th class='text-center'>No.</th>
                    <th class='text-left'>Running Text</th>
                    <th class='text-left'>Posisi</th>
                </tr></thead>";

          $data_ves.="<tbody>";

        foreach ($rt as $key => $ves) {
            $checkedTop="";
            $checkedBt="";
            $checkedBottom="";
            if($ves->position=="Top"){
                $checkedTop ="checked";
            }
            else if ($ves->position=="Bottom Top"){
                $checkedBt ="checked";
            }
            else if ($ves->position=="Bottom"){
                $checkedBottom ="checked";
            }

           $data_ves .=" <tr>
           <td class='text-center'>".$no."</td>
           <td>".$ves->object_name."</td>
           <td>
               <div class='form-group row' >
                   <div class='col-sm-8'>
                       <div class='radio-inline'>
                           <label class='radio radio-primary statusrt'>
                           <input value='Top' type='radio' name='statusrt_".$ves->id."'  id='statusrt_".$ves->id."' ".$checkedTop." />
                               <span></span>Top 
                           </label>
                           <label class='radio radio-primary statusrt'>
                           <input value='Bottom Top' type='radio' name='statusrt_".$ves->id."'  id='statusrt_".$ves->id."' ".$checkedBt." />
                               <span></span>Bottom Top</label>
                           
                           <label class='radio radio-primary statusrt'>
                           <input value='Bottom' type='radio' name='statusrt_".$ves->id."'  id='statusrt_".$ves->id."' ".$checkedBottom."/>
                               <span></span>Bottom</label>
                       </div>
                   </div>
               </div> 
           </td>
       </tr>";
       $no++;
        }
        $data_ves .="</tbody></table>";
        echo $data_ves;
    }

    public function submit(Request $req){
        
        try {
            //code...
            $rt = RunningText::all();
            $data = array();
            foreach ($rt as $key => $val) {

                $param = "statusrt_".$val->id."";
                if($req->input($param)!=""){
                    $data = array(
                        'position'         => $req->input($param),
                        'updated_by'       => auth()->user()->id,
                        'updated_at'       => Carbon::now()->format("Y-m-d H:i:s")
                    );
                    RunningText::find($val->id)->update($data);
                }
                # code...
            }

            $return = array(
                'success' => "true",
                'message' => "success",
            );
            return $return;
        } catch (\Throwable $th) {
            //throw $th;
            $return = array(
                'success' => "false",
                'message' => $th->getMessage(),
            );
            return $return;
        }

    }

    public function riwayat(Request $req){
        $id = $req->input("id");
        $result = StrategicObjectives::findOrfail($id);
        $riwayat = StrategicObjectivesStatus::where("strategic_objective_id",$id)->orderBy("date","DESC")->get();

        $table="<table class='table table-bordered'>
                    <thead><tr><th>Tanggal</th><th>Status</th></tr>
                    <tbody>";
        foreach ($riwayat as $key => $val) {
            # code...
            $table.="<tr>
                        <td>".Carbon::parse($val->date)->format("d M Y")."</td>
                        <td>".$val->status."</td>
                    </tr>";
        }
        $table.="</tbody></table>";
        try {
            //code...
            $return = array(
                'success' => "true",
                'message' => "success",
                'data'    => $result,
                'riwayat' => $table
            );
            return $return;
        } catch (\Throwable $th) {
            //throw $th;
             $return = array(
                'success' => "false",
                'message' => $th->getMessage(),
            );
            return $return;
        }
    }


}
