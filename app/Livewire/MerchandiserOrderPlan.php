<?php

namespace App\Livewire;

use Carbon\Carbon;
use App\Models\Kp;
use App\Models\KpTemporary;
use App\Models\Buyer;
use App\Models\OrderBuy;
use App\Models\Item;
use Livewire\Component;
use Illuminate\Support\Facades\Log;
use Livewire\WithPagination;
use Livewire\WithoutUrlPagination;

class MerchandiserOrderPlan extends Component
{
    use WithPagination, WithoutUrlPagination;

    public $title;

    public $count;

    public $id;
    public $buyer_code;
    public $po_buyer;
    public $material;
    public $size;
    public $uom;
    public $qty;
    public $uom2;
    public $color;
    public $po_supp;

    public $buyer_code_;
    public $po_buyer_;
    public $material_;
    public $desc_;
    public $size_;
    public $uom_;
    public $qty_;
    public $uom2_;
    public $color_;
    public $po_supp_;

    public function mount()
    {
        $this->title = 'Merchandiser Order Plan';

        $this->count();

        $this->id = '';
        $this->buyer_code   = '';
        $this->po_buyer     = '';
        $this->material     = '';
        $this->size         = '';
        $this->uom          = '';
        $this->qty          = '';
        $this->uom2         = '';
        $this->color        = '';
        $this->po_supp      = '';

        $this->buyer_code_  = '';
        $this->po_buyer_    = '';
        $this->material_    = '';
        $this->desc_        = '';
        $this->size_        = '';
        $this->uom_         = '';
        $this->qty_         = '';
        $this->uom2_        = '';
        $this->color_       = '';
        $this->po_supp_     = '';
    }

    public function count()
    {
        $this->count = count(KpTemporary::get());
    }

    public function save()
    {
        try {
            $this->validate([
                'buyer_code'    => 'required',
                'po_buyer'      => 'required',
                'material'      => 'required',
                'size'          => 'required',
                'uom'           => 'required',
                'qty'           => 'required',
                'uom2'          => 'required',
                'color'         => 'required',
                'po_supp'       => 'required',
            ]);
            $item = Item::where('items', $this->material)->first();
            $qtyGarment = OrderBuy::where('po_buyer', $this->po_buyer)->first();
            KpTemporary::create([
                'user_id'            => null,
                'code_buyer'         => $this->buyer_code,
                'po_buyer'           => $this->po_buyer,
                'item'               => $this->material,
                'item_description'   => $item->desc,
                'size'               => $this->size,
                'unit_of_material'   => $this->uom,
                'quantity'           => $this->qty,
                'unit_of_material_2' => $this->uom2,
                'color'              => $this->color,
                'po_supplier'        => $this->po_supp,
                'quantity_garment'   => $qtyGarment->qty
            ]);
            $this->dispatch('create-success', message : 'Order Plan Created');
            $this->count();
            
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::channel('master')->error('(Order Plan) Theres an error : ' . $e->getMessage());   
            throw $e;         
        }
    }

    public function apply()
    {
        try {
            $datas = KpTemporary::get();
            $getPrefix = $datas->first();
            $kpLast = Kp::orderBy('no', 'desc')->first();
            $kpNumberPrefix = $getPrefix->code_buyer;
            $kpNumberAffix = $kpLast ? sprintf('%07d', $kpLast->no + 1) : '0000001';
            $kpNumber = $kpNumberPrefix . $kpNumberAffix;
            foreach($datas as $data) {
                Kp::create([
                    'kp'          => $kpNumber,
                    'item'        => $data->item,
                    'desc'        => $data->item_description,
                    'color'       => $data->color,
                    'size'        => $data->size,
                    'uom'         => $data->unit_of_material,
                    'qty'         => $data->quantity,
                    'uom1'        => $data->unit_of_material_2,
                    'po_sup'      => $data->po_supplier,
                    'po_buyer'    => $data->po_buyer,
                    'qty_gar'     => $data->quantity_garment,
                    'create_date' => Carbon::now()
                ]);
                $data->delete();
            }
            $this->dispatch('apply-modal-close');
            $this->dispatch('create-success', message : 'Order Plan Applied with : ' . $kpNumber);
            $this->count();            
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::channel('master')->error('(Order Plan) Theres an error : ' . $e->getMessage());
            throw $e;
        }  
    }

    public function show($id)
    {
        $data = KpTemporary::where('id', $id)->first();
        $this->id = $id;
        $this->buyer_code_  = $data->code_buyer;
        $this->po_buyer_    = $data->po_buyer;
        $this->material_    = $data->item;
        $this->size_        = $data->size;
        $this->uom_         = $data->unit_of_material;
        $this->qty_         = $data->quantity;
        $this->uom2_        = $data->unit_of_material_2;
        $this->color_       = $data->color;
        $this->po_supp_     = $data->po_supplier;
    }

    public function update()
    {
        try {
            $this->validate([
                'buyer_code_'    => 'required',
                'po_buyer_'      => 'required',
                'material_'      => 'required',
                'size_'          => 'required',
                'uom_'           => 'required',
                'qty_'           => 'required',
                'uom2_'          => 'required',
                'color_'         => 'required',
                'po_supp_'       => 'required',
            ]);
            $item = Item::where('items', $this->material_)->first();
            $qtyGarment = OrderBuy::where('po_buyer', $this->po_buyer_)->first();
            KpTemporary::where('id', $this->id)->update([
                'user_id'            => null,
                'code_buyer'         => $this->buyer_code_,
                'po_buyer'           => $this->po_buyer_,
                'item'               => $this->material_,
                'item_description'   => $item->desc,
                'size'               => $this->size_,
                'unit_of_material'   => $this->uom_,
                'quantity'           => $this->qty_,
                'unit_of_material_2' => $this->uom2_,
                'color'              => $this->color_,
                'po_supplier'        => $this->po_supp_,
                'quantity_garment'   => $qtyGarment->qty
            ]);
            $this->dispatch('update-modal-close');
            $this->dispatch('update-success', message: 'Order Plan Updated');
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::channel('master')->error('(Order Plan) Theres an error : ' . $e->getMessage());
            throw $e;
        }     
    }

    public function deleteConfirm($id)
    {
        try {
            $this->id = $id;
        } catch (\Exception $e) {
            Log::channel('master')->error('(Order Plan) Theres an error : ' . $e->getMessage());   
        }
    }

    public function delete()
    {
        try {
            KpTemporary::where('id', $this->id)->delete();
            $this->dispatch('delete-modal-close');
            $this->dispatch('delete-success', message: 'Buyer Deleted');
            $this->count();
                      
        } catch (\Exception $e) {
            Log::channel('master')->error('(Order Plan) Theres an error : ' . $e->getMessage());   
        }
    }

    public function render()
    {
        return view('livewire.merchandiser-order-plan', [
            'datas'     => KpTemporary::paginate(10),
            'buyers'    => Buyer::get(),
            'poBuyers'  => OrderBuy::get(),
            'materials' => Item::get()
        ]);
    }
}
