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
                    <a href="#" class="btn btn-success d-none d-sm-inline-block" data-bs-toggle="collapse"
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
                <h3>Add Material</h3>
            </div>
            <div class="row">
                <div class="col">

                    <label class="form-label required">Buyer Code</label>
                    <select class="form-control @error('code_buyer') is-invalid @enderror" wire:model="code_buyer">
                        <option value="">-- Select Buyer --</option>
                        @foreach ($buyers as $buyer)
                            <option value="{{ $buyer->code }}">{{ $buyer->code }} - {{ $buyer->name }}</option>
                        @endforeach
                    </select>
                    @error('code_buyer')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror

                    <div class="row">
                        <div class="col-md-6">
                            <label class="form-label required mt-3">Material Code</label>
                            <input type="text" class="form-control @error('items') is-invalid @enderror"
                                wire:model="items">
                            @error('items')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label required mt-3">Category</label>
                            <select class="form-control @error('mat_type') is-invalid @enderror" wire:model="mat_type">
                                <option value="">-- Choose --</option>
                                <option value="A">Accessories</option>
                                <option value="F">Fabric</option>
                            </select>
                            @error('mat_type')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <label class="form-label required mt-3">Material Description</label>
                    <input type="text" class="form-control @error('desc') is-invalid @enderror" wire:model="desc">
                    @error('desc')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror

                    <button type="submit" wire:loading.attr="disabled" class="btn btn-primary mt-3"
                        wire:click="save">Save</button>
                </div>
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
                        <th>Buyer Code</th>
                        <th>Material Code</th>
                        <th>Category</th>
                        <th>Material Description</th>
                        <td class="w-1"></td>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($datas as $index => $data)
                        <tr wire:key="{{ $data->id_item }}">
                            <td>{{ $datas->firstItem() + $index }}</td>
                            <td>{{ $data->code_buyer }}</td>
                            <td>{{ $data->items }}</td>
                            <td>{{ $data->mat_type }}</td>
                            <td>{{ $data->desc }}</td>
                            <td class="text-end">
                                <a class="btn dropdown-toggle align-text-top" data-bs-boundary="viewport"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    Actions
                                </a>
                                <div class="dropdown-menu dropdown-menu-end">
                                    <a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#update-modal"
                                        wire:click="show({{ $data->id_item }})">
                                        Edit
                                    </a>
                                    <a class="dropdown-item text-danger" data-bs-toggle="modal"
                                        data-bs-target="#delete-modal"
                                        wire:click="deleteConfirm({{ $data->id_item }})">
                                        Delete
                                    </a>
                                </div>
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
                    <h5 class="modal-title">Update Material</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <div class="mb-3">
                        <label class="form-label required">Buyer Code</label>
                        <select class="form-control @error('_code_buyer') is-invalid @enderror"
                            wire:model="_code_buyer">
                            @foreach ($buyers as $buyer)
                                <option value="{{ $buyer->code }}">{{ $buyer->code }} - {{ $buyer->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('_code_buyer')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label required">Material Code</label>
                                <input type="text" class="form-control @error('_items') is-invalid @enderror"
                                    wire:model="_items">
                                @error('_items')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label required">Category</label>
                                <select class="form-control @error('_mat_type') is-invalid @enderror"
                                    wire:model="_mat_type">
                                    <option value="A" @if ($_mat_type == 'A') selected @endif>
                                        Accessories</option>
                                    <option value="F" @if ($_mat_type == 'F') selected @endif>Fabric
                                    </option>
                                </select>
                                @error('_mat_type')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label required">Material Description</label>
                        <input type="text" class="form-control @error('_desc') is-invalid @enderror"
                            wire:model="_desc">
                        @error('_desc')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                </div>
                <div class="modal-footer">
                    <a href="#" class="btn btn-link link-secondary" data-bs-dismiss="modal">
                        Cancel
                    </a>
                    <a href="#" class="btn btn-primary ms-auto" wire:click="update" id="update">
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
            $wire.on('create-success', (data) => {
                toastr.options = {
                    progressBar: true,
                };
                toastr.options.positionClass = "toast-bottom-right";
                toastr.success(data.message);
            });

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
