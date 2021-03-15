<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Login;
use App\Http\Controllers\Dashboard;
use App\Http\Controllers\MasterAddtionalExpenses;
use App\Http\Controllers\MasterCompanySetting;
use App\Http\Controllers\MasterCustomerSupplier;
use App\Http\Controllers\MasterGroup;
use App\Http\Controllers\MasterItem;
use App\Http\Controllers\MasterSession;
use App\Http\Controllers\MasterUnit;
use App\Http\Controllers\commonController;
use App\Http\Controllers\CustomerSaleController;
use App\Http\Controllers\PaymentReceiveController;
use App\Http\Controllers\CustomerCarretReceiveController;
use App\Http\Controllers\SupplierCarretReturnController;
use App\Http\Controllers\PurchaseEntryController;
use App\Http\Controllers\PurchasePaymentEntryController;
use App\Http\Controllers\LoadingEntryController;
use App\Http\Controllers\CustomerLedgerBook;
use App\Http\Controllers\OtherIncomeAndExpensesController;
use App\Http\Controllers\IncomeAndExpensesController;
use App\Http\Controllers\PdfController;
use App\Http\Controllers\CustomerSupplierCarretLedger;
use App\Http\Controllers\MasterBijakPrintNameController;
use App\Http\Controllers\customUnitRateController;




//Clear Cache 
Route::get('/cache', function() {
    $exitCode = Artisan::call('cache:clear');
    return 'DONE';
});



Route::get('/login', [Login::class, 'Login'])->name('login');

Route::post('/login', [Login::class, 'submitLogin']);

Route::get('logout', [Login::class, 'logout']);

Route::get('get-company', [Login::class, 'getSelectOption2']);

Route::get('/', [Dashboard::class, 'index'])->middleware('auth');



// =========== Master Route ============


// ======== Company Master Route =======
Route::get('/master-company-setting', [MasterCompanySetting::class, 'index'])->middleware('auth');

Route::post('/master-company-setting-store', [MasterCompanySetting::class, 'store'])->middleware('auth');

Route::get('/master-company-setting-datatable', [MasterCompanySetting::class, 'show'])->middleware('auth');

Route::get('/master-company-setting-edit/{id}', [MasterCompanySetting::class, 'edit'])->middleware('auth');

Route::post('/master-company-setting-update/{id}', [MasterCompanySetting::class, 'update'])->middleware('auth');

// ====== Session Master Route ========

// Route::get('/master-session', MasterSession::class);



// ====== Unit Master Route ========

Route::get('/master-unit', [MasterUnit::class, 'index'])->middleware('auth');

Route::post('/master-unit-store', [MasterUnit::class, 'store'])->middleware('auth');

Route::get('/master-unit-datatable', [MasterUnit::class, 'show'])->middleware('auth');

Route::get('/master-unit-edit/{id}', [MasterUnit::class, 'edit'])->middleware('auth');

Route::post('/master-unit-update/{id}', [MasterUnit::class, 'update'])->middleware('auth');

Route::get('/master-unit-delete/{id}', [MasterUnit::class, 'destroy'])->middleware('auth');


// ======== Custom Unit Master ==========//

Route::get('changeUnitRatePartyWise', [customUnitRateController::class, 'changeUnitRatePartyWise'])->middleware('auth');

Route::post('postcustomUnitRate', [customUnitRateController::class, 'postcustomUnitRate'])->middleware('auth');

// ======== End Custom Unit Master ==========//



// ===== Item Master Route =======

Route::get('/master-item', [MasterItem::class, 'index'])->middleware('auth');

Route::post('/master-item-store', [MasterItem::class, 'store'])->middleware('auth');

Route::get('/master-item-datatable', [MasterItem::class, 'show'])->middleware('auth');

Route::get('/master-item-edit/{id}', [MasterItem::class, 'edit'])->middleware('auth');

Route::post('/master-item-update/{id}', [MasterItem::class, 'update'])->middleware('auth');

