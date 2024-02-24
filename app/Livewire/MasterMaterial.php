<?php

namespace App\Livewire;

use App\Models\Item;
use App\Models\Buyer;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithoutUrlPagination;

class MasterMaterial extends Component
{
    use WithPagination, WithoutUrlPagination;
    
    public $title;

    public $id_item;
    public $code_buyer;
    public $items;
    public $desc;
    public $mat_type;

    public $_code_buyer;
    public $_items;
    public $_desc;
    public $_mat_type;

    public function mount()
    {
        $this->title = 'Master Material';   

        $this->id_item      = '';
        $this->code_buyer   = '';
        $this->items        = '';
        $this->desc         = '';
        $this->mat_type     = '';

        $this->_code_buyer  = '';
        $this->_items       = '';
        $this->_desc        = '';
        $this->_mat_type    = '';
    }

    public function save()
    {
        try {
            $validated = $this->validate([
                'code_buyer' => 'required',
                'items' => 'required',
                'desc' => 'required',
                'mat_type' => 'required'
            ]);
            Item::create($validated);
            $this->dispatch('create-success', message : 'Item Created');
            
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::channel('master')->error('(Master Allocation) Theres an error : ' . $e->getMessage());   
            throw $e;         
        }
    }    

    public function show($id)
    {
        $data = Item::where('id_item', $id)->first();
        $this->id_item = $id;
        $this->_code_buyer = $data->code_buyer;
        $this->_items = $data->items;
        $this->_desc = $data->desc;
        $this->_mat_type = $data->mat_type;
    }

    public function update()
    {
        try {
            $this->validate([
                '_code_buyer' => 'required',
                '_items' => 'required',
                '_desc' => 'required',
                '_mat_type' => 'required'
            ]);
            Item::where('id_item', $this->id_item)->update([
                'code_buyer' => $this->_code_buyer,
                'items' => $this->_items,
                'desc' => $this->_desc,
                'mat_type' => $this->_mat_type 
            ]);
            $this->dispatch('update-modal-close');
            $this->dispatch('update-success', message: 'Item Updated');
            
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::channel('master')->error('(Master Allocation) Theres an error : ' . $e->getMessage());
            throw $e;
        }     
    }

    public function deleteConfirm($id)
    {
        try {
            $this->id_item = $id;
        } catch (\Exception $e) {
            Log::channel('master')->error('(Master Buyer) Theres an error : ' . $e->getMessage());   
        }
    }

    public function delete()
    {
        try {
            Item::where('id_item', $this->id_item)->delete();
            $this->dispatch('delete-modal-close');
            $this->dispatch('delete-success', message: 'Buyer Deleted');
                      
        } catch (\Exception $e) {
            Log::channel('master')->error('(Master Buyer) Theres an error : ' . $e->getMessage());   
        }
    }

    public function render()
    {
        return view('livewire.master-material', [
            'datas' => Item::paginate(10),
            'buyers' => Buyer::get()
        ]);
    }
}
