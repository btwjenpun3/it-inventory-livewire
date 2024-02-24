<?php

namespace App\Livewire;

use App\Models\Kp;
use Livewire\Component;
use Illuminate\Support\Facades\Log;
use Livewire\WithPagination;
use Livewire\WithoutUrlPagination;

class ApprovalApproved extends Component
{
    use WithPagination, WithoutUrlPagination;

    public $title;

    public $kp_data;

    public $no_kp;
    public $buyer_name;

    public function mount()
    {
        $this->title = 'Approved List';

        $this->no_kp = '';
        $this->buyer_name = '';
    }

    public function show($kp)
    {
        try {
            $data = Kp::where('kp', $kp)->get();  
            $this->kp_data = $data;
            $this->no_kp = $data->first()->kp; 

            $this->buyer_name = $data->first()->po_buyer; 
             
            $this->render();               
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::channel('master')->error('(Master Allocation) Theres an error : ' . $e->getMessage());
            throw $e;
        } 
    }

    public function render()
    {
        return view('livewire.approval-approved', [
            'datas' => Kp::where('approve_order_plan', 1)
                        ->select(['kp', 'create_date'])
                        ->groupBy(['kp', 'create_date'])
                        ->orderBy('kp', 'desc')
                        ->paginate(10),
            'kp' => $this->kp_data            
        ]);
    }
}
