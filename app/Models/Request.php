<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Request extends Model
{
    use HasFactory;

    protected $table = 'req';

    protected $primaryKey = 'id_req';

    protected $guarded = [
        'id_req'
    ];

    public $timestamps = false;

    public function kp()
    {
        return $this->belongsTo(Kp::class, 'no', 'no');
    }
}
