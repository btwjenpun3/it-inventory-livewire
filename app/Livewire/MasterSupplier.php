<?php

namespace App\Livewire;

use App\Models\Supplier;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithoutUrlPagination;
use Illuminate\Support\Facades\Log;

class MasterSupplier extends Component
{
    use WithPagination, WithoutUrlPagination;

    public $title;

    public $id;

    public $id_supplier;
    public $supplier;
    public $address;
    public $state;
    public $province;
    public $phone;

    public $id_supplier_;
    public $supplier_;
    public $address_;
    public $state_;
    public $province_;
    public $phone_;

    public function mount()
    {
        $this->title = 'Master Supplier';

        $this->id           = '';

        $this->id_supplier  = '';
        $this->supplier     = '';
        $this->address      = '';
        $this->state        = '';
        $this->province     = '';
        $this->phone        = '';

        $this->id_supplier_ = '';
        $this->supplier_    = '';
        $this->address_     = '';
        $this->state_       = '';
        $this->province_    = '';
        $this->phone_       = '';
    }

    public function save()
    {
        try {
            $this->validate([
                'id_supplier'   => 'required',
                'supplier'      => 'required',
                'address'       => 'required',
                'phone'         => 'max:16'
            ]);
            Supplier::create([
                'id'        => $this->id_supplier,
                'supplier'  => $this->supplier,
                'address'   => $this->address,
                'state'     => $this->state,
                'province'  => $this->province,
                'phone'     => $this->phone
            ]);
            $this->dispatch('create-success', message : 'Item Created');
            
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::channel('master')->error('(Master Supplier) Theres an error : ' . $e->getMessage());   
            throw $e;         
        }
    }

    public function show($id)
    {
        $data = Supplier::where('id_supplier', $id)->first();
        $this->id           = $id;
        $this->id_supplier_ = $data->id;
        $this->supplier_    = $data->supplier;
        $this->address_     = $data->address;
        $this->state_       = $data->state;
        $this->province_    = $data->province;
        $this->phone_       = $data->phone;
    }

    public function update()
    {
        try {
            $this->validate([
                'id_supplier_'  => 'required',
                'supplier_'     => 'required',
                'address_'      => 'required',
                'phone_'        => 'max:16'
            ]);
            Supplier::where('id_supplier', $this->id)->update([
                'id'        => $this->id_supplier_,
                'supplier'  => $this->supplier_,
                'address'   => $this->address_,
                'state'     => $this->state_,
                'province'  => $this->province_,
                'phone'     => $this->phone_ 
            ]);
            $this->dispatch('update-modal-close');
            $this->dispatch('update-success', message: 'Supplier Updated');
            
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::channel('master')->error('(Master Supplier) Theres an error : ' . $e->getMessage());
            throw $e;
        }     
    }

    public function deleteConfirm($id)
    {
        try {
            $this->id = $id;
        } catch (\Exception $e) {
            Log::channel('master')->error('(Master Supplier) Theres an error : ' . $e->getMessage());   
        }
    }

    public function delete()
    {
        try {
            Supplier::where('id_supplier', $this->id)->delete();
            $this->dispatch('delete-modal-close');
            $this->dispatch('delete-success', message: 'Supplier Deleted');
                      
        } catch (\Exception $e) {
            Log::channel('master')->error('(Master Supplier) Theres an error : ' . $e->getMessage());   
        }
    }

    public function render()
    {
        return view('livewire.master-supplier', [
            'suppliers' => Supplier::paginate(10)
        ]);
    }
}
