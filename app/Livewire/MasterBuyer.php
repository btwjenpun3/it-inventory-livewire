<?php

namespace App\Livewire;

use App\Models\Buyer;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithoutUrlPagination;

class MasterBuyer extends Component
{
    use WithPagination, WithoutUrlPagination;

    public $title;

    public $id_buyer;
    public $buyer_code;
    public $buyer_name;

    public $_buyer_code;
    public $_buyer_name;

    public function mount()
    {
        $this->title = 'Master Buyer';

        $this->buyer_code = '';
        $this->buyer_name = '';

        $this->_buyer_code = '';
        $this->_buyer_name = '';
    }

    public function save()
    {
        try {
            $this->validate([
                'buyer_code' => 'required',
                'buyer_name' => 'required',
            ]);
            Buyer::create([
                'code' => $this->buyer_code,
                'name' => $this->buyer_name
            ]);
            $this->dispatch('create-success', message : 'Buyer Created');
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::channel('master')->error('(Master Buyer) Theres an error : ' . $e->getMessage());   
            throw $e;         
        }
    }

    public function show($id)
    {
        $data = Buyer::where('id_buyer', $id)->first();
        $this->id_buyer = $id;
        $this->_buyer_code = $data->code;
        $this->_buyer_name = $data->name;
    }

    public function update()
    {
        try {
            $this->validate([
                '_buyer_code' => 'required',
                '_buyer_name' => 'required',
            ]);
            Buyer::where('id_buyer', $this->id_buyer)->update([
                'code' => $this->_buyer_code,
                'name' => $this->_buyer_name,
            ]);
            $this->dispatch('update-modal-close');
            $this->dispatch('update-success', message: 'Item Updated');
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::channel('master')->error('(Master Buyer) Theres an error : ' . $e->getMessage());
            throw $e;
        }     
    }

    public function deleteConfirm($id)
    {
        try {
            $this->id_buyer = $id;
        } catch (\Exception $e) {
            Log::channel('master')->error('(Master Buyer) Theres an error : ' . $e->getMessage());   
        }
    }

    public function delete()
    {
        try {
            Buyer::where('id_buyer', $this->id_buyer)->delete();
            $this->dispatch('delete-modal-close');
            $this->dispatch('delete-success', message: 'Buyer Deleted');      
        } catch (\Exception $e) {
            Log::channel('master')->error('(Master Buyer) Theres an error : ' . $e->getMessage());   
        }
    }
   

    public function render()
    {
        return view('livewire.master-buyer', [
            'buyers' => Buyer::paginate(10)
        ]);
    }
}
