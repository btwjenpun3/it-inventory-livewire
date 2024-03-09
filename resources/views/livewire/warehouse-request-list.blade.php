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
                        <th>No Transaction</th>
                        <th>PIC</th>
                        <th>Quantity</th>
                        <th>Quantity Sent</th>
                        <th>Request Date</th>
                        <th>Sent Date</th>
                        <th>Status</th>
                        <td class="w-1"></td>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($datas as $index => $data)
                        @if ($data->kpReceived && $data->kpReceived->status === 'Received')
                        @else
                            <tr wire:key="{{ $data->id_req }}">
                                <td>{{ $datas->firstItem() + $index }}</td>
                                <td><b>{{ $data->no_trans }}</b></td>
                                <td>{{ $data->pic }}</td>
                                <td>{{ $data->qty }}</td>
                                <td>{{ $data->qty_sent }}</td>
                                <td>{{ $data->pick_date }}</td>
                                <td>
                                    @if (isset($data->date_sent))
                                        {{ $data->date_sent }}
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>
                                    @switch($data->status)
                                        @case('Requested')
                                            <span class="badge bg-warning">Requested</span>
                                        @break

                                        @case('Finish')
                                            <span class="badge bg-success">Finish</span>
                                        @break

                                        @default
                                    @endswitch
                                </td>
                                <td class="text-end">
                                    <button class="btn btn-primary align-text-top" data-bs-target="#update-modal"
                                        data-bs-toggle="modal" wire:click="show({{ $data->id_req }})">
                                        Send
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
                    <h5 class="modal-title">Request - {{ $no_trans }}</h5>
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
                                        <div class="datagrid-title">No. KP</div>
                                        <div class="datagrid-content"><b>{{ $no_kp }}</b></div>
                                    </div>
                                    <div class="datagrid-item">
                                        <div class="datagrid-title">PIC</div>
                                        <div class="datagrid-content"><b>{{ $pic }}</b></div>
                                    </div>
                                    <div class="datagrid-item">
                                        <div class="datagrid-title">Material Code</div>
                                        <div class="datagrid-content">{{ $item }}</div>
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
                                        <div class="datagrid-content">{{ $size }} {{ $uom }}</div>
                                    </div>
                                    <div class="datagrid-item text-success">
                                        <div class="datagrid-title">Allowen Quantity</div>
                                        <div class="datagrid-content">{{ $allowen_qty_req }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card mt-3">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <label class="form-label required">Quantity Sent</label>
                                        <input type="text"
                                            class="form-control @error('qty_sent') is-invalid @enderror"
                                            wire:model="qty_sent">
                                        @error('qty_sent')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-12 mt-3">
                                        <label class="form-label required">Creator</label>
                                        <input type="text"
                                            class="form-control @error('creator') is-invalid @enderror"
                                            wire:model="creator">
                                        @error('creator')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <a href="#" class="btn btn-link link-secondary" data-bs-dismiss="modal">
                                Cancel
                            </a>
                            <button class="btn btn-success ms-auto" wire:click="update" wire:loading.attr="disabled">
                                Send
                            </button>
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
                toastr.success(data);
            });
            $wire.on('error', (data) => {
                toastr.error(data);
            });
        </script>
    @endscript

</div>
