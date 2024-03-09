<?php

namespace App\Livewire;

use App\Models\Request;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithoutUrlPagination;
use Illuminate\Support\Facades\Log;

class WarehouseRequestList extends Component
{
    use WithPagination, WithoutUrlPagination;

    public $title;

    public $id_req, $no_trans, $pic, $qty, $qty_sent, $pick_date, $date_sent, $status, $allowen_qty_req, $creator;

    public $id_kp, $no_kp, $item, $desc, $color, $size, $uom;

    public function mount()
    {
        $this->title = 'Warehouse Request List';
    }

    public function show($id)
    {
        $data = Request::find($id);
        $this->id_req    = $data->id_req;
        $this->no_trans  = $data->no_trans;
        $this->pic       = $data->pic;
        $this->qty       = $data->qty;
        $this->qty_sent  = $data->qty_sent;
        $this->pick_date = $data->pick_date;
        $this->date_sent = $data->date_sent;
        $this->status    = $data->status;
        $this->allowen_qty_req = $data->allowen_qty_req;

        $kp = $data->kp;
        $this->no_kp    = $kp->kp;
        $this->item     = $kp->item;
        $this->desc     = $kp->desc;
        $this->color    = $kp->color;
        $this->size     = $kp->size;
        $this->uom      = $kp->uom;
    }

    public function update()
    {
        $this->validate([
            'qty_sent' => 'required',
            'creator' => 'required'
        ]);
        try {
            $request = Request::where('id_req', $this->id_req)->first();
            $allowenQtyReq = $request->allowen_qty_req;
            if ($this->qty_sent > $request->qty) {
                $this->dispatch('error', 'Quantity Sent cannot more than Quantity!');
                return;
            }
            $request->update([
                'qty_sent' => $this->qty_sent,
                'allowen_qty_req' => $allowenQtyReq + $this->qty_sent
            ]);
            $this->dispatch('update-success', 'Material successfully sent');
            $this->dispatch('update-modal-close');
        } catch (\Exception $e) {
            Log::channel('master')->error('(Warehouse Request Material) Theres an error : ' . $e->getMessage());
            $this->dispatch('error', 'Theres an error. Please contact admin!');
        }
    }

    public function render()
    {
        return view('livewire.warehouse-request-list', [
            'datas' => Request::orderby('id_req', 'desc')->paginate(10)
        ]);
    }
}
