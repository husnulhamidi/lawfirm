<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;
use App\Models\Order;

class PiutangDetail extends Model implements Auditable
{
    use SoftDeletes, \OwenIt\Auditing\Auditable;

    protected $table = 'piutang_detail';
    protected $primaryKey = 'id';
    protected $dates = ['deleted_at'];
    protected $fillable = ['piutang_id', 'nominal','tanggal','keterangan','is_lunas','status_code','created_by','updated_by','deleted_at','created_at','updated_at'];

    public function piutang() { 
        return $this->belongsTo(Piutang::class,"piutang_id")->select("id","nama_karyawan","nominal"); 
    }
}
