<?php

use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Master\MasterAllocation;
use App\Livewire\ApprovalApproved;
use App\Livewire\ApprovalBuyerOrder;
use App\Livewire\ApprovalOrderPlan;
use App\Livewire\ApprovalRejected;
use App\Livewire\Dashboard;
use App\Livewire\MasterAllocation as LivewireMasterAllocation;
use App\Livewire\MasterBuyer;
use App\Livewire\MasterMaterial;
use App\Livewire\MasterSupplier;
use App\Livewire\MerchandiserOrderPlan;
use App\Livewire\MerchandiserReceivedOrderBuyer;
use App\Livewire\ProductionRequestList;
use App\Livewire\ProductionRequestMaterial;
use App\Livewire\PurchasePurchasing;
use App\Livewire\QcPassList;
use App\Livewire\QcPassMaterial;
use App\Livewire\WarehouseList;
use App\Livewire\WarehouseReceived;
use App\Livewire\WarehouseRequestList;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', Dashboard::class)->name('dashboard.index');

Route::get('/master/allocation', LivewireMasterAllocation::class)->name('master.allocation.index');

Route::get('/master/buyer', MasterBuyer::class)->name('master.buyer.index');

Route::get('/master/item', MasterMaterial::class)->name('master.material.index');

Route::get('/master/supplier', MasterSupplier::class)->name('master.supplier.index');

Route::get('/merchandiser/order-plan', MerchandiserOrderPlan::class)->name('merchandiser.order.plan.index');

Route::get('/merchandiser/received-order-plan', MerchandiserReceivedOrderBuyer::class)->name('merchandiser.received.order.plan.index');

Route::get('/approval/order-plan', ApprovalOrderPlan::class)->name('approval.order.plan.index');

Route::get('/approval/buyer-order', ApprovalBuyerOrder::class)->name('approval.buyer.order.index');

Route::get('/approval/approved', ApprovalApproved::class)->name('approval.approved.index');

Route::get('/approval/rejected', ApprovalRejected::class)->name('approval.rejected.index');

Route::get('/purchase/purchasing', PurchasePurchasing::class)->name('purchase.purchasing.index');

Route::get('/warehouse/received', WarehouseReceived::class)->name('warehouse.received.index');

Route::get('/warehouse/lists', WarehouseList::class)->name('warehouse.lists.index');

Route::get('/warehouse/request-list', WarehouseRequestList::class)->name('warehouse.request.list.index');

Route::get('/qcpass/material', QcPassMaterial::class)->name('qcpass.material.index');

Route::get('/qcpass/lists', QcPassList::class)->name('qcpass.lists.index');

Route::get('/production/request-material', ProductionRequestMaterial::class)->name('production.request.material.index');

Route::get('/production/request-list', ProductionRequestList::class)->name('production.request.list.index');
