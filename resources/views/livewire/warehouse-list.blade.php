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
                        @else
                        @endif
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
                                        <div class="datagrid-title">BC No.</div>
                                        <div class="datagrid-content">{{ $bc_no }}</div>
                                    </div>
                                    <div class="datagrid-item">
                                        <div class="datagrid-title">Jenis BC</div>
                                        <div class="datagrid-content">BC {{ $jenis_bc }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card mt-3">
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
                                <div class="datagrid">
                                    <div class="datagrid-item">
                                        <div class="datagrid-title">ID Trans.</div>
                                        <div class="datagrid-content"><b>{{ $id_trans }}</b></div>
                                    </div>
                                    <div class="datagrid-item">
                                        <div class="datagrid-title">No. SJ</div>
                                        <div class="datagrid-content"><b>{{ $sj }}</b></div>
                                    </div>
                                    <div class="datagrid-item">
                                        <div class="datagrid-title">Doc. Date</div>
                                        <div class="datagrid-content">{{ $doc_date }}</div>
                                    </div>
                                    <div class="datagrid-item">
                                        <div class="datagrid-title">Del. Date</div>
                                        <div class="datagrid-content">{{ $del_date }}</div>
                                    </div>
                                    <div class="datagrid-item">
                                        <div class="datagrid-title">Ekspedisi</div>
                                        <div class="datagrid-content">{{ $ekspedisi }}</div>
                                    </div>
                                    <div class="datagrid-item">
                                        <div class="datagrid-title">No. SJ Ekspedisi</div>
                                        <div class="datagrid-content">{{ $nosj_ekspedisi }}</div>
                                    </div>
                                    <div class="datagrid-item">
                                        <div class="datagrid-title">No. Tracking / AWB</div>
                                        <div class="datagrid-content">{{ $awb }}</div>
                                    </div>
                                    <div class="datagrid-item">
                                        <div class="datagrid-title">Quantity Received</div>
                                        <div class="datagrid-content">{{ $qty_received }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card mt-3">
                            <div class="card-body">
                                <div class="datagrid">
                                    <div class="datagrid-item">
                                        <div class="datagrid-title">Note</div>
                                        <div class="datagrid-content">{{ $ket }}</div>
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