Route::get('/common-destroy', [commonController::class, 'destroy'])->middleware('auth');




// ===== Group Master Route =======

Route::get('/master-group', [MasterGroup::class, 'index'])->middleware('auth');

Route::post('/master-group-store', [MasterGroup::class, 'store'])->middleware('auth');

Route::get('/master-group-datatable', [MasterGroup::class, 'show'])->middleware('auth');

Route::get('/master-group-edit/{id}', [MasterGroup::class, 'edit'])->middleware('auth');

Route::post('/master-group-update/{id}', [MasterGroup::class, 'update'])->middleware('auth');



// ========== Additional Expenses Master ==========

Route::get('/master-addtional-expenses', [MasterAddtionalExpenses::class, 'index'])->middleware('auth');

Route::post('/master-addtional-expenses-store', [MasterAddtionalExpenses::class, 'store'])->middleware('auth');

Route::get('/master-addtional-expenses-datatable', [MasterAddtionalExpenses::class, 'show'])->middleware('auth');

Route::get('/master-addtional-expenses-edit/{id}', [MasterAddtionalExpenses::class, 'edit'])->middleware('auth');

Route::post('/master-addtional-expenses-update/{id}', [MasterAddtionalExpenses::class, 'update'])->middleware('auth');

// ========== Customer Supplier Master ==========

Route::get('/master-customer-supplier', [MasterCustomerSupplier::class, 'index'])->middleware('auth');

Route::post('/master-customer-supplier-store', [MasterCustomerSupplier::class, 'store'])->middleware('auth');

Route::get('/master-customer-supplier-datatable', [MasterCustomerSupplier::class, 'show'])->middleware('auth');

Route::get('/master-customer-supplier-edit/{id}', [MasterCustomerSupplier::class, 'edit'])->middleware('auth');

Route::post('/master-customer-supplier-update/{id}', [MasterCustomerSupplier::class, 'update'])->middleware('auth');



// =========== Bijak Print Name Master =======

Route::get('master-bijak-print-name', [MasterBijakPrintNameController::class, 'create'])->middleware('auth');

Route::post('master-bijak-print-name-store', [MasterBijakPrintNameController::class, 'store'])->middleware('auth');

Route::get('master-bijak-print-name-show', [MasterBijakPrintNameController::class, 'show'])->middleware('auth');

Route::get('master-bijak-print-name-edit/{id}', [MasterBijakPrintNameController::class, 'edit'])->middleware('auth');

Route::post('master-bijak-print-name-update/{id}', [MasterBijakPrintNameController::class, 'update'])->middleware('auth');




// ========== Customer Sale Entry ==========

Route::get('/customer-sale', [CustomerSaleController::class, 'index'])->middleware('auth');


Route::get('/common-get-select', [commonController::class, 'getSelectOption']);

Route::get('/common-get-select2', [commonController::class, 'getSelectOption2']);


Route::get('/GetItemLock', [CustomerSaleController::class, 'GetItemLock']);

Route::get('/ItemLockUpdate', [CustomerSaleController::class, 'ItemLockUpdate']);

Route::get('/submitAddItems', [CustomerSaleController::class, 'submitAddItems'])->middleware('auth');

Route::get('/showCustomerSaleTableData', [CustomerSaleController::class, 'showCustomerSaleTableData']);

Route::get('/customerSaleEdit', [CustomerSaleController::class, 'customerSaleEdit']);

Route::post('/submitCustomerSaleData', [CustomerSaleController::class, 'submitCustomerSaleData'])->middleware('auth');

Route::get('/customerSaleReport', [CustomerSaleController::class, 'customerSaleReport'])->middleware('auth');

Route::get('/customerSaleReportDetails', [CustomerSaleController::class, 'customerSaleReportDetails'])->middleware('auth');


// ============= Payment Receive ===============

Route::get('/payment-receive', [PaymentReceiveController::class, 'create'])->middleware('auth');

Route::get('/AddPayment', [PaymentReceiveController::class, 'AddPayment'])->middleware('auth');

