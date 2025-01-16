<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use DataTables;

use App\Models\Piutang;
use App\Models\PiutangDetail;

class PiutangController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $page_title = 'Piutang';
        $title = 'Daftar Piutang';
        $accessMenu = $this->accessMenu();
        return view('pages.piutang.index',compact('page_title','title','accessMenu'));

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
        $piutang = Piutang::withSum("piutangDetail","nominal")->get(); 
    
        return Datatables::of($piutang)->make(true);
    }

    public function submit(Request $req)
    {
        try {
            $id = $req['piutang_id'];
            unset($req['piutang_id']);
            $check = Piutang::find($id);
            list($tgl,$bln,$thn) = explode("/",$req['tgl']);
            $post = array(
                'nama_karyawan' => $req['nama_pegawai'],
                'nominal'       => str_replace(".","",$req['jumlah_pinjaman']),
                'tanggal'       => $thn."-".$bln."-".$tgl,
            );
            if(!empty($check)){
                $post['updated_by'] = auth()->user()->id;
                $mare =  $check->update($post);
                $lastid_ = $id;
            }else{
                $post['created_by'] = auth()->user()->id;
                $save = Piutang::create($post);
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
            $result = Piutang::findOrfail($id);
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
            $delete = Piutang::find($id);
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

    //==========================================================================================================================
    // detail 
    
    public function detail(Request $req)
    {
        $uid = $req->input("uid");
        $piutang = Piutang::with(["piutangDetail"])->find($uid);
        $bayarpiutang =0;

        $bayarpiutang = PiutangDetail::select("nominal")->where('piutang_id',$uid)->sum("nominal");
       
        $terbayar   = $bayarpiutang;
        $sisa_utang   = $piutang->nominal-($bayarpiutang);
        $page_title = 'Detail Piutang'; // Change page title
        $accessMenu = $this->accessMenu();
        return view('pages.piutang.detail', compact('page_title', 'piutang','sisa_utang','terbayar'));
    }

    public function detailList(Request $req)
    {
        $piutang_id = $req->input("piutang_id");
        $piutang = PiutangDetail::select("id","piutang_id","nominal","tanggal","keterangan")->where('piutang_id',$piutang_id)->get();

        return DataTables::of($piutang)->make(true);
    }

    public function submitDetail(Request $req)
    {
        try {
            $id = $req['detail_id'];
            unset($req['detail_id']);
            $check = PiutangDetail::find($id);
            list($tgl,$bln,$thn) = explode("/",$req['tanggal']);
            $post = array(
                'piutang_id'    => $req['utang_id'],
                'nominal'       => str_replace(".","",$req['nominal_bayar']),
                'tanggal'       => $thn."-".$bln."-".$tgl,
                'keterangan'    => $req['is_lunas'],
                'keterangan'    => $req['keterangan'],
            );
            if(!empty($check)){
                $post['updated_by'] = auth()->user()->id;
                $mare =  $check->update($post);
                $lastid_ = $id;
            }else{
                $post['created_by'] = auth()->user()->id;
                $save = PiutangDetail::create($post);
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

    public function showDetail(Request $req)
    {
        
        try {
            $return = array();
            $id = $req->id;
            $result = PiutangDetail::findOrfail($id);
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
    public function destroyDetail(Request $req)
    {
        
        try {
            
            $id = $req->input('id');
            $delete = PiutangDetail::find($id);
            $delete->delete();
            $return = array(
                'success' => "true",
                'message' => 'Data berhasil di hapus.'
            );
            return $return;
        } catch (\Throwable $ex) {
            $return = array(
                'success' => "false",
                'message' => $ex->getMessage().' file: '.$ex->getFile().' line: '.$ex->getLine(),
            );
            return $return;
        }
       
    }


}
