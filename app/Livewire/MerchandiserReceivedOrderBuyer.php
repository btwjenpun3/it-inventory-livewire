<?php

namespace App\Livewire;

use App\Http\Controllers\GenerateNumberController;
use App\Models\Buyer;
use App\Models\OrderBuy;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithoutUrlPagination;

class MerchandiserReceivedOrderBuyer extends Component
{
    use WithPagination, WithoutUrlPagination;

    public $title;

    public $id;
    public $po_buyer;
    public $id_cust;
    public $cust;
    public $article;
    public $md;
    public $qty;

    public function mount()
    {
        $this->title = 'Merchandiser Received Order Plan';
    }

    public function save()
    {
        try {
            $this->validate([
                'po_buyer'  => 'required',
                'id_cust'   => 'required',
                'article'   => 'required',
                'md'        => 'required',
                'qty'       => 'required'
            ]);
            $call = new GenerateNumberController();
            $no = $call->generate('OrderBuy');
            OrderBuy::create([
                'ob'        => $no,
                'po_buyer'  => $this->po_buyer,
                'date'      => Carbon::now(),
                'article'   => $this->article,
                'id_cust'   => $this->id_cust,
                'cust'      => $this->searchCustomer($this->id_cust),
                'md'        => $this->md,
                'valid'     => null,
                'qty'       => $this->qty,
                'username'  => 'admin',
                'val_date'  => null
            ]);             
            $this->dispatch('create-success', 'Received Order Buyer : ' . $no);            
            $this->reset();
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::channel('master')->error('(Merchandiser Received Order Plan) Theres an error : ' . $e->getMessage());
            throw $e;
        } 
    }

    public function apply($id)
    {
        $this->id = $id;
    }

    public function send()
    {
        try {
            OrderBuy::where('id', $this->id)->update([
                'valid' => 'Waiting'
            ]);
            $this->dispatch('apply-modal-close');
            $this->dispatch('create-success', 'Received Order Buyer Sent');
        } catch (\Exception $e) {
            Log::channel('master')->error('(Merchandiser Received Order Plan) Theres an error : ' . $e->getMessage());
        }
    }

    public function show($id) 
    {
        $data = OrderBuy::where('id', $id)->first();
        $this->id           = $id;
        $this->po_buyer     = $data->po_buyer;
        $this->id_cust      = $data->id_cust;
        $this->cust         = $data->cust;
        $this->article      = $data->article;
        $this->md           = $data->md;
        $this->qty          = $data->qty;
    }

    public function update()
    {
        try {
            $this->validate([
                'po_buyer'  => 'required',
                'id_cust'   => 'required',
                'article'   => 'required',
                'md'        => 'required',
                'qty'       => 'required'
            ]); 
            OrderBuy::where('id', $this->id)->update([
                'po_buyer'  => $this->po_buyer,
                'date'      => Carbon::now(),
                'article'   => $this->article,
                'id_cust'   => $this->id_cust,
                'cust'      => $this->searchCustomer($this->id_cust),
                'md'        => $this->md,
                'valid'     => null,
                'qty'       => $this->qty,
                'username'  => 'admin',
                'val_date'  => null
            ]);             
            $this->dispatch('create-success', 'Received Order Buyer Updated'); 
            $this->reset();        
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::channel('master')->error('(Merchandiser Received Order Plan) Theres an error : ' . $e->getMessage());
            throw $e;
        } 
    }

    public function deleteConfirm($id)
    {
        $this->id = $id;
    }

    public function delete()
    {
        try {
            OrderBuy::where('id', $this->id)->delete();
            $this->dispatch('delete-modal-close');
            $this->dispatch('delete-success', message: 'Received Order Plan Deleted');
        } catch (\Exception $e) {
            Log::channel('master')->error('(Merchandiser Received Order Plan) Theres an error : ' . $e->getMessage());
        }
    }

    public function searchCustomer($id)
    {
        $data = Buyer::where('code', $id)->first();
        return $data->name;
    }

    public function render()
    {
        return view('livewire.merchandiser-received-order-buyer', [
            'buyers' => Buyer::get(),
            'orderBuyers' => OrderBuy::orderBy('id', 'desc')->paginate(10)
        ]);
    }
}
