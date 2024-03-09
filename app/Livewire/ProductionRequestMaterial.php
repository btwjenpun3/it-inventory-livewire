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

class ProductionRequestMaterial extends Component
{
    use WithPagination, WithoutUrlPagination;

    public $title;

    public $id_kp;
    public $no_kp;
    public $material;
    public $qty_rcvd;    
    public $uom1;
    public $qty_passqc;
    public $supp;
    public $desc;
    public $color;
    public $stock;
    public $qty_req;
    public $pic;

    public function mount()
    {
        $this->title = 'Production Request Material';
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
        $this->stock    = $data->stock;
    }

    public function update()
    {
        try {
            $this->validate([
                'qty_req' => 'required',
                'pic' => 'required'
            ]);
            if ($this->qty_req > $this->stock){
                $this->dispatch('update-failed', message: 'Material Request Pass Cannot More Than Stock!');
            } else {                
                $noRequestLast = Request::orderBy('id_req', 'desc')->first();
                $noRequestPrefix = $noRequestLast ? substr($noRequestLast->no_trans, 0, 2) : 'rq';
                $noRequestSuffix = $noRequestLast ? sprintf('%07d', substr($noRequestLast->no_trans, -1) + '1') : '0000001';
                $noTrans =  $noRequestPrefix . $noRequestSuffix;
                $request = Request::create([
                    'no_trans'  => $noTrans,
                    'no'        => $this->id_kp,
                    'qty'       => $this->qty_req,
                    'pick_date' => Carbon::now()->toDateTimeString(),
                    'pic'       => $this->pic,
                    'status'    => 'Requested', 
                    'qty_sent'  => 0,
                    'allowen_qty_req' => 0                   
                ]);
                if($request) {
                    $requestOut = RequestOutDet::create([
                        'no_trans' => $noTrans,
                        'date_sent' => Carbon::now()->toDateTimeString(),
                        'pic' => $this->pic,
                        'status' => '-'
                    ]);
                    if($requestOut) {
                        Kp::where('no', $this->id_kp)->update([
                            'qty_req' => $this->qty_req,
                            'stock' => $this->stock - $this->qty_req
                        ]);
                    }
                }
                $this->reset();       
                $this->dispatch('update-modal-close');
                $this->dispatch('update-success', message: 'Material Request Success : ' . $noTrans);
            }            
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::channel('master')->error('(Material Request) Theres an error : ' . $e->getMessage());
            throw $e;
        } 
    }

    public function render()
    {
        return view('livewire.production-request-material', [
            'datas' => Kp::where('stock', '!=', null)->paginate(10)
        ]);
    }
}
