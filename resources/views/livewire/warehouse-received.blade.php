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
                        <th>Material Code</th>
                        <th>Material Description</th>
                        <th>Material Color</th>
                        <th>Material Size</th>
                        <th>Material Quantity</th>
                        <th>Supplier</th>
                        <td class="w-1"></td>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($datas as $index => $data)
                        @if ($data->kpReceived && $data->kpReceived->status === 'Received')
                        @else
                            <tr wire:key="{{ $data->no }}">
                                <td>{{ $datas->firstItem() + $index }}</td>
                                <td><b>{{ $data->item }}</b></td>
                                <td>{{ $data->desc }}</td>
                                <td>{{ $data->color }}</td>
                                <td>{{ $data->size }} {{ $data->uom }}</td>
                                <td>{{ $data->qty }} {{ $data->uom1 }}</td>
                                <td>{{ $data->supp }}</td>
                                <td class="text-end">
                                    <button class="btn btn-success align-text-top" data-bs-target="#update-modal"
                                        data-bs-toggle="modal" wire:click="show({{ $data->no }})">
                                        Receive
                                    </button>
                                </td>
                            </tr>
                        @endif
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
                                        <div class="datagrid-title">Supplier</div>
                                        <div class="datagrid-content"><b>{{ $supp }}</b></div>
                                    </div>
                                    <div class="datagrid-item">
                                        <div class="datagrid-title">Material Code</div>
                                        <div class="datagrid-content"><b>{{ $item }}</b></div>
                                    </div>
                                    <div class="datagrid-item">
                                        <div class="datagrid-title">Material Description</div>
                                        <div class="datagrid-content">{{ $desc }}</div>
                                    </div>
                                    <div class="datagrid-item">
                                        <div class="datagrid-title">Material Color</div>
                                        <div class="datagrid-content">{{ $color }}</div>
                                    </div>
                                    <div class="datagrid-item">
                                        <div class="datagrid-title">Material Size</div>
                                        <div class="datagrid-content">{{ $size }} {{ $uom }}
                                        </div>
                                    </div>
                                    <div class="datagrid-item">
                                        <div class="datagrid-title">Material Quantity</div>
                                        <div class="datagrid-content">{{ $size }} {{ $uom1 }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card mt-3">
                            <div class="card-body">

                                <label class="form-label required mt-3">No. Surat Jalan</label>
                                <input type="text" class="form-control @error('sj') is-invalid @enderror"
                                    wire:model="sj">
                                @error('sj')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror

                                <div class="row">
                                    <div class="col-md-6">
                                        <label class="form-label required mt-3">Doc. Date</label>
                                        <input type="date"
                                            class="form-control @error('doc_date') is-invalid @enderror"
                                            wire:model="doc_date">
                                        @error('doc_date')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label required mt-3">Receive Date</label>
                                        <input type="date"
                                            class="form-control @error('del_date') is-invalid @enderror"
                                            wire:model="del_date">
                                        @error('del_date')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label class="form-label required mt-3">Ekspedisi</label>
                                        <input type="text"
                                            class="form-control @error('ekspedisi') is-invalid @enderror"
                                            wire:model="ekspedisi">
                                        @error('ekspedisi')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label required mt-3">No. SJ Ekspedisi</label>
                                        <input type="text"
                                            class="form-control @error('nosj_ekspedisi') is-invalid @enderror"
                                            wire:model="nosj_ekspedisi">
                                        @error('nosj_ekspedisi')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <label class="form-label required mt-3">No. Tracking / AWB</label>
                                <input type="text" class="form-control @error('awb') is-invalid @enderror"
                                    wire:model="awb">
                                @error('awb')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="card mt-3">
                            <div class="card-body">
                                <label class="form-label required">Jenis BC</label>
                                <select class="form-control @error('jenis_bc') is-invalid @enderror"
                                    wire:model="jenis_bc">
                                    <option value="">-- Select BC -- </option>
                                    <option value="1.0">BC 1.0</option>
                                    <option value="1.1">BC 1.1</option>
                                    <option value="1.2">BC 1.2</option>
                                    <option value="1.3">BC 1.3</option>
                                    <option value="1.6">BC 1.6</option>
                                    <option value="2.0">BC 2.0</option>
                                    <option value="2.1">BC 2.1</option>
                                    <option value="2.2">BC 2.2</option>
                                    <option value="2.3">BC 2.3</option>
                                    <option value="2.4">BC 2.4</option>
                                    <option value="2.5">BC 2.5</option>
                                    <option value="2.6.1">BC 2.6.1</option>
                                    <option value="2.6.2">BC 2.6.2</option>
                                    <option value="2.7">BC 2.7</option>
                                    <option value="2.8">BC 2.8</option>
                                    <option value="3.0">BC 3.0</option>
                                    <option value="3.2">BC 3.2</option>
                                    <option value="3.3">BC 3.3</option>
                                    <option value="3.4">BC 3.4</option>
                                    <option value="4.0">BC 4.0</option>
                                    <option value="4.1">BC 4.1</option>
                                </select>
                                @error('jenis_bc')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror

                                <label class="form-label required mt-3">BC Number</label>
                                <input type="text" class="form-control @error('bc_no') is-invalid @enderror"
                                    wire:model="bc_no">
                                @error('bc_no')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="card mt-3">
                            <div class="card-body">
                                <label class="form-label required">Quantity Received</label>
                                <input type="number" class="form-control @error('qty_received') is-invalid @enderror"
                                    wire:model="qty_received">
                                @error('qty_received')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror

                                <label class="form-label required mt-3">Note</label>
                                <input type="text" class="form-control @error('ket') is-invalid @enderror"
                                    wire:model="ket">
                                @error('ket')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="modal-footer">
                            <a href="#" class="btn btn-link link-secondary" data-bs-dismiss="modal">
                                Cancel
                            </a>
                            <a href="#" class="btn btn-success ms-auto" wire:click="update">
                                Receive
                            </a>
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
        </script>
    @endscript

</div>
