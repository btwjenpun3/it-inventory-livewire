<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kp extends Model
{
    use HasFactory;

    protected $table = 'kp';

    protected $primaryKey = 'no'; 

    protected $guarded = [
        'no'
    ];

    public $timestamps = false;

    public function kpReceived()
    {
        return $this->hasOne(KpReceived::class, 'id_kp', 'no');
    }

    public function buyer()
    {
        return $this->belongsTo(OrderBuy::class, 'po_buyer', 'po_buyer');
    }
}
