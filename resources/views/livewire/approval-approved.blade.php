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
                        <th>Order Plan</th>
                        <th>Created Date</th>
                        <th>Status</th>
                        <td></td>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($datas as $index => $data)
                        <tr wire:key="{{ $index }}">
                            <td>{{ $datas->firstItem() + $index }}</td>
                            <td><b>{{ $data->kp }}</b></td>
                            <td>{{ $data->create_date }}</td>
                            <td><span class="badge bg-green text-green-fg">Approved</span></td>
                            <td class="text-end">
                                <button class="btn btn-primary align-text-top" data-bs-target="#show-modal"
                                    data-bs-toggle="modal" wire:click="show('{{ $data->kp }}')">
                                    Show
                                </button>
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

    {{-- Modal Show --}}

    <div class="modal modal-blur fade" id="show-modal" tabindex="-1" role="dialog" aria-hidden="true"
        wire:ignore.self>
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Order Plan Detail</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div wire:loading wire:target="show">
                    <div class="text-center">
                        <div class="progress progress-sm">
                            <div class="progress-bar progress-bar-indeterminate"></div>
                        </div>
                    </div>
                </div>
                <div wire:loading.remove wire:target="show">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-6">
                                <p class="h3">Supplier</p>
                                <address>
                                    Street Address<br>
                                    State, City<br>
                                    Region, Postal Code<br>
                                    ltd@example.com
                                </address>
                            </div>
                            <div class="col-6 text-end">
                                <p class="h3">Buyer</p>
                                <address>
                                    {{ $buyer_name }}<br>
                                    State, City<br>
                                    Region, Postal Code<br>
                                    ctr@example.com
                                </address>
                            </div>
                            <div class="col-12 my-5">
                                <h1>Order Plan - {{ $no_kp }}</h1>
                            </div>
                        </div>
                        <table class="table table-hover table-transparent table-responsive">
                            <thead>
                                <tr>
                                    <th>Material</th>
                                    <th>Color</th>
                                    <th>Qnt Garment</th>
                                    <th>Size</th>
                                    <th>Quantity</th>
                                    <th>PO. Supplier</th>
                                </tr>
                            </thead>
                            @if (isset($kp))
                                @foreach ($kp as $k)
                                    <tr>

                                        <td>
                                            <p class="strong mb-1">{{ $k->desc }}</p>
                                            <div class="text-muted">Material Code : {{ $k->item }}</div>
                                        </td>
                                        <td>{{ $k->color }}</td>
                                        <td>{{ $k->qty_gar }}</td>
                                        <td>{{ $k->size }} {{ $k->uom }}</td>
                                        <td>{{ $k->qty }} {{ $k->uom1 }}</td>
                                        <td>{{ $k->po_sup }}</td>
                                    </tr>
                                @endforeach
                            @endif
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
