<?php

namespace App\Livewire;

use App\Models\Kp;
use App\Models\Supplier;
use Livewire\Component;
use Illuminate\Support\Facades\Log;
use Livewire\WithPagination;
use Livewire\WithoutUrlPagination;

class PurchasePurchasing extends Component
{
    use WithPagination, WithoutUrlPagination;

    public $title;

    public $id_kp;

    public $no_kp;
    public $material_code;
    public $desc;
    public $color;
    public $size;
    public $uom;
    public $qty;
    public $uom1;
    public $po_sup;
    public $po_buyer;

    public $supplier;
    public $invoice;
    public $currency;
    public $price;
    public $etd;
    public $awb;

    public $supplier_name;

    public function mount()
    {
        $this->title = 'Purchasing';
    }

    public function show($id)
    {
        $data = Kp::where('no', $id)->first();
        $this->id_kp            = $id;
        $this->no_kp            = $data->kp;
        $this->material_code    = $data->item;
        $this->desc             = $data->desc;
        $this->color            = $data->color;
        $this->size             = $data->size;
        $this->uom              = $data->uom;
        $this->qty              = $data->qty;
        $this->uom1             = $data->uom1;
        $this->po_sup           = $data->po_sup;
        $this->po_buyer         = $data->po_buyer;

        $supplier = Supplier::where('supplier', $data->supp)->first();
        $this->supplier = (isset($supplier->supplier)) ? $supplier->supplier : '';
        $this->invoice  = $data->no_invo;
        $this->currency = $data->idr;
        $this->etd      = $data->etd;
        $this->awb      = $data->awb;
        $this->price    = $data->price;
    }

    public function update()
    {
        try {
            $this->validate([
                'supplier' => 'required',
                'invoice' => 'required',
                'currency' => 'required',
                'price' => 'required',
                'etd' => 'required',
                'awb' => 'required'
            ]);
            Kp::where('no', $this->id_kp)->update([
                'supp'               => $this->supplier,
                'no_invo'            => $this->invoice,
                'idr'                => $this->currency,
                'price'              => $this->price,
                'etd'                => $this->etd,
                'awb'                => $this->awb,
                'approve_purchasing' => 2
            ]);
            $this->dispatch('update-modal-close');
            $this->dispatch('update-success', message: 'Purchase Updated');
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::channel('master')->error('(Purchasing) Theres an error : ' . $e->getMessage());
            throw $e;
        }    
    }

    public function applyConfirm($id)
    {
        $this->id_kp = $id;
    }

    public function apply()
    {
        try {            
            Kp::where('no', $this->id_kp)->update([                
                'approve_purchasing' => 1
            ]);
            $this->dispatch('apply-modal-close');
            $this->dispatch('apply-success', message: 'Purchase Applied');
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::channel('master')->error('(Purchasing) Theres an error : ' . $e->getMessage());
            throw $e;
        }  
    }

    public function detail($id)
    {
        try {            
            $data = Kp::where('no', $id)->first();
            $this->id_kp            = $id;
            $this->no_kp            = $data->kp;
            $this->material_code    = $data->item;
            $this->desc             = $data->desc;
            $this->color            = $data->color;
            $this->size             = $data->size;
            $this->uom              = $data->uom;
            $this->qty              = $data->qty;
            $this->uom1             = $data->uom1;
            $this->po_sup           = $data->po_sup;
            $this->po_buyer         = $data->po_buyer;
            
            $supplier = Supplier::where('supplier', $data->supp)->first();
            $this->supplier_name = $supplier->supplier;
            $this->invoice  = $data->no_invo;
            $this->currency = $data->idr;
            $this->etd      = $data->etd;
            $this->awb      = $data->awb;
            $this->price    = $data->price;            
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::channel('master')->error('(Purchasing) Theres an error : ' . $e->getMessage());
            throw $e;
        }  
    }

    public function render()
    {
        return view('livewire.purchase-purchasing', [
            'datas' => Kp::where('approve_order_plan', 1)->orderBy('no', 'desc')->paginate(10),
            'suppliers' => Supplier::get()
        ]);
    }
}