Route::get('/showPaymentTableData', [PaymentReceiveController::class, 'showPaymentTableData']);

Route::get('/paymentEdit', [PaymentReceiveController::class, 'paymentEdit']);

Route::get('/paymentUpdate/{id}', [PaymentReceiveController::class, 'paymentUpdate'])->middleware('auth');

Route::get('/submitPayment', [PaymentReceiveController::class, 'submitPayment'])->middleware('auth');

Route::get('/report-payment-receive', [PaymentReceiveController::class, 'reportPaymentReceive'])->middleware('auth');

Route::get('/paymentReceiveReportDetails', [PaymentReceiveController::class, 'paymentReceiveReportDetails'])->middleware('auth');




// =========== Customer Carret Receive ==========

Route::get('/customer-carret-receive', [CustomerCarretReceiveController::class, 'create'])->middleware('auth');

Route::get('/AddReceiveCarret', [CustomerCarretReceiveController::class, 'AddReceiveCarret'])->middleware('auth');

Route::get('/showCustomerCarretReceive', [CustomerCarretReceiveController::class, 'showCustomerCarretReceive'])->middleware('auth');

Route::get('/ReceiveCarretEdit', [CustomerCarretReceiveController::class, 'ReceiveCarretEdit'])->middleware('auth');

Route::get('/report-customer-carret-receive', [CustomerCarretReceiveController::class, 'reportCustomerCarretReceive'])->middleware('auth');

Route::get('/submitCustomerCarretReceive', [CustomerCarretReceiveController::class, 'submitCustomerCarretReceive'])->middleware('auth');


// =========== Supplier Carret Return ==========

Route::get('/supplier-carret-returns', [SupplierCarretReturnController::class, 'create'])->middleware('auth');

Route::get('/AddCarretReturn', [SupplierCarretReturnController::class, 'AddCarretReturn'])->middleware('auth');

Route::get('/showSupplierCarretReturn', [SupplierCarretReturnController::class, 'showSupplierCarretReturn'])->middleware('auth');

Route::get('/CarretReturntEdit', [SupplierCarretReturnController::class, 'CarretReturntEdit'])->middleware('auth');

Route::get('/submitCarretReturn', [SupplierCarretReturnController::class, 'submitCarretReturn'])->middleware('auth');

Route::get('/report-supplier-carret-returns', [SupplierCarretReturnController::class, 'reportSupplierCarretReturns'])->middleware('auth');



// =============== Purchase Entry Route =================

Route::get('/purchase-entry', [PurchaseEntryController::class, 'create'])->middleware('auth');

Route::get('/AddPurchaseEntryDetails', [PurchaseEntryController::class, 'AddPurchaseEntryDetails'])->middleware('auth');

Route::get('/showPurchaseEntryDetails', [PurchaseEntryController::class, 'showPurchaseEntryDetails'])->middleware('auth');

Route::get('/purchaseDetailsEdit', [PurchaseEntryController::class, 'purchaseDetailsEdit'])->middleware('auth')->middleware('auth');

Route::get('/AddPurchaseEntryExpenses', [PurchaseEntryController::class, 'AddPurchaseEntryExpenses'])->middleware('auth');

Route::get('/getExpensesType', [PurchaseEntryController::class, 'getExpensesType']);

Route::get('/ShowPurchaseEntryExpenses', [PurchaseEntryController::class, 'ShowPurchaseEntryExpenses'])->middleware('auth');

Route::post('/submitPurchaseEntryForm', [PurchaseEntryController::class, 'submitPurchaseEntryForm'])->middleware('auth');

Route::get('/report-purchase-entry', [PurchaseEntryController::class, 'reportPurchaseEntry'])->middleware('auth');

Route::get('/EDITshowPurchaseEntry', [PurchaseEntryController::class, 'EDITshowPurchaseEntryDetails'])->middleware('auth');

Route::get('/purchase-entry-delete', [PurchaseEntryController::class, 'purchaseEntryDelete'])->middleware('auth');

