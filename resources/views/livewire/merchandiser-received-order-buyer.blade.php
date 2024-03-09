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
            <div class="col-auto ms-auto d-print-none">
                <div class="btn-list">
                    <a href="#" class="btn btn-primary d-none d-sm-inline-block" data-bs-toggle="collapse"
                        data-bs-target="#add-collapse">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                            viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                            stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M12 5l0 14" />
                            <path d="M5 12l14 0" />
                        </svg>
                        Add new
                    </a>
                </div>
            </div>
        </div>
    </div>

    {{-- Collapse --}}

    <div class="collapse mt-3 mb-3" id="add-collapse" wire:ignore.self>
        <div class="card card-body">
            <div class="card-title">
                <h3>Received Order Plan</h3>
            </div>
            <div class="row">
                <div class="col">
                    <label class="form-label required">Purchase Order Buyer</label>
                    <input type="text" class="form-control @error('po_buyer') is-invalid @enderror"
                        wire:model="po_buyer">
                    @error('po_buyer')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror

                    <label class="form-label required mt-3">Customer</label>
                    <select class="form-control @error('id_cust') is-invalid @enderror" wire:model="id_cust">
                        <option value="">-- Select --</option>
                        @foreach ($buyers as $buyer)
                            <option value="{{ $buyer->code }}">{{ $buyer->code }} - {{ $buyer->name }}</option>
                        @endforeach
                    </select>
                    @error('id_cust')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror

                    <label class="form-label required mt-3">Article / Style</label>
                    <input type="text" class="form-control @error('article') is-invalid @enderror"
                        wire:model="article">
                    @error('article')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror

                    <label class="form-label required mt-3">Merchandiser</label>
                    <input type="text" class="form-control @error('md') is-invalid @enderror" wire:model="md">
                    @error('md')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror

                    <label class="form-label required mt-3">Quantity</label>
                    <input type="text" class="form-control @error('qty') is-invalid @enderror" wire:model="qty">
                    @error('qty')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <button type="submit" wire:loading.attr="disabled" class="btn btn-primary mt-4"
                    wire:click="save">Save</button>

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
                        <th>Order Buyer Code</th>
                        <th>Purchase Order Buyer</th>
                        <th>Date</th>
                        <th>Article</th>
                        <th>Customer</th>
                        <th>Merchandiser</th>
                        <th>Quantity</th>
                        <th>Status</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($orderBuyers as $index => $data)
                        <tr wire:key="{{ $data->id }}">
                            <td>{{ $orderBuyers->firstItem() + $index }}</td>
                            <td><b>{{ $data->ob }}</b></td>
                            <td>{{ $data->po_buyer }}</td>
                            <td>{{ $data->date }}</td>
                            <td>{{ $data->article }}</td>
                            <td>{{ $data->cust }}</td>
                            <td>{{ $data->md }}</td>
                            <td>{{ $data->qty }}</td>
                            @if ($data->valid === null)
                                <td><span class="badge bg-purple text-purple-fg">Draft</span></td>
                                <td>
                                    <div class="btn-list flex-nowrap">
                                        <a class="btn btn-success" data-bs-toggle="modal" data-bs-target="#apply-modal"
                                            wire:click="apply({{ $data->id }})">
                                            Apply
                                        </a>
                                        <a class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#update-modal"
                                            wire:click="show({{ $data->id }})">
                                            Edit
                                        </a>
                                        <a class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#delete-modal"
                                            wire:click="deleteConfirm({{ $data->id }})">
                                            Delete
                                        </a>
                                    </div>
                                </td>
                            @elseif ($data->valid === 'Waiting')
                                <td><span class="badge bg-yellow text-yellow-fg">Waiting</span></td>
                                <td></td>
                            @elseif ($data->valid === 'Received')
                                <td><span class="badge bg-green text-green-fg">Received</span></td>
                                <td></td>
                            @endif
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="mt-3 d-flex justify-content-end">
            {{ $orderBuyers->links() }}
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
                    <h3>Apply and Send</h3>
                    <div class="text-muted">Do you really want to apply ? Your order plans will be send to Approval
                        Departemen.
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
                                <a href="#" class="btn btn-success w-100" wire:click="send">
                                    Apply
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal Update --}}

    <div class="modal modal-blur fade" id="update-modal" tabindex="-1" role="dialog" aria-hidden="true"
        wire:ignore.self>
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Update Supplier</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col">
                            <label class="form-label required">Purchase Order Buyer</label>
                            <input type="text" class="form-control @error('po_buyer') is-invalid @enderror"
                                wire:model="po_buyer">
                            @error('po_buyer')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror

                            <label class="form-label required mt-3">Customer</label>
                            <select class="form-control @error('id_cust') is-invalid @enderror" wire:model="id_cust">
                                <option value="">-- Select --</option>
                                @foreach ($buyers as $buyer)
                                    <option value="{{ $buyer->code }}">{{ $buyer->code }} - {{ $buyer->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('id_cust')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror

                            <label class="form-label required mt-3">Article / Style</label>
                            <input type="text" class="form-control @error('article') is-invalid @enderror"
                                wire:model="article">
                            @error('article')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror

                            <label class="form-label required mt-3">Merchandiser</label>
                            <input type="text" class="form-control @error('md') is-invalid @enderror"
                                wire:model="md">
                            @error('md')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror

                            <label class="form-label required mt-3">Quantity</label>
                            <input type="text" class="form-control @error('qty') is-invalid @enderror"
                                wire:model="qty">
                            @error('qty')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <a href="#" class="btn btn-link link-secondary" data-bs-dismiss="modal">
                        Cancel
                    </a>
                    <a href="#" class="btn btn-primary ms-auto" wire:click="update">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                            viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                            stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M12 5l0 14" />
                            <path d="M5 12l14 0" />
                        </svg>
                        Update
                    </a>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal Delete --}}

    <div class="modal modal-blur fade" id="delete-modal" tabindex="-1" role="dialog" aria-hidden="true"
        wire:ignore.self>
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
            $wire.on('apply-modal-close', () => {
                $('#apply-modal').modal('hide');
            });
            $wire.on('create-success', (data) => {
                toastr.options = {
                    progressBar: true,
                };
                toastr.options.positionClass = "toast-bottom-right";
                toastr.success(data);
            });
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
