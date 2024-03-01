<div>

    {{-- Header --}}

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
                        <th>Production Card</th>
                        <th>Material Code</th>
                        <th>Material Description</th>
                        <th>Color</th>
                        <th>Size</th>
                        <th>Quantity</th>
                        <th>Purchase Order Supplier</th>
                        <th>Purchase Order Buyer</th>
                        <th>Status</th>
                        <td class="w-1"></td>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($datas as $index => $data)
                        <tr wire:key="{{ $data->no }}">
                            <td>{{ $datas->firstItem() + $index }}</td>
                            <td><b>{{ $data->kp }}</b></td>
                            <td>{{ $data->item }}</td>
                            <td>{{ $data->desc }}</td>
                            <td>{{ $data->color }}</td>
                            <td>{{ $data->size }} {{ $data->uom }}</td>
                            <td>{{ $data->qty }} {{ $data->uom1 }}</td>
                            <td>{{ $data->po_sup }}</td>
                            <td>{{ $data->po_buyer }}</td>
                            @if ($data->approve_purchasing == '')
                                <td><span class="badge bg-yellow text-yellow-lg">Waiting</td>
                            @elseif($data->approve_purchasing === 2)
                                <td><span class="badge bg-purple text-purple-lg">Draft</td>
                            @else
                                <td><span class="badge bg-green text-green-lg">Applied</td>
                            @endif
                            <td class="text-end">
                                @if ($data->approve_purchasing == '' || $data->approve_purchasing === 2)
                                    <div class="btn-list flex-nowrap">
                                        <a class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#update-modal"
                                            wire:click="show({{ $data->no }})">
                                            Update
                                        </a>
                                        @if ($data->approve_purchasing == '')
                                            <button class="btn btn-success" disabled>
                                                Apply
                                            </button>
                                        @else
                                            <a class="btn btn-success" data-bs-toggle="modal"
                                                data-bs-target="#apply-modal"
                                                wire:click="applyConfirm({{ $data->no }})">
                                                Apply
                                            </a>
                                        @endif
                                    </div>
                                @else
                                    <button class="btn btn-outline-primary" data-bs-toggle="modal"
                                        data-bs-target="#detail-modal" wire:click="detail({{ $data->no }})">
                                        Detail
                                    </button>
                                @endif
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

    {{-- Modal Update --}}

    <div class="modal modal-blur fade" id="update-modal" tabindex="-1" role="dialog" aria-hidden="true"
        wire:ignore.self>
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Production Card - {{ $no_kp }}</h5>
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
                        <div class="card">
                            <div class="card-body">
                                <div class="datagrid">
                                    <div class="datagrid-item">
                                        <div class="datagrid-title">Material Code</div>
                                        <div class="datagrid-content"><b>{{ $material_code }}</b></div>
                                    </div>
                                    <div class="datagrid-item">
                                        <div class="datagrid-title">Material Description</div>
                                        <div class="datagrid-content"><b>{{ $desc }}</b></div>
                                    </div>
                                    <div class="datagrid-item">
                                        <div class="datagrid-title">Color</div>
                                        <div class="datagrid-content">{{ $color }}</div>
                                    </div>
                                    <div class="datagrid-item">
                                        <div class="datagrid-title"></div>
                                        <div class="datagrid-content"></div>
                                    </div>
                                    <div class="datagrid-item">
                                        <div class="datagrid-title">Size</div>
                                        <div class="datagrid-content">{{ $size }} {{ $uom }}</div>
                                    </div>
                                    <div class="datagrid-item">
                                        <div class="datagrid-title">Quantity</div>
                                        <div class="datagrid-content">{{ $qty }} {{ $uom1 }}</div>
                                    </div>
                                    <div class="datagrid-item">
                                        <div class="datagrid-title">Purchase Order Supplier</div>
                                        <div class="datagrid-content">{{ $po_sup }}</div>
                                    </div>
                                    <div class="datagrid-item">
                                        <div class="datagrid-title">Purchase Order Buyer</div>
                                        <div class="datagrid-content">{{ $po_buyer }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card mt-3">
                            <div class="card-body">
                                <label class="form-label required">Supplier</label>
                                <select class="form-control @error('supplier') is-invalid @enderror"
                                    wire:model="supplier">
                                    <option value="">-- Select Supplier --</option>
                                    @foreach ($suppliers as $supplier)
                                        <option value="{{ $supplier->supplier }}">{{ $supplier->supplier }}</option>
                                    @endforeach
                                </select>
                                @error('supplier')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="card mt-3">
                            <div class="card-body">
                                <label class="form-label required">Invoice No.</label>
                                <input type="text" class="form-control @error('invoice') is-invalid @enderror"
                                    wire:model="invoice">
                                @error('invoice')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror

                                <label class="form-label required mt-3">Currency</label>
                                <select class="form-control @error('currency') is-invalid @enderror"
                                    wire:model="currency">
                                    <option value="">-- Select Currency --</option>
                                    <option value="IDR">IDR</option>
                                    <option value="USD">USD</option>
                                </select>
                                @error('currency')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror

                                <label class="form-label required mt-3">Price</label>
                                <input type="number" class="form-control @error('price') is-invalid @enderror"
                                    wire:model="price">
                                @error('price')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror

                                <label class="form-label required mt-3">Estimated Date Arrival</label>
                                <input type="date" class="form-control @error('etd') is-invalid @enderror"
                                    wire:model="etd">
                                @error('etd')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror

                                <label class="form-label required mt-3">Airway Bill</label>
                                <input type="text" class="form-control @error('awb') is-invalid @enderror"
                                    wire:model="awb">
                                @error('awb')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="modal-footer">
                            <a href="#" class="btn btn-link link-secondary" data-bs-dismiss="modal">
                                Cancel
                            </a>
                            <a href="#" class="btn btn-primary ms-auto" wire:click="update">
                                Update
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal Apply --}}

    <div class="modal modal-blur fade" id="apply-modal" tabindex="-1" role="dialog" aria-hidden="true"
        wire:ignore.self>
        <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
            <div class="modal-content">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                <div class="modal-status bg-success"></div>
                <div class="modal-body text-center py-4">
                    <h3>Apply Purchase</h3>
                    <div class="text-muted">Do you really want to apply this purchase ? Your purchase will be send to
                        Warehouse Departemen.
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
                                <a href="#" class="btn btn-success w-100" wire:click="apply">
                                    Apply
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal Detail --}}

    <div class="modal modal-blur fade" id="detail-modal" tabindex="-1" role="dialog" aria-hidden="true"
        wire:ignore.self>
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Production Card - {{ $no_kp }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div wire:loading wire:target="detail">
                    <div class="text-center">
                        <div class="progress progress-sm">
                            <div class="progress-bar progress-bar-indeterminate"></div>
                        </div>
                    </div>
                </div>
                <div wire:loading.remove wire:target="detail">
                    <div class="modal-body">
                        <div class="card">
                            <div class="card-body">
                                <div class="datagrid">
                                    <div class="datagrid-item">
                                        <div class="datagrid-title">Material Code</div>
                                        <div class="datagrid-content"><b>{{ $material_code }}</b></div>
                                    </div>
                                    <div class="datagrid-item">
                                        <div class="datagrid-title">Material Description</div>
                                        <div class="datagrid-content"><b>{{ $desc }}</b></div>
                                    </div>
                                    <div class="datagrid-item">
                                        <div class="datagrid-title">Color</div>
                                        <div class="datagrid-content">{{ $color }}</div>
                                    </div>
                                    <div class="datagrid-item">
                                        <div class="datagrid-title"></div>
                                        <div class="datagrid-content"></div>
                                    </div>
                                    <div class="datagrid-item">
                                        <div class="datagrid-title">Size</div>
                                        <div class="datagrid-content">{{ $size }} {{ $uom }}</div>
                                    </div>
                                    <div class="datagrid-item">
                                        <div class="datagrid-title">Quantity</div>
                                        <div class="datagrid-content">{{ $qty }} {{ $uom1 }}</div>
                                    </div>
                                    <div class="datagrid-item">
                                        <div class="datagrid-title">Purchase Order Supplier</div>
                                        <div class="datagrid-content">{{ $po_sup }}</div>
                                    </div>
                                    <div class="datagrid-item">
                                        <div class="datagrid-title">Purchase Order Buyer</div>
                                        <div class="datagrid-content">{{ $po_buyer }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card mt-3">
                            <div class="card-body">
                                <div class="datagrid">
                                    <div class="datagrid-item">
                                        <div class="datagrid-title">Supplier</div>
                                        <div class="datagrid-content"><b>{{ $supplier_name }}</b></div>
                                    </div>
                                    <div class="datagrid-item">
                                        <div class="datagrid-title">Invoice No.</div>
                                        <div class="datagrid-content"><b>{{ $invoice }}</b></div>
                                    </div>
                                    <div class="datagrid-item">
                                        <div class="datagrid-title">Price</div>
                                        <div class="datagrid-content">{{ $currency }} {{ $price }}</div>
                                    </div>
                                    <div class="datagrid-item">
                                        <div class="datagrid-title">Estimated Date Arrival</div>
                                        <div class="datagrid-content">{{ $etd }}</div>
                                    </div>
                                    <div class="datagrid-item">
                                        <div class="datagrid-title">Airway Bill</div>
                                        <div class="datagrid-content">{{ $awb }}</div>
                                    </div>
                                    <div class="datagrid-item">
                                        <div class="datagrid-content">
                                            <img src="data:image/png;base64,{{ DNS1D::getBarcodePNG($awb, 'C39', 3, 73) }}"
                                                alt="barcode" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <a href="#" class="btn btn-link link-secondary" data-bs-dismiss="modal">
                                    Close
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @script
        <script>
            $wire.on('update-modal-close', () => {
                $('#update-modal').modal('hide');
            });
            $wire.on('update-success', (data) => {
                toastr.options = {
                    progressBar: true,
                };
                toastr.options.positionClass = "toast-bottom-right";
                toastr.success(data.message);
            });

            $wire.on('apply-modal-close', () => {
                $('#apply-modal').modal('hide');
            });
            $wire.on('apply-success', (data) => {
                toastr.options = {
                    progressBar: true,
                };
                toastr.options.positionClass = "toast-bottom-right";
                toastr.success(data.message);
            });
        </script>
    @endscript

</div>
