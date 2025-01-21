<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use DataTables;
use PDF;
use Carbon\Carbon;
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
        $tahapan_proses = TahapanProses::all();
        $accessMenu = $this->accessMenu();
        return view('pages.order.index_selesai',compact('page_title','title','accessMenu','jenis_order','tahapan_proses','submenu'));

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

        $tgl_start = $request->input('tgl_start');
        if($request->input('tgl_start')!=""){
            list($tgl,$bln,$thn)=explode('/',$request->input('tgl_start'));
            $tgl_start = $thn."-".$bln."-".$tgl;
        }
        if($request->input('tgl_end')!=""){
            list($tgl2,$bln2,$thn2)=explode('/',$request->input('tgl_end'));
            $tgl_end = $thn2."-".$bln2."-".$tgl2;
        }else{
            $tgl_end = date('Y-m-d');
        }

        $orders = Order::with(["jenisOrder","tahapanProses"])
                ->select(['id','jenis_order_id','tahapan_proses_id','nama_nasabah','tanggal_order','invoice','pengeluaran','progres','kendala','keterangan',DB::raw("DATE(updated_at) as date_updated")]); 

        if($submenu=='inprogres'){
            $orders->where('tahapan_proses_id','<',9);
        }else{
            $orders->where('tahapan_proses_id',9);
        }

        if($request->input('nama_nasabah')!=''){
            $orders->where('nama_nasabah','like', '%'.$request->input('nama_nasabah').'%');
        }

        if($tgl_start!=''){
            $orders->whereBetween('tanggal_order',[$tgl_start, $tgl_end]);
        }

        if($request->input('jenis_order_id')!=''){
            $orders->where('jenis_order_id',$request->input('jenis_order_id'));
        }

        if($request->input('tahapan_proses_id')!=''){
            $orders->where('tahapan_proses_id',$request->input('tahapan_proses_id'));
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


            $last = OrderHistory::where('order_id', $lastid_)->latest("id")->first();
            if(!empty($last)){
                OrderHistory::find($last->id)->update(["end_date" => date("Y-m-d")]);
            }


            $post['order_id'] = $lastid_;
            $post['created_by'] = auth()->user()->id;
            $post['start_date'] = date("Y-m-d");
            OrderHistory::create($post);

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

    public function history(Request $req)
    {
        $id = $req->input("id");
        $order = Order::with([
                "orderHistory" => function($q){ 
                    $q->with(["tahapanProses"]);
                }
                ,"tahapanProses","jenisOrder"])
            ->where('id',$id)
            ->first();
            
        return response()->json($order);

            $return['nasabah_show'] = $order->nama_nasabah;
            $return['tanggal_show'] = Carbon::parse($order->tanggal_order)->format("d M Y");
            $return['jenis_order_show'] = $order->jenis_order['name'];

            return $return;

            $data_his = '';
            $data_his.="<table width='100%' border='1'>";
            $data_his.='<tr><th class="text-center">NO.</th>
                        <th class="text-center">TAHAPAN PROSES</th>
                        <th class="text-center">PROGRES</th>
                        <th class="text-center">KENDALA</th>
                        <th class="text-center">KETERANGAN</th>
                        <th class="text-center">TANGGAL</th>
                        </tr>';
            $i=0;
            foreach ($order->order_history as $key) {
                $i++;

                if($key->end_date!=""){
                    $tgl = Carbon::parse($key->start_date)->format("d M Y").' s/d '.Carbon::parse($key->end_date)->format("d M Y");
                }else{
                    $tgl = Carbon::parse($key->start_date)->format("d M Y");
                }
                

                $data_his.="<tr>
                                <td width='8px' align='center'>".$i."</td>
                                <td >".$key->tahapan_proses->name."</td>
                                <td >".$key->progres."</td>
                                <td >".$key->kendala."</td>
                                <td >".$key->keterangan."</td>
                                <td >".$tgl."</td>
                            </tr>";
            }
            $data_his.="</table>";
            $return['history_table'] = $data_his;
        
        return $return;
    }

    public function exportOrder(Request $request){
        $req =  $request->input();
        //return Excel::download(new ExportInvoiceTrackingInbox($req), 'export-excel-order'.date('ymd').'.xlsx');
    }

    public function printOrder(Request $req){
        $order_id = $req->input('print_order_id');
        $histori = array();
        $title ="Print Riwayat Order";
        $order = Order::with([
                    "orderHistory" => function($q){ 
                        $q->with(["tahapanProses"]);
                    }
                    ,"tahapanProses","jenisOrder"])
                ->where('id',$order_id)
                ->first();
        $data = array(
            'title'     => $title,
            'order'     => $order,

        );
        
        //dd($order->orderHistory);die;
        
        $pdf = PDF::loadview('pages.order.print_riwayat_order',$data);
        return $pdf->stream();


    }


}
