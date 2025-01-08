<?php

namespace App\Imports;

use App\Models\SysVendor;
use App\Models\SysVendorRekening;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\WithStartRow;

class VendorImport implements ToModel, WithStartRow, SkipsEmptyRows
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */

    public function model(array $row)
    {
        SysVendorRekening::firstOrCreate(['sapid' => $row[0],'no_rekening' => $row[4]], [
            'sapid'         => $row[0],
            'nama_bank'     => $row[2],
            'nama_rekening' => $row[3],
            'no_rekening'   => $row[4]
            
        ]);

        return SysVendor::firstOrCreate(['sapid' => $row[0]], [
            'sapid'         => $row[0],
            'vendor'        => $row[1],
            //'nama_bank'     => $row[3],
            //'no_rekening'   => $row[4],
            //'nama_rekening' => $row[5]
        ]);
    }

    public function startRow(): int
    {
        return 2;
    }
}
