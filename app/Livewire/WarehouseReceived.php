<?php

namespace App\Livewire;

use Livewire\Component;

class WarehouseReceived extends Component
{
    public $title;

    public function mount()
    {
        $this->title = 'Warehouse Received';
    }

    public function render()
    {
        return view('livewire.warehouse-received');
    }
}