Route::get('/purchase-payment-entries', [PurchasePaymentEntryController::class, 'purchasePaymentEntries'])->middleware('auth');

Route::get('/AddPurchasePayment', [PurchasePaymentEntryController::class, 'AddPurchasePayment'])->middleware('auth');

Route::get('/showPurchasePaymentTableData', [PurchasePaymentEntryController::class, 'showPaymentTableData'])->middleware('auth');

Route::get('/purchasePaymentEdit', [PurchasePaymentEntryController::class, 'purchasePaymentEdit'])->middleware('auth');

Route::get('/purchasePaymentUpdate/{id}', [PurchasePaymentEntryController::class, 'purchasePaymentUpdate'])->middleware('auth');

Route::get('/submitPurchasePayment', [PurchasePaymentEntryController::class, 'submitPayment'])->middleware('auth');

Route::get('/report-purchase-payment-entries', [PurchasePaymentEntryController::class, 'reportPurchasePaymentEntries'])->middleware('auth');

Route::get('/paymentPurchaseReceiveReportDetails', [PurchasePaymentEntryController::class, 'paymentReceiveReportDetails'])->middleware('auth');



// ============== Loading Entry Route ==============

Route::get('/loading_entries', [LoadingEntryController::class, 'create'])->middleware('auth');

Route::get('/AddLoadingEntryDetails', [LoadingEntryController::class, 'AddLoadingEntryDetails'])->middleware('auth');

Route::get('/showLoadingEntryDetails', [LoadingEntryController::class, 'showLoadingEntryDetails'])->middleware('auth');

Route::get('/loadingEntryDetailsEdit', [LoadingEntryController::class, 'loadingEntryDetailsEdit'])->middleware('auth');

Route::post('/submitLoadingEntryData', [LoadingEntryController::class, 'submitLoadingEntryData'])->middleware('auth');

Route::get('/loadingEntriesReport', [LoadingEntryController::class, 'loadingEntriesReport'])->middleware('auth');

Route::get('/loading-entry-delete', [LoadingEntryController::class, 'loadingEntryDelete'])->middleware('auth');

Route::get('/loadingEntryEdit', [LoadingEntryController::class, 'loadingEntryEdit'])->middleware('auth');

Route::get('/select-record', [commonController::class, 'select_record']);




// ================= PDF ROUTE ==============

Route::get('customer-sale-a4', [CustomerSaleController::class, 'customerSaleA4']);



// =========== Ledger Book ==========

Route::get('/get-party', [CustomerLedgerBook::class, 'getPartySelectOption']);

Route::get('/ledger-book', [CustomerLedgerBook::class, 'index']);

Route::get('/ledger-book-details', [CustomerLedgerBook::class, 'ledgerBookDetails']);

Route::get('/party-balance-report', [CustomerLedgerBook::class, 'partyBalanceReport']);

Route::get('/customer-supplier-carret-ledger', [CustomerSupplierCarretLedger::class, 'CustSuppCarretLedger']);

Route::get('/getPartyCarretBalanceByDateStatic', [CustomerSupplierCarretLedger::class, 'getPartyCarretBalanceByDateStatic']);

Route::get('/getPartyCarretBalanceByDate', [CustomerSupplierCarretLedger::class, 'getPartyCarretBalanceByDate']);

Route::get('nonStaticGetPartyBalance', [CustomerLedgerBook::class, 'nonStaticGetPartyBalance']);










//============ CFEATED BY KUNAL ===============


//=============OtherIncomeAndExpensesHead===================

Route::get('/other-income-expenses',[OtherIncomeAndExpensesController::class,'index']);
Route::post('/other-income-expenses-store',[OtherIncomeAndExpensesController::class,'store']);
Route::get('/other-income-expenses-edit/{id}',[OtherIncomeAndExpensesController::class,'edit']);
Route::post('/other-income-expenses-update/{id}',[OtherIncomeAndExpensesController::class,'update']);
Route::get('/other-income-expenses-delete/{id}',[OtherIncomeAndExpensesController::class,'destroy']);


