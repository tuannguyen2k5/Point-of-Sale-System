<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CustomerGroupController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\WareHouseController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\TransferController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\UnitController;
use App\Http\Controllers\Admin\TaxRateController;
use App\Http\Controllers\Admin\PurchaseController;
use App\Http\Controllers\Admin\SaleController;
use App\Http\Controllers\Admin\ReturnSaleController;
use App\Http\Controllers\Admin\DeliveryController;
use App\Http\Controllers\Admin\SalePaymentController;
use App\Http\Controllers\Admin\PurchasePaymentController;
use App\Http\Controllers\Admin\StoreController;
use App\Http\Controllers\Admin\SiteSettingController;
use App\Http\Controllers\Auth\UserController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\SupplierController;
use App\Http\Controllers\Admin\BillerController;
use App\Http\Controllers\Admin\QuotationController;
use App\Http\Controllers\Admin\GoogleCategoryController;
use App\Http\Controllers\Admin\FacebookCategoryController;

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
|
| Here is where you can register Admin routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "admin" middleware group. Enjoy building your Admin!
|
*/

Route::prefix('admin')->name('admin.')->middleware('auth')->group(function () {
    Route::get(
        'dashboard',
        [DashboardController::class, 'dashboard']
    )->name('dashboard');
    Route::prefix('warehouses')->name('warehouses.')->group(function () {
        Route::get('', [WarehouseController::class, 'index'])->name('index');
        Route::get('/edit/{id}', [WarehouseController::class, 'edit'])->name('edit');
        Route::put('/edit/{id}', [WarehouseController::class, 'update'])->name('edit.update');
        Route::get('/create', [WarehouseController::class, 'create'])->name('create');
        Route::post('/create', [WarehouseController::class, 'store'])->name('create.store');
        Route::delete('/delete', [WarehouseController::class, 'destroy'])->name('delete');
        Route::get('/view/{id}', [WarehouseController::class, 'view'])->name('view');
    });
    Route::prefix('customergroups')->name('customergroups.')->group(function () {
        Route::get('', [CustomerGroupController::class, 'index'])->name('index');
        Route::get('/edit/{id}', [CustomerGroupController::class, 'edit'])->name('edit');
        Route::put('/edit/{id}', [CustomerGroupController::class, 'update'])->name('edit.update');
        Route::get('/create', [CustomerGroupController::class, 'create'])->name('create');
        Route::post('/create', [CustomerGroupController::class, 'store'])->name('create.store');
        Route::delete('/delete', [CustomerGroupController::class, 'destroy'])->name('delete');
        Route::get('/view/{id}', [CustomerGroupController::class, 'view'])->name('view');
    });
    Route::prefix('transfers')->name('transfers.')->group(function () {
        Route::get('', [TransferController::class, 'index'])->name('index');
        Route::get('/edit/{id}', [TransferController::class, 'edit'])->name('edit');
        Route::put('/edit/{id}', [TransferController::class, 'update'])->name('edit.update');
        Route::get('/create', [TransferController::class, 'create'])->name('create');
        Route::post('/create', [TransferController::class, 'store'])->name('create.store');
        Route::delete('/delete', [TransferController::class, 'destroy'])->name('delete');
        Route::get('/view/{id}', [TransferController::class, 'view'])->name('view');
        Route::post('import', [TransferController::class, 'import'])->name('import');
    });
    Route::prefix('products')->name('products.')->group(function () {
        Route::get('', [ProductController::class, 'index'])->name('index');
        Route::get('/edit/{id}', [ProductController::class, 'edit'])->name('edit');
        Route::put('/edit/{id}', [ProductController::class, 'update'])->name('edit.update');
        Route::get('/create', [ProductController::class, 'create'])->name('create');
        Route::post('/create', [ProductController::class, 'store'])->name('create.store');
        Route::delete('/delete', [ProductController::class, 'destroy'])->name('delete');
        Route::get('/view/{id}', [ProductController::class, 'view'])->name('view');
    });
    Route::prefix('brands')->name('brands.')->group(function () {
        Route::get('', [BrandController::class, 'index'])->name('index');
        Route::get('/edit/{id}', [BrandController::class, 'edit'])->name('edit');
        Route::put('/edit/{id}', [BrandController::class, 'update'])->name('edit.update');
        Route::get('/create', [BrandController::class, 'create'])->name('create');
        Route::post('/create', [BrandController::class, 'store'])->name('create.store');
        Route::delete('/delete', [BrandController::class, 'destroy'])->name('delete');
        Route::get('/view/{id}', [BrandController::class, 'view'])->name('view');
    });
    Route::prefix('tax_rate')->name('tax_rate.')->group(function () {
        Route::get('', [TaxRateController::class, 'index'])->name('index');
        Route::get('/edit/{id}', [TaxRateController::class, 'edit'])->name('edit');
        Route::put('/edit/{id}', [TaxRateController::class, 'update'])->name('edit.update');
        Route::get('/create', [TaxRateController::class, 'create'])->name('create');
        Route::post('/create', [TaxRateController::class, 'store'])->name('create.store');
        Route::delete('/delete', [TaxRateController::class, 'destroy'])->name('delete');
        Route::get('/view/{id}', [TaxRateController::class, 'view'])->name('view');
    });
    Route::prefix('units')->name('units.')->group(function () {
        Route::get('', [UnitController::class, 'index'])->name('index');
        Route::get('/edit/{id}', [UnitController::class, 'edit'])->name('edit');
        Route::put('/edit/{id}', [UnitController::class, 'update'])->name('edit.update');
        Route::get('/create', [UnitController::class, 'create'])->name('create');
        Route::post('/create', [UnitController::class, 'store'])->name('create.store');
        Route::delete('/delete', [UnitController::class, 'destroy'])->name('delete');
        Route::get('/view/{id}', [UnitController::class, 'view'])->name('view');
    });
    Route::prefix('categories')->name('categories.')->group(function () {
        Route::get('', [CategoryController::class, 'index'])->name('index');
        Route::get('/edit/{id}', [CategoryController::class, 'edit'])->name('edit');
        Route::put('/edit/{id}', [CategoryController::class, 'update'])->name('edit.update');
        Route::get('/create', [CategoryController::class, 'create'])->name('create');
        Route::post('/create', [CategoryController::class, 'store'])->name('create.store');
        Route::delete('/delete', [CategoryController::class, 'destroy'])->name('delete');
        Route::get('/view/{id}', [CategoryController::class, 'view'])->name('view');
        Route::post('/google-export', [CategoryController::class, 'googleExport'])->name('google-export');
        Route::post('/facebook-export', [CategoryController::class, 'facebookExport'])->name('facebook-export');
    });
    Route::prefix('purchases')->name('purchases.')->group(function () {
        Route::get('', [PurchaseController::class, 'index'])->name('index');
        Route::get('/edit/{id}', [PurchaseController::class, 'edit'])->name('edit');
        Route::put('/edit/{id}', [PurchaseController::class, 'update'])->name('edit.update');
        Route::get('/create', [PurchaseController::class, 'create'])->name('create');
        Route::post('/create', [PurchaseController::class, 'store'])->name('create.store');
        Route::delete('/delete', [PurchaseController::class, 'destroy'])->name('delete');
        Route::get('/view/{id}', [PurchaseController::class, 'view'])->name('view');
        Route::post('import', [PurchaseController::class, 'import'])->name('import');
    });

    Route::prefix('sales')->name('sales.')->group(function () {
        Route::get('', [SaleController::class, 'index'])->name('index');
        Route::get('/edit/{id}', [SaleController::class, 'edit'])->name('edit');
        Route::put('/edit/{id}', [SaleController::class, 'update'])->name('edit.update');
        Route::get('/create', [SaleController::class, 'create'])->name('create');
        Route::post('/create', [SaleController::class, 'store'])->name('create.store');
        Route::delete('/delete', [SaleController::class, 'destroy'])->name('delete');
        Route::get('/view/{id}', [SaleController::class, 'view'])->name('view');
    });

    Route::prefix('return-sales')->name('return-sales.')->group(function () {
        Route::get('', [ReturnSaleController::class, 'index'])->name('index');
        Route::get('/edit/{id}', [ReturnSaleController::class, 'edit'])->name('edit');
        Route::put('/edit/{id}', [ReturnSaleController::class, 'update'])->name('edit.update');
        Route::get('/create', [ReturnSaleController::class, 'create'])->name('create');
        Route::post('/create', [ReturnSaleController::class, 'store'])->name('create.store');
        Route::delete('/delete', [ReturnSaleController::class, 'destroy'])->name('delete');
        Route::get('/view/{id}', [ReturnSaleController::class, 'view'])->name('view');
    });

    Route::prefix('deliveries')->name('deliveries.')->group(function () {
        Route::get('', [DeliveryController::class, 'index'])->name('index');
        Route::get('/edit/{id}', [DeliveryController::class, 'edit'])->name('edit');
        Route::put('/edit/{id}', [DeliveryController::class, 'update'])->name('edit.update');
        Route::post('/create', [DeliveryController::class, 'store'])->name('create.store');
        Route::delete('/delete', [DeliveryController::class, 'destroy'])->name('delete');
        Route::get('/view/{id}', [DeliveryController::class, 'view'])->name('view');
    });

    Route::prefix('sale-payments')->name('sale-payments.')->group(function () {
        Route::get('', [SalePaymentController::class, 'index'])->name('index');
        Route::get('/edit/{id}', [SalePaymentController::class, 'edit'])->name('edit');
        Route::put('/edit/{id}', [SalePaymentController::class, 'update'])->name('edit.update');
        Route::post('/create', [SalePaymentController::class, 'store'])->name('create.store');
        Route::delete('/delete', [SalePaymentController::class, 'destroy'])->name('delete');
        Route::get('/view/{id}', [SalePaymentController::class, 'view'])->name('view');
    });

    Route::prefix('purchase-payments')->name('purchase-payments.')->group(function () {
        Route::get('', [PurchasePaymentController::class, 'index'])->name('index');
        Route::get('/edit/{id}', [PurchasePaymentController::class, 'edit'])->name('edit');
        Route::put('/edit/{id}', [PurchasePaymentController::class, 'update'])->name('edit.update');
        Route::post('/create', [PurchasePaymentController::class, 'store'])->name('create.store');
        Route::delete('/delete', [PurchasePaymentController::class, 'destroy'])->name('delete');
        Route::get('/view/{id}', [PurchasePaymentController::class, 'view'])->name('view');
    });
       
    Route::prefix('quotations')->name('quotations.')->group(function () {
        Route::get('', [QuotationController::class, 'index'])->name('index');
        Route::get('/edit/{id}', [QuotationController::class, 'edit'])->name('edit');
        Route::put('/edit/{id}', [QuotationController::class, 'update'])->name('edit.update');
        Route::get('/create', [QuotationController::class, 'create'])->name('create');
        Route::post('/create', [QuotationController::class, 'store'])->name('create.store');
        Route::delete('/delete', [QuotationController::class, 'destroy'])->name('delete');
        Route::get('/view/{id}', [QuotationController::class, 'view'])->name('view');
    });

    Route::prefix('site-settings')->name('site-settings.')->group(function () {
        Route::get('/edit', [SiteSettingController::class, 'edit'])->name('edit');
        Route::put('/edit', [SiteSettingController::class, 'update'])->name('edit.update');
    });

    Route::prefix('stores')->name('stores.')->group(function () {
        Route::get('', [StoreController::class, 'index'])->name('index');
        Route::get('/edit/{id}', [StoreController::class, 'edit'])->name('edit');
        Route::put('/edit/{id}', [StoreController::class, 'update'])->name('edit.update');
        Route::get('/create', [StoreController::class, 'create'])->name('create');
        Route::post('/create', [StoreController::class, 'store'])->name('create.store');
        Route::delete('/delete', [StoreController::class, 'destroy'])->name('delete');
        Route::get('/view/{id}', [StoreController::class, 'view'])->name('view');
    });

    Route::prefix('customers')->name('customers.')->group(function () {
        Route::get('', [CustomerController::class, 'index'])->name('index');
        Route::get('/edit/{id}', [CustomerController::class, 'edit'])->name('edit');
        Route::put('/edit/{id}', [CustomerController::class, 'update'])->name('edit.update');
        Route::get('/create', [CustomerController::class, 'create'])->name('create');
        Route::post('/create', [CustomerController::class, 'store'])->name('create.store');
        Route::delete('/delete', [CustomerController::class, 'destroy'])->name('delete');
        Route::get('/view/{id}', [CustomerController::class, 'view'])->name('view');
        Route::post('import', [CustomerController::class, 'import'])->name('import');
    });

    Route::prefix('suppliers')->name('suppliers.')->group(function () {
        Route::get('', [SupplierController::class, 'index'])->name('index');
        Route::get('/edit/{id}', [SupplierController::class, 'edit'])->name('edit');
        Route::put('/edit/{id}', [SupplierController::class, 'update'])->name('edit.update');
        Route::get('/create', [SupplierController::class, 'create'])->name('create');
        Route::post('/create', [SupplierController::class, 'store'])->name('create.store');
        Route::delete('/delete', [SupplierController::class, 'destroy'])->name('delete');
        Route::get('/view/{id}', [SupplierController::class, 'view'])->name('view');
        Route::post('import', [SupplierController::class, 'import'])->name('import');
    });

    Route::prefix('billers')->name('billers.')->group(function () {
        Route::get('', [BillerController::class, 'index'])->name('index');
        Route::get('/edit/{id}', [BillerController::class, 'edit'])->name('edit');
        Route::put('/edit/{id}', [BillerController::class, 'update'])->name('edit.update');
        Route::get('/create', [BillerController::class, 'create'])->name('create');
        Route::post('/create', [BillerController::class, 'store'])->name('create.store');
        Route::delete('/delete', [BillerController::class, 'destroy'])->name('delete');
        Route::get('/view/{id}', [BillerController::class, 'view'])->name('view');
        Route::post('import', [BillerController::class, 'import'])->name('import');
    });

    Route::prefix('users')->name('users.')->group(function () {
        Route::get('', [UserController::class, 'index'])->name('index');
        Route::get('/edit', [UserController::class, 'show'])->name('edit');
        Route::post('/edit', [UserController::class, 'store'])->name('edit.store');
        Route::delete('/delete', [UserController::class, 'destroy'])->name('delete');
        Route::get('/profile',[ProfileController::class,'index'])->name('profile');
        Route::get('/profile/edit',[ProfileController::class,'edit'])->name('profile.edit');
        Route::put('/profile/{id}/update',[ProfileController::class,'store'])->name('profile.update');
    });   

    Route::prefix('google-categories')->name('google-categories.')->group(function () {
        Route::get('', [GoogleCategoryController::class, 'index'])->name('index');
        Route::get('/edit/{id}', [GoogleCategoryController::class, 'edit'])->name('edit');
        Route::put('/edit/{id}', [GoogleCategoryController::class, 'update'])->name('edit.update');
        Route::get('/create', [GoogleCategoryController::class, 'create'])->name('create');
        Route::post('/create', [GoogleCategoryController::class, 'store'])->name('create.store');
        Route::delete('/delete', [GoogleCategoryController::class, 'destroy'])->name('delete');
        Route::get('/view/{id}', [GoogleCategoryController::class, 'view'])->name('view');
        Route::post('import', [GoogleCategoryController::class, 'import'])->name('import');
    });

    Route::prefix('facebook-categories')->name('facebook-categories.')->group(function () {
        Route::get('', [FacebookCategoryController::class, 'index'])->name('index');
        Route::get('/edit/{id}', [FacebookCategoryController::class, 'edit'])->name('edit');
        Route::put('/edit/{id}', [FacebookCategoryController::class, 'update'])->name('edit.update');
        Route::get('/create', [FacebookCategoryController::class, 'create'])->name('create');
        Route::post('/create', [FacebookCategoryController::class, 'store'])->name('create.store');
        Route::delete('/delete', [FacebookCategoryController::class, 'destroy'])->name('delete');
        Route::get('/view/{id}', [FacebookCategoryController::class, 'view'])->name('view');
        Route::post('import', [FacebookCategoryController::class, 'import'])->name('import');
    });
});
