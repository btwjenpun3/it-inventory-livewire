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
                            <td><span class="badge bg-yellow text-yellow-fg">Waiting for Approval</span></td>
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
                                <th class="text-center">Color</th>
                                <th class="text-center">Qnt Garment</th>
                                <th class="text-center">Size</th>
                                <th class="text-center">Quantity</th>
                                <th class="text-center">PO. Supplier</th>
                            </tr>
                        </thead>
                        @if (isset($kp))
                            @foreach ($kp as $k)
                                <tr>

                                    <td>
                                        <p class="strong mb-1">{{ $k->desc }}</p>
                                        <div class="text-muted">Material Code : {{ $k->item }}</div>
                                    </td>
                                    <td class="text-end">{{ $k->color }}</td>
                                    <td class="text-center">{{ $k->qty_gar }}</td>
                                    <td class="text-end">{{ $k->size }} {{ $k->uom }}</td>
                                    <td class="text-end">{{ $k->qty }} {{ $k->uom1 }}</td>
                                    <td class="text-end">{{ $k->po_sup }}</td>
                                </tr>
                            @endforeach
                        @endif
                    </table>
                </div>
                <div class="modal-footer">
                    <a href="#" class="btn btn-danger me-auto" wire:click="reject" id="update">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-x" width="24"
                            height="24" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none"
                            stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M18 6l-12 12" />
                            <path d="M6 6l12 12" />
                        </svg>
                        Reject
                    </a>
                    <a href="#" class="btn btn-success ms-auto" wire:click="approve" id="update">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-check"
                            width="24" height="24" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                            fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M5 12l5 5l10 -10" />
                        </svg>
                        Approve
                    </a>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal Delete --}}

    <div class="modal modal-blur fade" id="delete-modal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
            <div class="modal-content">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                <div class="modal-status bg-danger"></div>
                <div class="modal-body text-center py-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon mb-2 text-danger icon-lg" width="24"
                        height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                        stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path
                            d="M10.24 3.957l-8.422 14.06a1.989 1.989 0 0 0 1.7 2.983h16.845a1.989 1.989 0 0 0 1.7 -2.983l-8.423 -14.06a1.989 1.989 0 0 0 -3.4 0z" />
                        <path d="M12 9v4" />
                        <path d="M12 17h.01" />
                    </svg>
                    <h3>Are you sure?</h3>
                    <div class="text-muted">Do you really want to remove this ? What you've done cannot be undone.
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="w-100">
                        <div class="row">
                            <div class="col">
                                <a href="#" class="btn w-100" data-bs-dismiss="modal">
                                    Cancel
                                </a>
                            </div>
                            <div class="col">
                                <a href="#" class="btn btn-danger w-100" wire:click="delete">
                                    Delete
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Script --}}

    @script
        <script>
            $wire.on('approve-modal-close', () => {
                $('#show-modal').modal('hide');
            });
            $wire.on('approve-success', (data) => {
                toastr.options = {
                    progressBar: true,
                };
                toastr.options.positionClass = "toast-bottom-right";
                toastr.success(data.message);
            });

            $wire.on('delete-modal-close', () => {
                $('#delete-modal').modal('hide');
            });
            $wire.on('delete-success', (data) => {
                toastr.options = {
                    progressBar: true,
                };
                toastr.options.positionClass = "toast-bottom-right";
                toastr.warning(data.message);
            });
        </script>
    @endscript

</div>