Route::get('/incomeandexpenses',[IncomeAndExpensesController::class,'index']);
Route::post('/income-and-expenses-store',[IncomeAndExpensesController::class,'store']);
Route::get('/income-and-expenses-edit/{id}',[IncomeAndExpensesController::class,'edit']);
Route::post('/income-and-expenses-update/{id}',[IncomeAndExpensesController::class,'update']);
Route::get('/income-and-expenses-delete/{id}',[IncomeAndExpensesController::class,'destroy']);



Route::get('PDFCustomerSaleA4',[PdfController::class,'PDFCustomerSaleA4']);

Route::get('PDFCustomerSaleA5',[PdfController::class,'PDFCustomerSaleA5']);

Route::get('PDFCustomerSaleA6',[PdfController::class,'PDFCustomerSaleA6']);

Route::get('PDFCustomerSaleHiA4',[PdfController::class,'PDFCustomerSaleHiA4']);

Route::get('PDFCustomerSaleHiA5',[PdfController::class,'PDFCustomerSaleHiA5']);

Route::get('PDFCustomerSaleHiA6',[PdfController::class,'PDFCustomerSaleHiA6']);




//PDF Reprots By Tarachand Patel 
Route::get('PdfPaymentA6Hindi',[PdfController::class,'PdfPaymentA6Hindi'])->name('PdfPaymentA6Hindi');
Route::get('PdfPaymentA6',[PdfController::class,'PdfPaymentA6'])->name('PdfPaymentA6');

Route::get('PdfCarretReceiveA6',[PdfController::class,'PdfCarretReceiveA6'])->name('PdfCarretReceiveA6');
Route::get('PdfCarretReceiveHindiA6',[PdfController::class,'PdfCarretReceiveHindiA6'])->name('PdfCarretReceiveHindiA6');

Route::get('PDFpurchaseEnteryA4',[PdfController::class,'PDFpurchaseEnteryA4'])->name('PDFpurchaseEnteryA4');
Route::get('PDFpurchaseEnteryA5',[PdfController::class,'PDFpurchaseEnteryA5'])->name('PDFpurchaseEnteryA5');

Route::get('PDFpurchaseEnteryA4Hindi',[PdfController::class,'PDFpurchaseEnteryA4Hindi'])->name('PDFpurchaseEnteryA4Hindi');
Route::get('PDFpurchaseEnteryA5Hindi',[PdfController::class,'PDFpurchaseEnteryA5Hindi'])->name('PDFpurchaseEnteryA5Hindi');




Route::get('pdfLoadingEntryA6',[PdfController::class,'pdfLoadingEntryA6'])->name('pdfLoadingEntryA6');
Route::get('pdfLoadingEntryA6Hindi',[PdfController::class,'pdfLoadingEntryA6Hindi'])->name('pdfLoadingEntryA6Hindi');



Route::get('PDFpurchasePaymentA6',[PdfController::class,'PDFpurchasePaymentA6'])->name('PDFpurchasePaymentA6');
Route::get('PDFpurchasePaymentA6Hindi',[PdfController::class,'PDFpurchasePaymentA6Hindi'])->name('PDFpurchasePaymentA6Hindi');


Route::get('PDFsulliperCarretReturnA6',[PdfController::class,'PDFsulliperCarretReturnA6'])->name('PDFsulliperCarretReturnA6');

Route::get('PDFsulliperCarretReturnA6Hindi',[PdfController::class,'PDFsulliperCarretReturnA6Hindi'])->name('PDFsulliperCarretReturnA6Hindi');

























































































// Route::get('/user', \App\Http\Livewire\User::class);

// Route::get('/users', \App\Http\Livewire\UsersDatatables::class)->middleware('auth');

// Route::get('/users-create', \App\Http\Livewire\UsersCreate::class)->middleware('auth');

// Route::get('/getUsers', [\App\Http\Livewire\UsersDatatables::class, 'getUsers'])->name('users.data')->middleware('auth');