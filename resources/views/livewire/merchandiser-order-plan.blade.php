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
                    <button href="#" class="btn btn-success d-none d-sm-inline-block"
                        @if ($count === 0) disabled @endif
                        @if ($count > 0) data-bs-toggle="modal"
                        data-bs-target="#apply-modal" @endif>
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-device-floppy"
                            width="24" height="24" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                            fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M6 4h10l4 4v10a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2" />
                            <path d="M12 14m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" />
                            <path d="M14 4l0 4l-6 0l0 -4" />
                        </svg>
                        Apply All
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- Collapse --}}

    <div class="collapse mt-3 mb-3" id="add-collapse" wire:ignore.self>
        <div class="card card-body">
            <div class="card-title">
                <h3>Add Order Plan</h3>
            </div>
            <div class="row">
                <div class="col">

                    <label class="form-label required">Buyer Code</label>
                    <select class="form-control @error('buyer_code') is-invalid @enderror" wire:model="buyer_code">
                        <option value="">-- Select Buyer Code --</option>
                        @foreach ($buyers as $buyer)
                            <option value="{{ $buyer->code }}">{{ $buyer->code }} - {{ $buyer->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('buyer_code')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror

                    <label class="form-label required mt-3">Purchase Order Buyer</label>
                    <select class="form-control @error('po_buyer') is-invalid @enderror" wire:model="po_buyer">
                        <option value="">-- Select Purchase Order Buyer --</option>
                        @foreach ($poBuyers as $poBuyer)
                            <option value="{{ $poBuyer->po_buyer }}">{{ $poBuyer->po_buyer }} - (Quantity)
                                {{ $poBuyer->qty }}
                            </option>
                        @endforeach
                    </select>
                    @error('po_buyer')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror

                    <label class="form-label required mt-3">Material</label>
                    <select class="form-control @error('material') is-invalid @enderror" wire:model="material">
                        <option value="">-- Select Material --</option>
                        @foreach ($materials as $material)
                            <option value="{{ $material->items }}">{{ $material->desc }} - (Code)
                                {{ $material->items }}
                            </option>
                        @endforeach
                    </select>
                    @error('material')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror

                </div>

                <div class="col">
                    <div class="row">
                        <div class="col-md-3">
                            <label class="form-label required">Size</label>
                            <input type="text" class="form-control @error('size') is-invalid @enderror"
                                wire:model="size">
                            @error('size')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-9">
                            <label class="form-label required">Unit of Material</label>
                            <select class="form-control @error('uom') is-invalid @enderror" wire:model="uom">
                                <option value="">-- Select Unit of Material --</option>
                                <option value="METER">METER</option>
                                <option value="YARD">YARD</option>
                                <option value="PCS">PCS</option>
                                <option value="CNS">CNS</option>
                            </select>
                            @error('uom')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-md-3">
                            <label class="form-label required">Quantity</label>
                            <input type="text" class="form-control @error('qty') is-invalid @enderror"
                                wire:model="qty">
                            @error('qty')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-9">
                            <label class="form-label required">Unit of Quantity</label>
                            <select class="form-control @error('uom2') is-invalid @enderror" wire:model="uom2">
                                <option value="">-- Select Unit of Quantity --</option>
                                <option value="METER">METER</option>
                                <option value="YARD">YARD</option>
                                <option value="PCS">PCS</option>
                                <option value="CNS">CNS</option>
                            </select>
                            @error('uom2')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                </div>

                <div class="col">

                    <label class="form-label required">Color</label>
                    <input type="text" class="form-control @error('color') is-invalid @enderror" wire:model="color">
                    @error('color')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror

                    <label class="form-label required mt-3">Purchase Order Supplier</label>
                    <input type="text" class="form-control @error('po_supp') is-invalid @enderror"
                        wire:model="po_supp">
                    @error('po_supp')
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
                        <th>Buyer Code</th>
                        <th>Purchase Order Buyer</th>
                        <th>Material</th>
                        <th>Material Description</th>
                        <th>Size</th>
                        <th>Unit of Material</th>
                        <th>Quantity</th>
                        <th>Unit of Quantity</th>
                        <th>Color</th>
                        <th>Purchase Order Supplier</th>
                        <th>Quantity Garment</th>
                        <td class="w-1"></td>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($datas as $index => $data)
                        <tr wire:key="{{ $data->id_item }}">
                            <td>{{ $datas->firstItem() + $index }}</td>
                            <td>{{ $data->code_buyer }}</td>
                            <td>{{ $data->po_buyer }}</td>
                            <td>{{ $data->item }}</td>
                            <td>{{ $data->item_description }}</td>
                            <td>{{ $data->size }}</td>
                            <td>{{ $data->unit_of_material }}</td>
                            <td>{{ $data->quantity }}</td>
                            <td>{{ $data->unit_of_material_2 }}</td>
                            <td>{{ $data->color }}</td>
                            <td>{{ $data->po_supplier }}</td>
                            <td>{{ $data->quantity_garment }}</td>
                            <td class="text-end">
                                <a class="btn dropdown-toggle align-text-top" data-bs-boundary="viewport"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    Actions
                                </a>
                                <div class="dropdown-menu dropdown-menu-end">
                                    <a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#update-modal"
                                        wire:click="show({{ $data->id }})">
                                        Edit
                                    </a>
                                    <a class="dropdown-item text-danger" data-bs-toggle="modal"
                                        data-bs-target="#delete-modal"
                                        wire:click="deleteConfirm({{ $data->id }})">
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
                    <h5 class="modal-title">Update Supplier</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <div class="row">
                        <div class="col">

                            <label class="form-label required">Buyer Code</label>
                            <select class="form-control @error('buyer_code_') is-invalid @enderror"
                                wire:model="buyer_code_">
                                <option value="">-- Select Buyer Code --</option>
                                @foreach ($buyers as $buyer)
                                    <option value="{{ $buyer->code }}">{{ $buyer->code }} - {{ $buyer->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('buyer_code_')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror

                            <label class="form-label required mt-3">Purchase Order Buyer</label>
                            <select class="form-control @error('po_buyer_') is-invalid @enderror"
                                wire:model="po_buyer_">
                                <option value="">-- Select Purchase Order Buyer --</option>
                                @foreach ($poBuyers as $poBuyer)
                                    <option value="{{ $poBuyer->po_buyer }}">{{ $poBuyer->po_buyer }} - (Quantity)
                                        {{ $poBuyer->qty }}
                                    </option>
                                @endforeach
                            </select>
                            @error('po_buyer_')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror

                            <label class="form-label required mt-3">Material</label>
                            <select class="form-control @error('material_') is-invalid @enderror"
                                wire:model="material_">
                                <option value="">-- Select Material --</option>
                                @foreach ($materials as $material)
                                    <option value="{{ $material->items }}">{{ $material->desc }} - (Code)
                                        {{ $material->items }}
                                    </option>
                                @endforeach
                            </select>
                            @error('material_')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror

                        </div>

                        <div class="col">
                            <div class="row">
                                <div class="col-md-5">
                                    <label class="form-label required">Size</label>
                                    <input type="text" class="form-control @error('size_') is-invalid @enderror"
                                        wire:model="size_">
                                    @error('size_')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-7">
                                    <label class="form-label required">Unit of Material</label>
                                    <select class="form-control @error('uom_') is-invalid @enderror"
                                        wire:model="uom_">
                                        <option value="">-- Select Unit of Material --</option>
                                        <option value="METER">METER</option>
                                        <option value="YARD">YARD</option>
                                        <option value="PCS">PCS</option>
                                        <option value="CNS">CNS</option>
                                    </select>
                                    @error('uom_')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-md-5">
                                    <label class="form-label required">Quantity</label>
                                    <input type="text" class="form-control @error('qty_') is-invalid @enderror"
                                        wire:model="qty_">
                                    @error('qty_')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-7">
                                    <label class="form-label required">Unit of Quantity</label>
                                    <select class="form-control @error('uom2_') is-invalid @enderror"
                                        wire:model="uom2_">
                                        <option value="">-- Select Unit of Quantity --</option>
                                        <option value="METER">METER</option>
                                        <option value="YARD">YARD</option>
                                        <option value="PCS">PCS</option>
                                        <option value="CNS">CNS</option>
                                    </select>
                                    @error('uom2_')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                        </div>

                        <div class="col">

                            <label class="form-label required">Color</label>
                            <input type="text" class="form-control @error('color_') is-invalid @enderror"
                                wire:model="color_">
                            @error('color_')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror

                            <label class="form-label required mt-3">Purchase Order Supplier</label>
                            <input type="text" class="form-control @error('po_supp_') is-invalid @enderror"
                                wire:model="po_supp_">
                            @error('po_supp_')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror

                        </div>

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

    {{-- Modal Apply --}}

    <div class="modal modal-blur fade" id="apply-modal" tabindex="-1" role="dialog" aria-hidden="true"
        wire:ignore.self>
        <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
            <div class="modal-content">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                <div class="modal-status bg-success"></div>
                <div class="modal-body text-center py-4">
                    <h3>Apply All</h3>
                    <div class="text-muted">Do you really want to apply all ? Your order plans will be send to Approval
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
                                <a href="#" class="btn btn-success w-100" wire:click="apply">
                                    Apply All
                                </a>
                            </div>
                        </div>
                    </div>
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
            $wire.on('create-success', (data) => {
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
