<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequestOutDet extends Model
{
    use HasFactory;

    protected $table = 'req_out_det';

    protected $primaryKey = 'id_out';

    protected $guarded = [
        'id_out'
    ];

    public $timestamps = false;
}
