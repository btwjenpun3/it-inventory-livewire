<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KpReceived extends Model
{
    use HasFactory;

    protected $table = 'kp_received';

    protected $primaryKey = 'id_received'; 

    protected $guarded = [
        'id_received'
    ];

    public $timestamps = false;
}
