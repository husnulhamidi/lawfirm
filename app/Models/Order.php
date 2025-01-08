<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class Order extends Model implements Auditable
{
    use SoftDeletes, \OwenIt\Auditing\Auditable;

    protected $table = 'unit_pembangkits';
    protected $primaryKey = 'id';
    protected $dates = ['deleted_at'];
    protected $fillable = ['name', 'city','address','status_code','created_by','updated_by','deleted_at','created_at','updated_at'];
}
