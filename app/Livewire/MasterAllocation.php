<?php

namespace App\Livewire;

use App\Models\Allocation;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\Attributes\Layout;
use Livewire\WithPagination;
use Livewire\WithoutUrlPagination;

class MasterAllocation extends Component
{
    use WithPagination, WithoutUrlPagination;

    public $title;
    
    public $id_rak;
    public $rak_name;
    public $jenis;      

     public $_rak_name;
     public $_jenis;

    public function mount()
    {
        $this->title = 'Master Allocation';

        $this->id_rak = '';
        $this->rak_name = '';
        $this->jenis = '';

        $this->_rak_name = '';
        $this->_jenis = '';  
    }   

    public function rules()
    {
        return [
            'rak_name' => 'required',
            'jenis' => 'required'
        ];
    }    

    public function show($id)
    {
        $data = Allocation::where('id_rak', $id)->first();
        $this->id_rak = $id;
        $this->_rak_name = $data->rak_name;
        $this->_jenis = $data->jenis;
    }

    public function update()
    {
        try {
            $this->validate([
                '_rak_name' => 'required',
                '_jenis' => 'required'
            ]);
            Allocation::where('id_rak', $this->id_rak)->update([
                'rak_name' => $this->_rak_name,
                'jenis' => $this->_jenis
            ]);
            $this->dispatch('update-modal-close');
            $this->dispatch('update-success', message: 'Allocation Updated : ' . $this->_rak_name);
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::channel('master')->error('(Master Allocation) Theres an error : ' . $e->getMessage());
            throw $e;
        }     
    }

    public function save()
    {
        try {
            $validated = $this->validate();
            Allocation::create($validated);
            $this->dispatch('create-success', message : 'Allocation Created');
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::channel('master')->error('(Master Allocation) Theres an error : ' . $e->getMessage());   
            throw $e;         
        }
    }

    public function deleteConfirm($id)
    {
        try {
            $this->id_rak = $id;
        } catch (\Exception $e) {
            Log::channel('master')->error('(Master Allocation) Theres an error : ' . $e->getMessage());   
        }
    }

    public function delete()
    {
        try {
            Allocation::where('id_rak', $this->id_rak)->delete();
            $this->dispatch('delete-modal-close');
            $this->dispatch('delete-success', message: 'Allocation Deleted');     
        } catch (\Exception $e) {
            Log::channel('master')->error('(Master Allocation) Theres an error : ' . $e->getMessage());   
        }
    }    

    public function render()
    {
        return view('livewire.master-allocation', [
            'allocations' => Allocation::paginate(10)
        ]);
    }
}
