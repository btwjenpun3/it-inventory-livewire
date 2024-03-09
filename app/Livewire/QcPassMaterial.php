<?php

namespace App\Livewire;

use App\Models\Kp;
use App\Models\KpReceived;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithoutUrlPagination;

class QcPassMaterial extends Component
{
    use WithPagination, WithoutUrlPagination;

    public $title;

    public $id_kp;
    public $no_kp;
    public $material;
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
        $this->title = 'QC Pass Material';
    }

    public function show($id)
    {
        $data = Kp::where('no', $id)->first();
        $this->id_kp    = $data->no;
        $this->no_kp    = $data->kp;
        $this->uom1     = $data->uom1;
        $this->material = $data->item;
        $this->qty_rcvd = $data->qty_rcvd;
        $this->supp     = $data->supp;
        $this->desc     = $data->desc;
        $this->color    = $data->color;
        $this->uom      = $data->uom;
        $this->size     = $data->size;
    }

    public function update()
    {
        try {
            $this->validate([
                'qty_passqc' => 'required'
            ]);
            if ($this->qty_passqc > $this->qty_rcvd){
                $this->dispatch('update-failed', message: 'QC Pass Cannot More Than Quantity Received!');
            } else {
                Kp::where('no', $this->id_kp)->update([
                    'qty_passqc'=> $this->qty_passqc,
                    'stock'     => $this->qty_passqc
                ]);
                $this->reset();       
                $this->dispatch('update-modal-close');
                $this->dispatch('update-success', message: 'QC Pass Success');
            }            
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::channel('master')->error('(QC Pass Material) Theres an error : ' . $e->getMessage());
            throw $e;
        } 
    }

    public function render()
    {
        return view('livewire.qc-pass-material', [
            'datas' => Kp::where('status', 'Received')->where('qty_passqc', '=', null)->paginate(10)
        ]);
    }
}
