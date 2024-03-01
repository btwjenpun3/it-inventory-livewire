<?php

namespace App\Livewire;

use App\Models\Kp;
use App\Models\KpReceived;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithoutUrlPagination;

class WarehouseReceived extends Component
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
        $this->title = 'Warehouse Received';
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
    }

    public function update()
    {
        try {   
            $this->validate([
                'sj'                => 'required',
                'doc_date'          => 'required',
                'del_date'          => 'required',
                'ekspedisi'         => 'required',
                'nosj_ekspedisi'    => 'required',
                'awb'               => 'required',
                'ket'               => 'required',
                'jenis_bc'          => 'required',
                'bc_no'             => 'required',
                'qty_received'      => 'required|integer'
            ]);
            $noTransLast = KpReceived::orderBy('id_trans', 'desc')->first();
            $noTransPrefix = $noTransLast ? substr($noTransLast->id_trans, 0, 5) : 'AD2024';
            $noTransSuffix = $noTransLast ? sprintf('%05d', substr($noTransLast->id_trans, 5) + '1') : '000001';
            $noTrans =  $noTransPrefix . $noTransSuffix;
            $storeData = KpReceived::create([
                'id_trans'          => $noTrans,
                'id_kp'             => $this->id_kp,
                'no_sj'             => $this->sj,
                'doc_date'          => $this->doc_date,
                'del_date'          => $this->del_date,
                'ekspedisi'         => $this->ekspedisi,
                'Pengirim'          => $this->supp,
                'nosj_ekspedisi'    => $this->nosj_ekspedisi,
                'awb'               => $this->awb,
                'ket'               => $this->ket,
                'Jenis_bc'          => $this->jenis_bc,
                'bc_no'             => $this->bc_no,
                'qty'               => $this->qty_received,
                'status'            => 'Received',
                'qty_pass'          => 0,
                'qty_req'           => 0
            ]);
            if($storeData) {
                Kp::where('no', $this->id_kp)->update([
                    'no_trans_rcvd' => $noTrans,
                    'qty_rcvd' => $this->qty_received
                ]);
            }    
            $this->reset();       
            $this->dispatch('update-modal-close');
            $this->dispatch('update-success', message: 'Material Received');
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::channel('master')->error('(Warehouse Received) Theres an error : ' . $e->getMessage());
            throw $e;
        }
    }

    public function render()
    {
        return view('livewire.warehouse-received', [
            'datas' => Kp::where('approve_purchasing', 1)->paginate(10)
        ]);
    }
}
