<?php

namespace App\Livewire;

use Carbon\Carbon;
use App\Models\Kp;
use App\Models\Request;
use Livewire\Component;
use Illuminate\Support\Facades\Log;
use Livewire\WithPagination;
use Livewire\WithoutUrlPagination;
use Barryvdh\DomPDF\Facade\Pdf;

class ProductionRequestList extends Component
{
    use WithPagination, WithoutUrlPagination;

    public $title;

    public function mount()
    {
        $this->title = 'Production Request List';
    }
    
    public function print($id)
    {
        $requestData = Request::where('id_req', $id)->first();
        $kpData = $requestData->kp;
        $orderBuyer = $requestData->kp->buyer;
        return response()->streamDownload(function () use ($requestData, $kpData, $orderBuyer) {
            $pdf = Pdf::loadView('pages.print.request-print', [
                'requestData' => $requestData,
                'kpData' => $kpData,
                'orderBuyer' => $orderBuyer
            ]);
            echo $pdf->download();
        }, 'Request-Material-' . $requestData->no_trans . '.pdf');
    }

    public function render()
    {
        return view('livewire.production-request-list', [
            'datas' => Request::orderby('id_req', 'desc')->paginate(10)
        ]);
    }
}
