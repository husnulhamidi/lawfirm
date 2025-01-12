<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use DataTables;

use App\Models\JenisOrder;
use App\Models\Order;
use App\Models\OrderHistory;
use App\Models\TahapanProses;

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
        $submenu='inprogres';
        $jenis_order = JenisOrder::all();
        $tahapan_proses = TahapanProses::all();
        $accessMenu = $this->accessMenu();
        return view('pages.order.index_inprogres',compact('page_title','title','accessMenu','jenis_order','tahapan_proses','submenu'));

    }

    public function selesai()
    {
        $page_title = 'Orders';
        $title = 'Daftar Order Selesai';
        $submenu='selesai';
        $jenis_order = JenisOrder::all();
        $accessMenu = $this->accessMenu();
        return view('pages.order.index_selesai',compact('page_title','title','accessMenu','jenis_order','submenu'));

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
        $submenu = $request->input('submenu');
        $orders = Order::with(["jenisOrder","tahapanProses"])
                ->select(['id','jenis_order_id','tahapan_proses_id','nama_nasabah','tanggal_order','invoice','pengeluaran','progres','kendala','keterangan']); 

        if($submenu=='inprogres'){
            $orders->where('tahapan_proses_id','<',9);
        }else{
            $orders->where('tahapan_proses_id',9);
        }
        $orders->orderBy('created_at','desc')->get();
    
        return Datatables::of($orders)->make(true);
    }

    public function storeOrUpdate(Request $req)
    {
        try {
            $id = $req['order_id'];
            unset($req['order_id']);
            $check = Order::find($id);
            list($d,$m, $y) = explode('/',$req['tgl']);
            $post = array(
                'nama_nasabah' => $req['nama_nasabah'],
                'tanggal_order' => $y.'-'.$m.'-'.$d,
                'nama_nasabah' => $req['nama_nasabah'],
                'invoice' => str_replace('.', '', $req['invoice']),
                'pengeluaran' => str_replace('.', '', $req['pengeluaran_invoice']),
                'jenis_order_id' => $req['jenis_order_id'],
                
            );
            if(!empty($check)){
                $post['updated_by'] = auth()->user()->id;
                $mare = Order::find($id)->update($post);
                $lastid_ = $id;
            }else{
                $post['tahapan_proses_id'] = 1;
                $post['created_by'] = auth()->user()->id;
                $save = Order::create($post);
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

    public function tahapanProses(Request $req)
    {
        try {
            $id = $req['order_id_tp'];
            unset($req['order_id_tp']);
            $check = Order::find($id);
            $post = array(
                'progres' => $req['progres'],
                'kendala' => $req['kendala'],
                'keterangan' => $req['keterangan'],
                'tahapan_proses_id' => $req['tahapan_proses_id'],
            );
            if(!empty($check)){
                $post['updated_by'] = auth()->user()->id;
                $mare = Order::find($id)->update($post);
                $lastid_ = $id;
            }else{
                $post['created_by'] = auth()->user()->id;
                $save = Order::create($post);
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
            $id = $req->input('id');
            $result = Order::findOrfail($id);
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
            $delete = Order::find($id)->delete();
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
