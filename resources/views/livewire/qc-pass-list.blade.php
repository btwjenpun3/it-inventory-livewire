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
                        <tr wire:key="{{ $data->no }}">
                            <td>{{ $datas->firstItem() + $index }}</td>
                            <td><b>{{ $data->item }}</b></td>
                            <td>{{ $data->desc }}</td>
                            <td>{{ $data->color }}</td>
                            <td>{{ $data->size }} {{ $data->uom }}</td>
                            <td>{{ $data->qty }} {{ $data->uom1 }}</td>
                            <td>{{ $data->supp }}</td>
                            <td class="text-end">
                                <button class="btn btn-primary align-text-top" data-bs-target="#update-modal"
                                    data-bs-toggle="modal" wire:click="show({{ $data->no }})">
                                    Details
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
                                        <div class="datagrid-title">Material Size</div>
                                        <div class="datagrid-content">{{ $size }} {{ $uom }}</div>
                                    </div>
                                    <div class="datagrid-item">
                                        <div class="datagrid-title">Material Quantity</div>
                                        <div class="datagrid-content">{{ $qty }}</div>
                                    </div>
                                    <div class="datagrid-item">
                                        <div class="datagrid-title">Quantity Received</div>
                                        <div class="datagrid-content">{{ $qty_rcvd }} {{ $uom1 }}</div>
                                    </div>
                                    <div class="datagrid-item">
                                        <div class="datagrid-title">Quantity Pass</div>
                                        <div class="datagrid-content">
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                class="icon icon-tabler icon-tabler-square-check" width="24"
                                                height="24" viewBox="0 0 24 24" stroke-width="1.5"
                                                stroke="currentColor" fill="none" stroke-linecap="round"
                                                stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                <path
                                                    d="M3 3m0 2a2 2 0 0 1 2 -2h14a2 2 0 0 1 2 2v14a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2z" />
                                                <path d="M9 12l2 2l4 -4" />
                                            </svg>
                                            <b>
                                                {{ $qty_passqc }}
                                            </b>
                                        </div>
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
