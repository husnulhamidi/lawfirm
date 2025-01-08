<?php

namespace App\Repositories;

use App\Models\Transaksi;
use App\Models\TransaksiDetail;

class PrintRepository
{
    public function getTransactionData($transCode)
    {
        $trans = Transaksi::with(['pelanggan', 'user',
                'piutang' => function ($builder) {
                    $builder->with(['piutang_detail']);
                }
            ])
            ->where("kode_transaksi", $transCode)
            ->first();

        $transDetail = TransaksiDetail::with(['barang'])
            ->where("transaksi_id", $trans->id)
            ->get();
       
        return [
            'trans' => $trans,
            'transDetail' => $transDetail
        ];
    }
}
