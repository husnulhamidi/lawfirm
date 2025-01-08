<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class TahapanProses extends Model 
{
    use SoftDeletes;

    protected $table = 'tahapan_proses';
    protected $primaryKey = 'id';
    protected $dates = ['deleted_at'];
    protected $fillable = ['name', 'status_code','created_by','updated_by','deleted_at','created_at','updated_at'];
}
