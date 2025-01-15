<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

use App\Models\Order;
use App\Models\TahapanProses;

class OrderHistory extends Model implements Auditable
{
    use SoftDeletes, \OwenIt\Auditing\Auditable;

    protected $table = 'order_histories';
    protected $primaryKey = 'id';
    protected $dates = ['deleted_at'];
    protected $fillable = ['order_id', 'tahapan_proses_id','progres','kendala','keterangan','start_date','end_date','status_code','created_by','updated_by','deleted_at','created_at','updated_at'];

    public function orders()
    {
        return $this->belongsTo(Order::class, 'order_id');    
    }

    public function tahapanProses()
    {
        return $this->belongsTo(TahapanProses::class, 'tahapan_proses_id')->select(["id","name"]);    
    }

}
