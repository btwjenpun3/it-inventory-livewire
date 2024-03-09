<div>

    {{-- Button --}}

    <div class="page-header d-print-none mb-3">
        <div class="row g-2 align-items-center">
            <div class="col">
                <div class="page-pretitle">
                    Overview
                </div>
                <h2 class="page-title">
                    {{ $title }}
                </h2>
            </div>
        </div>
    </div>

    {{-- Table --}}

    <div class="card">
        <div class="table-responsive">
            <table class="table table-vcenter table-striped table-hover card-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Request Number</th>
                        <th>Quantity</th>
                        <th>Status</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($datas as $index => $data)
                        <tr wire:key="{{ $data->id }}">
                            <td>{{ $datas->firstItem() + $index }}</td>
                            <td>{{ $data->no_trans }}</td>
                            <td>{{ $data->qty }}</td>
                            <td>
                                @switch($data->status)
                                    @case('Requested')
                                        <span class="badge bg-yellow text-yellow-fg">Requested</span>
                                    @break

                                    @case('Finish')
                                        <span class="badge bg-green text-green-fg">Finish</span>
                                    @break

                                    @default
                                @endswitch
                            </td>
                            <td class="w-1">
                                @switch($data->status)
                                    @case('Requested')
                                        <button class="btn btn-primary" wire:click="print({{ $data->id_req }})"
                                            wire:loading.attr="disabled">Export PDF</button>
                                    @break

                                    @case('Finish')
                                        <button class="btn btn-info">Show</button>
                                    @break

                                    @default
                                @endswitch
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="mt-3 d-flex justify-content-end">
            {{ $datas->links() }}
        </div>
    </div>
</div>
