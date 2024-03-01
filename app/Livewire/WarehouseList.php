<?php

namespace App\Livewire;

use App\Models\Kp;
use App\Models\KpReceived;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithoutUrlPagination;

class WarehouseList extends Component
{
    use WithPagination, WithoutUrlPagination;
    
    public $title;

    public $id_kp;
    public $no_kp;
    public $item;
    public $desc;
    public $size;
    public $uom;
    public $color;
    public $uom1;
    public $qty;
    public $supp;

    public $id_trans;
    public $sj;
    public $doc_date;
    public $del_date;
    public $ekspedisi;
    public $nosj_ekspedisi;
    public $awb;
    public $bc_no;
    public $jenis_bc;
    public $qty_received;
    public $ket;

    public function mount()
    {
        $this->title = 'Warehouse List';    
    }

    public function show($id)
    {
        $data = Kp::where('no', $id)->first();
        $this->id_kp    = $data->no;
        $this->no_kp    = $data->kp;
        $this->item     = $data->item;
        $this->desc     = $data->desc;
        $this->size     = $data->size;
        $this->uom      = $data->uom;
        $this->color    = $data->color;
        $this->qty      = $data->qty;
        $this->uom1     = $data->uom1;
        $this->supp     = $data->supp;

        $dataReceived = $data->kpReceived;
        $this->id_trans         = $dataReceived->id_trans;
        $this->sj               = $dataReceived->no_sj;
        $this->doc_date         = $dataReceived->doc_date;
        $this->del_date         = $dataReceived->del_date;
        $this->ekspedisi        = $dataReceived->ekspedisi;
        $this->nosj_ekspedisi   = $dataReceived->nosj_ekspedisi;
        $this->awb              = $dataReceived->awb;
        $this->bc_no            = $dataReceived->bc_no;
        $this->jenis_bc         = $dataReceived->Jenis_bc;
        $this->qty_received     = $dataReceived->qty;
        $this->ket              = $dataReceived->ket;
    }    

    public function render()
    {
        return view('livewire.warehouse-list', [
            'datas' => Kp::where('approve_purchasing', 1)->paginate(10)
        ]);
    }
}
