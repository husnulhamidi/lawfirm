<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;
use App\Models\PiutangDetail;

class Piutang extends Model implements Auditable
{
    use SoftDeletes, \OwenIt\Auditing\Auditable;

    protected $table = 'piutang';
    protected $primaryKey = 'id';
    protected $dates = ['deleted_at'];
    protected $fillable = ['nama_karyawan', 'nominal','tanggal','is_lunas','status_code','created_by','updated_by','deleted_at','created_at','updated_at'];

    public function piutangDetail() { 
        return $this->hasMany(PiutangDetail::class,"piutang_id")->select("id","piutang_id","nominal","tanggal"); 
    }
    public function piutangDetailSum() { 
        return $this->hasMany(PiutangDetail::class,"piutang_id")->sum("nominal"); 
    }
}
