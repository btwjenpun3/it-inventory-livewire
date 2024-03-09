<?php

namespace App\Http\Controllers;

use App\Models\OrderBuy;
use Illuminate\Http\Request;

class GenerateNumberController extends Controller
{
    public function generate($model)
    {
        switch($model) {
            case 'OrderBuy':
                $noLast = OrderBuy::orderBy('id', 'desc')->first();
                $noPrefix = $noLast ? substr($noLast->ob, 0, 3) : 'ORD';
                $noSuffix = $noLast ? sprintf('%07d', substr($noLast->ob, -7) + '1') : '0000001';
                $no =  $noPrefix . $noSuffix;
                return $no;
                break;
            default :
                return 'Theres an error!';
        }
    }
}
