<?php

namespace App\Livewire;

use Livewire\Component;

class ApprovalBuyerOrder extends Component
{

    public $title;

    public function mount()
    {
        $this->title = 'Approval Buyer Order';
    }

    public function render()
    {
        return view('livewire.approval-buyer-order');
    }
}
