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
                        <th>Stock</th>
                        <th>Supplier</th>
                        <th>Status</th>
                        <td class="w-1"></td>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($datas as $index => $data)
                        <tr wire:key="{{ $data->no }}">
                            <td>{{ $datas->firstItem() + $index }}</td>
                            <td><b>{{ $data->item }}</b></td>
                            <td>{{ $data->desc }}</td>
                            <td>{{ $data->color }}</td>
                            <td>{{ $data->stock }}</td>
                            <td>{{ $data->supp }}</td>
                            @if ($data->stock > 0)
                                <td><span class="badge bg-green text-green-fg">Available</span></td>
                                <td class="text-end">
                                    <button class="btn btn-primary align-text-top" data-bs-target="#update-modal"
                                        data-bs-toggle="modal" wire:click="show({{ $data->no }})">
                                        Request
                                    </button>
                                </td>
                            @else
                                <td><span class="badge bg-red text-red-fg">Empty</span></td>
                                <td></td>
                            @endif
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
                                        <div class="datagrid-title">Supplier</div>
                                        <div class="datagrid-content"><b>{{ $supp }}</b></div>
                                    </div>
                                    <div class="datagrid-item">
                                        <div class="datagrid-title">Material Code</div>
                                        <div class="datagrid-content"><b>{{ $material }}</b></div>
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
                                        <div class="datagrid-title">Stock</div>
                                        <div class="datagrid-content">{{ $stock }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card mt-3">
                            <div class="card-body">
                                <label class="form-label required">Material Request</label>
                                <input type="text" class="form-control @error('qty_req') is-invalid @enderror"
                                    wire:model="qty_req">
                                @error('qty_req')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror

                                <label class="form-label required mt-3">PIC</label>
                                <input type="text" class="form-control @error('pic') is-invalid @enderror"
                                    wire:model="pic">
                                @error('pic')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="modal-footer">
                            <a href="#" class="btn btn-link link-secondary" data-bs-dismiss="modal">
                                Cancel
                            </a>
                            <a href="#" class="btn btn-success ms-auto" wire:click="update">
                                Request
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
            $wire.on('update-failed', (data) => {
                toastr.options = {
                    progressBar: true,
                };
                toastr.options.positionClass = "toast-bottom-right";
                toastr.error(data.message);
            });
        </script>
    @endscript

</div>
