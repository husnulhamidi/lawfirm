<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;
use App\Models\JenisOrder;
use App\Models\TahapanProses;
use App\Models\OrderHistory;

class Order extends Model implements Auditable
{
    use SoftDeletes, \OwenIt\Auditing\Auditable;

    protected $table = 'orders';
    protected $primaryKey = 'id';
    protected $dates = ['deleted_at'];
    protected $fillable = ['jenis_order_id', 'tahapan_proses_id','nama_nasabah','tanggal_order','invoice','pengeluaran','progres','kendala','keterangan','status_code','created_by','updated_by','deleted_at','created_at','updated_at'];

    public function jenisOrder() { return $this->belongsTo(JenisOrder::class)->select(["id","name"]); } // belongsTo()
    public function tahapanProses() { return $this->belongsTo(TahapanProses::class,"tahapan_proses_id")->select(["id","urutan","name"]); }

    public function orderHistory() { return $this->hasMany(OrderHistory::class,"order_id"); }
}
