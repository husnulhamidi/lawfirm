<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use DataTables;

use App\Models\JenisOrder;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $page_title = 'Orders';
        $title = 'Daftar Order';
        $jenis_order = JenisOrder::all();
        $accessMenu = $this->accessMenu();
        return view('pages.order.index',compact('page_title','title','accessMenu','jenis_order'));

    }

    public function inprogres()
    {
        $page_title = 'Orders';
        $title = 'Daftar Order InProgres';
        $accessMenu = $this->accessMenu();
        return view('pages.order.inprogres',compact('page_title','title','accessMenu'));

    }

    public function selesai()
    {
        $page_title = 'Orders';
        $title = 'Daftar Order Selesai';
        $accessMenu = $this->accessMenu();
        return view('pages.order.index',compact('page_title','title','accessMenu'));

    }

    private function accessMenu(){
        $result = array(
            'add'           => checkAccess('add'),
            'update'        => checkAccess('update'),
            'delete'        => checkAccess('delete')
        );
        return $result;
    }

    public function getData(Request $request)
    {
        $UnitPembangkit = Unit::get(); 
    
        return Datatables::of($UnitPembangkit)->make(true);
    }

    public function submit(Request $req)
    {
        try {
            $id = $req['unit_id'];
            unset($req['unit_id']);
            $check = Unit::find($id);
            $post = array(
                'name' => $req['nama_unit'],
                'city' => $req['kota']
            );
            if(!empty($check)){
                $post['updated_by'] = auth()->user()->id;
                $mare = Unit::find($id)->update($post);
                $lastid_ = $id;
            }else{
                $post['created_by'] = auth()->user()->id;
                $save = Unit::create($post);
                $lastid_ = $save->id;
            }

            $return = array(
                'success' => "true",
                'message' => "Data berhasil di simpan.",
                'id' => $lastid_
            );
            return $return;
        } catch (\Throwable $e) {       
            // Rollback Transaction
            DB::rollback();
            $return = array(
                'success' => "false",
                'message' => $e->getMessage(),
                'id' => ""
            );
            return $return;
        }
    }

    public function show(Request $req)
    {
        
        try {
            $return = array();
            $id = $req->id;
            $result = Unit::findOrfail($id);
            $return = array(
                'success' => "true",
                'message' => "success",
                'data' => $result
            );
            return $return;
        } catch (\Throwable $th)
        { 
            $return = array(
                'success' => "false",
                'message' => $th->getMessage(),
                'data'  => array(),
                'id' => ""
            );
            return $return;
        }
    }
    public function destroy(Request $req)
    {
        
        try {
            
            $id = $req->input('id');
            $delete = Unit::find($id);
            $delete->delete();
            $return = array(
                'success' => "true",
                'message' => 'Data berhasil di hapus.'
            );
            return $return;
        } catch (\Throwable $ex) {
            $return = array(
                'success' => "false",
                'message' => $ex->getMessage(),
            );
            return $return;
        }
       
    }


}
