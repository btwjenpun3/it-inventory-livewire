<?php

namespace App\Livewire;

use Carbon\Carbon;
use App\Models\Kp;
use App\Models\Request;
use App\Models\RequestOutDet;
use App\Models\KpReceived;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithoutUrlPagination;

class QcPassList extends Component
{
    use WithPagination, WithoutUrlPagination;

    public $title;

    public $id_kp;
    public $no_kp;
    public $material;
    public $qty;
    public $qty_rcvd;
    public $uom;
    public $size;
    public $uom1;
    public $qty_passqc;
    public $supp;
    public $desc;
    public $color;

    public function mount()
    {
        $this->title = 'QC Pass Lists';
    }

    public function show($id)
    {
        $data = Kp::where('no', $id)->first();
        $this->id_kp    = $data->no;
        $this->no_kp    = $data->kp;
        $this->uom1     = $data->uom1;
        $this->material = $data->item;
        $this->qty      = $data->qty;
        $this->qty_rcvd = $data->qty_rcvd;
        $this->supp     = $data->supp;
        $this->desc     = $data->desc;
        $this->color    = $data->color;
        $this->uom      = $data->uom;
        $this->size     = $data->size;
        $this->qty_passqc = $data->qty_passqc;
    }

    public function render()
    {
        return view('livewire.qc-pass-list', [
            'datas' => Kp::where('qty_passqc', '!=', null)->paginate(10)
        ]);
    }
}
