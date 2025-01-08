<?php

namespace App\Exports;

use App\Models\Transaksi;
use App\Models\TransaksiDetail;
use App\Models\MasterBarang;
use App\Models\Piutang;
use App\Models\PiutangDetail;
use App\Models\Retur;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Support\Facades\DB;


class ExportTransaksi implements FromView
{
    private $request;

    public function __construct($params)
    {
        $this->request = $params;
    }
    public function view(): View
    {
        
        $dateRange = $this->request['data_range_exp'];
        if ($dateRange) {
            list($startDate, $endDate) = explode(' - ', $dateRange);
        }

        $startDateQty = $startDate." 00:00:00";
        $endDateQty = $endDate." 23:59:00";

        $kode_transaksi = $this->request['kode_transaksi_exp'];
        $pelanggan_id = $this->request['pelanggan_exp'];
        $status = $this->request['status_exp'];
        $grand_total_start = $this->request['grand_total_start_exp'];
        $grand_total_end = $this->request['grand_total_end_exp'];

        $transDetail = TransaksiDetail::with(['barang'])
                ->leftJoin('transaksi as tr','tr.id','=','transaksi_detail.transaksi_id')
                ->leftJoin('master_pelanggan as p','p.id','=','tr.master_pelanggan_id')
                ->select('transaksi_detail.*','tr.kode_transaksi','tr.tanggal','tr.subtotal as trans_subtotal','tr.diskon_total as trans_diskon','tr.grand_total as trans_grand_total','p.nama_pelanggan',DB::raw('DATE_FORMAT(tr.tanggal, "%d-%m-%Y") as tanggal_transaksi'))
                ->where('is_transaksi',1)
                ->where('is_complete','1')
                ->whereBetween('tr.tanggal', [$startDate, $endDate])
                ->get();
        
        $subtotal = Transaksi::whereBetween('tanggal', [$startDate, $endDate])->where('is_transaksi',1)->where('is_complete','1')->sum('subtotal') ?? 0;
        $diskon = Transaksi::whereBetween('tanggal', [$startDate, $endDate])->where('is_transaksi',1)->where('is_complete','1')->sum('diskon_total') ?? 0;
        $grand_total = Transaksi::whereBetween('tanggal', [$startDate, $endDate])->where('is_transaksi',1)->where('is_complete','1')->sum('grand_total') ?? 0;
        $totalTF = Transaksi::whereBetween('tanggal', [$startDate, $endDate])->where('is_transaksi',1)->where('is_complete','1')->sum('transfer') ?? 0;
        $totalCash = Transaksi::whereBetween('tanggal', [$startDate, $endDate])->where('is_transaksi',1)->where('is_complete','1')->sum('cash') ?? 0;

        $totalCashBayar = Piutang::leftJoin('transaksi as tr','tr.id','=','piutangs.transaksi_id')
                        ->whereBetween('piutangs.created_at', [$startDateQty, $endDateQty])
                        ->where('tr.is_transaksi',1)
                        ->where('tr.is_complete','1')
                        ->sum('nominal_bayar') ?? 0;

        $totalCashNom = Piutang::leftJoin('transaksi as tr','tr.id','=','piutangs.transaksi_id')
                        ->whereBetween('piutangs.created_at', [$startDateQty, $endDateQty])
                        ->where('tr.is_transaksi',1)
                        ->where('tr.is_complete','1')
                        ->sum('nominal_transaksi') ?? 0;

        $utang = $totalCashNom-$totalCashBayar;

        $totalBayarUtangTF = PiutangDetail::leftJoin("piutangs as p","p.id","=","piutang_details.piutang_id")
                ->leftJoin('transaksi as tr','tr.id','=','p.transaksi_id')
                ->where('tr.is_transaksi',1)
                ->where('tr.is_complete','1')
                ->where("piutang_details.payment_method","Transfer")
                ->whereBetween('piutang_details.tanggal', [$startDate, $endDate])->sum('piutang_details.nominal_bayar') ?? 0;
        
        $totalBayarUtangCash = PiutangDetail::leftJoin("piutangs as p","p.id","=","piutang_details.piutang_id")
                ->leftJoin('transaksi as tr','tr.id','=','p.transaksi_id')
                ->where('tr.is_transaksi',1)
                ->where('tr.is_complete','1')
                ->where("piutang_details.payment_method","Tunai")
                ->whereBetween('piutang_details.tanggal', [$startDate, $endDate])->sum('piutang_details.nominal_bayar') ?? 0;

        $harga_barang = TransaksiDetail::leftjoin('transaksi as tr','tr.id','=','transaksi_detail.transaksi_id')
            ->whereBetween('tr.tanggal', [$startDate, $endDate])
            ->where('tr.is_transaksi',1)
            ->where('tr.is_complete','1')
            ->sum(DB::raw('(transaksi_detail.harga_beli*transaksi_detail.qty)')) ?? 0;

        $labaTrx = ($grand_total - $harga_barang) ?? 0;
        return view('pages.exports.transaksi', [
            'detail_transaksi' => $transDetail,
            'trans_subtotal' => $subtotal,
            'trans_diskon' => $diskon,
            'trans_grand_total' => $grand_total,
            'trans_totalTF' => $totalTF,
            'trans_totalCash' => $totalCash,
            'utang' => $utang,
            'total_bayar_utang' => $totalBayarUtangTF+$totalBayarUtangCash,
            'bayar_utang_cash' => $totalBayarUtangCash,
            'bayar_utang_tf' => $totalBayarUtangTF,
            'modal' => $harga_barang,
            'laba' => $labaTrx
        ]);
    }

    // private function getRealisasiAko($id){
    //     return $invoice = InvoiceAnggaran::whereHas('invo',function($builder){
    //         $builder->where('is_cancel_payment','!=',DB::raw("'1'"));
    //         $builder->whereNull('deleted_at');
    //     })
    //     ->where('prk_id',$id)->sum('nilai_invoice_idr');
    // }
}
