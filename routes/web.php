<?php

use App\Http\Controllers\AccessController;
use App\Http\Controllers\Admin\Customer\CustomerController;
use App\Http\Controllers\Admin\Package\PackageController;
use App\Http\Controllers\Admin\Package\Package2Controller;
use App\Http\Controllers\Admin\User\UserController;
use App\Http\Controllers\Admin\Account\AccountController;
use App\Http\Controllers\Admin\Account\BillTransferController;
use App\Http\Controllers\Admin\Account\CashBookController;
use App\Http\Controllers\Admin\Account\DailyIncomeReportController;
use App\Http\Controllers\Admin\Account\ExpenseReportController;
use App\Http\Controllers\Admin\Account\SupplierLedgerController;
use App\Http\Controllers\Admin\Asset\AssetCategoryController;
use App\Http\Controllers\Admin\Asset\AssetContoller;
use App\Http\Controllers\Admin\Asset\ReasonController;
use App\Http\Controllers\Admin\BandwidthBuy\ItemCategoryController;
use App\Http\Controllers\Admin\BandwidthBuy\ItemController;
use App\Http\Controllers\Admin\BandwidthBuy\ProviderController;
use App\Http\Controllers\Admin\BandwidthSale\BandwidthSaleInvoiceController;
use App\Http\Controllers\Admin\BandwidthSale\BandwidthCustomerController;
use App\Http\Controllers\Admin\Billing\AdvanceBillingController;
use App\Http\Controllers\Admin\Billing\BillingController;
use App\Http\Controllers\Admin\Billing\CollectedBillingController;
use App\Http\Controllers\Admin\BillingStatus\BillingStatusController;
use App\Http\Controllers\Admin\Box\BoxController;
use App\Http\Controllers\Admin\ClientType\ClientTypeController;
use App\Http\Controllers\Admin\ConnectionType\ConnectionTypeController;
use App\Http\Controllers\Admin\Customer\NewConnectionController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\Destroyitem\DestroyItemController;
use App\Http\Controllers\Admin\PayRoll\DepartmentController;
use App\Http\Controllers\Admin\Device\DeviceController;
use App\Http\Controllers\Admin\Tj\TjController;
use App\Http\Controllers\Admin\Expense\ExpenseController;
use App\Http\Controllers\Admin\Discount\DiscountController;
use App\Http\Controllers\Admin\Employee\EmployeeController;
use App\Http\Controllers\Admin\Employee\EmployeeExpenseController;
use App\Http\Controllers\Admin\Employee\SalaryController;
use App\Http\Controllers\Admin\Expense\ExpenseCategoryController;
use App\Http\Controllers\Admin\Sms\SmsController;
use App\Http\Controllers\Admin\Group\GroupController;
use App\Http\Controllers\Admin\Income\DailyIncomeController;
use App\Http\Controllers\Admin\Income\IncomeCategoryController;
use App\Http\Controllers\Admin\Income\IncomeHistoryController;
use App\Http\Controllers\Admin\InstallationFee\InstallationFeeController;
use App\Http\Controllers\Admin\Inventory\BrandController;
use App\Http\Controllers\Admin\Inventory\ProductCategoryController;
use App\Http\Controllers\Admin\Inventory\ProductController;
use App\Http\Controllers\Admin\Inventory\UnitController;
use App\Http\Controllers\Admin\MacReseller\MacResellerController;
use App\Http\Controllers\Admin\MacReseller\MacPackageController;
use App\Http\Controllers\Admin\MacReseller\MacTariffConfigController;
use App\Http\Controllers\Admin\MikrotikServer\MikrotikServerController;
use App\Http\Controllers\Admin\MPPPProfile\MPPPProfileController;
use App\Http\Controllers\Admin\PaymentMethod\PaymentMethodController;
use App\Http\Controllers\Admin\PayRoll\DesignationController;
use App\Http\Controllers\Admin\Ppp\ActiveConnectionController;
use App\Http\Controllers\Admin\Ppp\MInterfaceController;
use App\Http\Controllers\Admin\Ppp\MPoolController;
use App\Http\Controllers\Admin\Protocol\ProtocolController;
use App\Http\Controllers\Admin\Report\BtrcReportController;
use App\Http\Controllers\Admin\Splitter\SplitterController;
use App\Http\Controllers\Admin\Purchase\PurchaseController;
use App\Http\Controllers\Admin\Report\BillCollectionReportController;
use App\Http\Controllers\Admin\Report\CustomerReportController;
use App\Http\Controllers\Admin\Report\DiscountReportController;
use App\Http\Controllers\Admin\RollPermissionController;
use App\Http\Controllers\Admin\Setup\CompanyController;
use App\Http\Controllers\Admin\StockOut\StockOutController;
use App\Http\Controllers\Admin\Subzone\SubzoneController;
use App\Http\Controllers\Admin\Supplier\SupplierController;
use App\Http\Controllers\Admin\SupportTicketing\SupportCategoryController;
use App\Http\Controllers\Admin\SupportTicketing\SupportTicketController;
use App\Http\Controllers\Admin\UserPackage\UserPackageController;
use App\Http\Controllers\Admin\Zone\ZoneController;
use App\Http\Controllers\Billing\BillingDetailsController;
use App\Http\Controllers\PackageUpdateDownRate\PackageUpdateDownRateController;
use App\Http\Controllers\BalanceTransferController;
use App\Http\Controllers\DistrictController;
use App\Http\Controllers\ImportController;
use App\Http\Controllers\OpeningBalanceController;
use App\Http\Controllers\StaticIp\IpAddressController;
use App\Http\Controllers\StaticIp\VlanController;
use App\Http\Controllers\SupportHistoryController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\Ticketing\TicketingController;
use App\Http\Controllers\UpozillaController;
use Illuminate\Support\Facades\Route;



Route::get('/', function () {
    return view('auth.login');
});

Route::any('/test', [TestController::class, 'index']);
Route::get('/logout', [AccessController::class, 'logout']);
Route::prefix('admin')->namespace('Admin')->middleware(['auth'])->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    /*********************
     * GROUP
     *********************/
    Route::name('groups.')->prefix('groups')->group(function () {
        Route::get('/', [GroupController::class, 'index'])->name('index');

        Route::get('/dataProcessing', [GroupController::class, 'dataProcessing'])->name('dataProcessing');

        Route::get('/create', [GroupController::class, 'create'])->name('create');
        Route::post('/create', [GroupController::class, 'store'])->name('store');

        Route::get('/{group:id}', [GroupController::class, 'edit'])->name('edit');
        Route::put('/{group:id}', [GroupController::class, 'update'])->name('update');

        Route::get('/{group:id}/access', [GroupController::class, 'access'])->name('access');
        Route::put('/{group:id}/access', [GroupController::class, 'accessStore']);

        Route::get('/{group:id}/view', [GroupController::class, 'view'])->name('view');
        Route::get('/{group:id}/delete', [GroupController::class, 'destroy'])->name('destroy');
    });
    /*********************
     * End GROUP
     *********************/

    //User operation start
    Route::name('users.')->prefix('users')->group(function () {
        Route::get('/list', [UserController::class, 'index'])->name('index');
        Route::get('/dataProcessing', [UserController::class, 'dataProcessing'])->name('dataProcessing');
        Route::get('/create', [UserController::class, 'create'])->name('create');
        Route::post('/store', [UserController::class, 'store'])->name('store');
        Route::get('/edit/{user:id}', [UserController::class, 'edit'])->name('edit');
        Route::get('/show/{user:id}', [UserController::class, 'show'])->name('show');
        Route::post('/update/{user:id}', [UserController::class, 'update'])->name('update');
        Route::get('/delete/{user:id}', [UserController::class, 'destroy'])->name('destroy');
        Route::get('/status/{user:id}/{status}', [UserController::class, 'statusUpdate'])->name('status');
    });
    //User operation end

    //customers operation start
    Route::name('customers.')->prefix('customers')->group(function () {
        Route::get('/list', [CustomerController::class, 'index'])->name('index');
        Route::get('/dataProcessing', [CustomerController::class, 'dataProcessing'])->name('dataProcessing');
        Route::get('/create', [CustomerController::class, 'create'])->name('create');
        Route::post('/store', [CustomerController::class, 'store'])->name('store');
        Route::get('/edit/{customer:id}', [CustomerController::class, 'edit'])->name('edit');
        Route::get('/show/{customer:id}', [CustomerController::class, 'show'])->name('show');
        Route::post('/update/{customer:id}', [CustomerController::class, 'update'])->name('update');
        Route::get('/delete/{customer:id}', [CustomerController::class, 'destroy'])->name('destroy');
        Route::get('/status/{customer:id}/{status}', [CustomerController::class, 'statusUpdate'])->name('status');
        Route::get('/profile-details', [CustomerController::class, 'getProfile'])->name('get_profile');
        Route::get('/m-disabled/{customer:id}', [CustomerController::class, 'mikrotikStatus'])->name('disabled');
    });
    //customers operation end

    //New Connection operation start
    Route::name('newconnection.')->prefix('newconnection')->group(function () {
        Route::get('/list', [NewConnectionController::class, 'index'])->name('index');
        Route::get('/dataProcessing', [NewConnectionController::class, 'dataProcessing'])->name('dataProcessing');
        Route::get('/create', [NewConnectionController::class, 'create'])->name('create');
        Route::post('/store', [NewConnectionController::class, 'store'])->name('store');
        Route::get('/edit/{newconnection:id}', [NewConnectionController::class, 'edit'])->name('edit');
        Route::get('/show/{newconnection:id}', [NewConnectionController::class, 'show'])->name('show');
        Route::post('/update/{newconnection:id}', [NewConnectionController::class, 'update'])->name('update');
        Route::get('/delete/{newconnection:id}', [NewConnectionController::class, 'destroy'])->name('destroy');
        Route::get('/approved/{newconnection:id}', [NewConnectionController::class, 'approve'])->name('approved');
        Route::get('/monthlybill', [NewConnectionController::class, 'monthlybill'])->name('monthlybill');
        Route::get('/status/{newconnection:id}/{status}', [NewConnectionController::class, 'statusUpdate'])->name('status');
        Route::get('/profile-details', [NewConnectionController::class, 'getProfile'])->name('get_profile');
        Route::get('/m-disabled/{customer:id}', [NewConnectionController::class, 'mikrotikStatus'])->name('disabled');
    });
    //customers operation end

    //package operation start
    Route::name('packages.')->prefix('packages')->group(function () {
        Route::get('/list', [PackageController::class, 'index'])->name('index');
        Route::get('/dataProcessing', [PackageController::class, 'dataProcessing'])->name('dataProcessing');
        Route::get('/create', [PackageController::class, 'create'])->name('create');
        Route::post('/store', [PackageController::class, 'store'])->name('store');
        Route::get('/edit/{package:id}', [PackageController::class, 'edit'])->name('edit');
        Route::get('/show/{package:id}', [PackageController::class, 'show'])->name('show');
        Route::post('/update/{package:id}', [PackageController::class, 'update'])->name('update');
        Route::get('/delete/{package:id}', [PackageController::class, 'destroy'])->name('destroy');
        Route::get('/status/{package:id}/{status}', [PackageController::class, 'statusUpdate'])->name('status');
    });
    //package operation end

    //acounts operation start
    Route::name('accounts.')->prefix('accounts')->group(function () {
        Route::get('/list', [AccountController::class, 'index'])->name('index');
        Route::get('/dataProcessing', [AccountController::class, 'dataProcessing'])->name('dataProcessing');
        Route::get('/dataProcessingsubAccount/{account:id}', [AccountController::class, 'dataProcessingsubAccount'])->name('dataProcessingsubAccount');
        Route::get('/create', [AccountController::class, 'create'])->name('create');
        Route::post('/store/{id?}', [AccountController::class, 'store'])->name('store');
        Route::get('/subaccount/{account:id}', [AccountController::class, 'subaccount'])->name('subaccount');
        Route::get('/edit/{account:id}', [AccountController::class, 'edit'])->name('edit');
        Route::get('/view', [AccountController::class, 'view'])->name('view');
        Route::post('/update/{account:id}', [AccountController::class, 'update'])->name('update');
        Route::get('/delete/{account:id}', [AccountController::class, 'destroy'])->name('destroy');
        Route::get('/status/{account:id}', [AccountController::class, 'statusUpdate'])->name('status');
    });
    //acounts operation end

    //billtransfer operation start
    Route::name('billtransfer.')->prefix('billtransfer')->group(function () {
        Route::get('/list', [BillTransferController::class, 'index'])->name('index');
        Route::get('/dataProcessing', [BillTransferController::class, 'dataProcessing'])->name('dataProcessing');
        Route::get('/create', [BillTransferController::class, 'create'])->name('create');
        Route::post('/store', [BillTransferController::class, 'store'])->name('store');
        Route::get('/show/{transaction:id}', [BillTransferController::class, 'show'])->name('show');
        Route::get('/edit/{transaction:id}', [BillTransferController::class, 'edit'])->name('edit');
        Route::post('/update/{transaction:id}', [BillTransferController::class, 'update'])->name('update');
        Route::get('/delete/{transaction:id}', [BillTransferController::class, 'destroy'])->name('destroy');
        Route::get('/status/{transaction:id}/{status}', [BillTransferController::class, 'statusUpdate'])->name('status');
    });
    //billtransfer operation end

    //cash book operation start
    Route::name('cashbook.')->prefix('cashbook')->group(function () {
        Route::get('/list', [CashBookController::class, 'index'])->name('index');
        Route::get('/dataProcessing', [CashBookController::class, 'dataProcessing'])->name('dataProcessing');
        Route::get('/create', [CashBookController::class, 'create'])->name('create');
        Route::post('/store', [CashBookController::class, 'store'])->name('store');
        Route::get('/show/{account:id}', [CashBookController::class, 'show'])->name('show');
        Route::get('/edit/{account:id}', [CashBookController::class, 'edit'])->name('edit');
        Route::post('/update/{account:id}', [CashBookController::class, 'update'])->name('update');
        Route::get('/delete/{account:id}', [CashBookController::class, 'destroy'])->name('destroy');
        Route::get('/status/{account:id}/{status}', [CashBookController::class, 'statusUpdate'])->name('status');
    });
    //cash book operation end
    //cash book operation start
    Route::name('supplier_ledger.')->prefix('supplier_ledger')->group(function () {
        Route::get('/list', [SupplierLedgerController::class, 'index'])->name('index');
        Route::get('/dataProcessing', [SupplierLedgerController::class, 'dataProcessing'])->name('dataProcessing');
        Route::get('/pay/{supplierledger:id}', [SupplierLedgerController::class, 'pay'])->name('pay');
        Route::post('/update/{supplier:id}', [SupplierLedgerController::class, 'update'])->name('update');
    });
    //cash book operation end

    //acounts operation start
    Route::name('expense_category.')->prefix('expense_category')->group(function () {
        Route::get('/list', [ExpenseCategoryController::class, 'index'])->name('index');
        Route::get('/dataProcessing', [ExpenseCategoryController::class, 'dataProcessing'])->name('dataProcessing');
        Route::get('/create', [ExpenseCategoryController::class, 'create'])->name('create');
        Route::post('/store', [ExpenseCategoryController::class, 'store'])->name('store');
        Route::get('/show/{expense:id}', [ExpenseCategoryController::class, 'show'])->name('show');
        Route::get('/edit/{expense:id}', [ExpenseCategoryController::class, 'edit'])->name('edit');
        Route::post('/update/{expense:id}', [ExpenseCategoryController::class, 'update'])->name('update');
        Route::get('/delete/{expensecategory:id}', [ExpenseCategoryController::class, 'destroy'])->name('destroy');
        Route::get('/status/{expense:id}/{status}', [ExpenseCategoryController::class, 'statusUpdate'])->name('status');
    });
    //acounts operation end

    //acounts operation start
    Route::name('expenses.')->prefix('expenses')->group(function () {
        Route::get('/list', [ExpenseController::class, 'index'])->name('index');
        Route::get('/dataProcessing', [ExpenseController::class, 'dataProcessing'])->name('dataProcessing');
        Route::get('/create', [ExpenseController::class, 'create'])->name('create');
        Route::post('/store', [ExpenseController::class, 'store'])->name('store');
        Route::get('/show/{expense:id}', [ExpenseController::class, 'show'])->name('show');
        Route::get('/edit/{expense:id}', [ExpenseController::class, 'edit'])->name('edit');
        Route::post('/update/{expense:id}', [ExpenseController::class, 'update'])->name('update');
        Route::get('/delete/{expense:id}', [ExpenseController::class, 'destroy'])->name('destroy');
        Route::get('/status/{expense:id}/{status}', [ExpenseController::class, 'statusUpdate'])->name('status');
    });
    //acounts operation end
    //acounts operation start
    Route::name('expensereports.')->prefix('expensereports')->group(function () {
        Route::get('/list', [ExpenseReportController::class, 'index'])->name('index');
        Route::get('/dataProcessing', [ExpenseReportController::class, 'dataProcessing'])->name('dataProcessing');
        Route::get('/create', [ExpenseReportController::class, 'create'])->name('create');
        Route::post('/store', [ExpenseReportController::class, 'store'])->name('store');
        Route::get('/show/{expense:id}', [ExpenseReportController::class, 'show'])->name('show');
        Route::get('/edit/{expense:id}', [ExpenseReportController::class, 'edit'])->name('edit');
        Route::post('/update/{expense:id}', [ExpenseReportController::class, 'update'])->name('update');
        Route::get('/delete/{expense:id}', [ExpenseReportController::class, 'destroy'])->name('destroy');
        Route::get('/status/{expense:id}/{status}', [ExpenseReportController::class, 'statusUpdate'])->name('status');
    });
    //acounts operation end

    //income operation start
    Route::name('incomeCategory.')->prefix('incomeCategory')->group(function () {
        Route::get('/list', [IncomeCategoryController::class, 'index'])->name('index');
        Route::get('/dataProcessing', [IncomeCategoryController::class, 'dataProcessing'])->name('dataProcessing');
        Route::get('/create', [IncomeCategoryController::class, 'create'])->name('create');
        Route::post('/store', [IncomeCategoryController::class, 'store'])->name('store');
        Route::get('/show/{Incomecategory:id}', [IncomeCategoryController::class, 'show'])->name('show');
        Route::get('/edit/{Incomecategory:id}', [IncomeCategoryController::class, 'edit'])->name('edit');
        Route::post('/update/{Incomecategory:id}', [IncomeCategoryController::class, 'update'])->name('update');
        Route::get('/delete/{Incomecategory:id}', [IncomeCategoryController::class, 'destroy'])->name('destroy');
        Route::get('/status/{Incomecategory:id}/{status}', [IncomeCategoryController::class, 'statusUpdate'])->name('status');
    });
    Route::name('dailyIncome.')->prefix('dailyIncome')->group(function () {
        Route::get('/list', [DailyIncomeController::class, 'index'])->name('index');
        Route::get('/dataProcessing', [DailyIncomeController::class, 'dataProcessing'])->name('dataProcessing');
        Route::get('/create', [DailyIncomeController::class, 'create'])->name('create');
        Route::post('/store', [DailyIncomeController::class, 'store'])->name('store');
        Route::get('/show/{expense:id}', [DailyIncomeController::class, 'show'])->name('show');
        Route::get('/edit/{dailyincome:id}', [DailyIncomeController::class, 'edit'])->name('edit');
        Route::post('/update/{dailyincome:id}', [DailyIncomeController::class, 'update'])->name('update');
        Route::get('/delete/{id}', [DailyIncomeController::class, 'destroy'])->name('destroy');
        Route::post('/search/data', [DailyIncomeController::class, 'search'])->name('search');

        Route::get('/status/{expense:id}/{status}', [DailyIncomeController::class, 'statusUpdate'])->name('status');
    });
    Route::name('incomeHistory.')->prefix('incomeHistory')->group(function () {
        Route::get('/list', [IncomeHistoryController::class, 'index'])->name('index');
        Route::get('/dataProcessing', [IncomeHistoryController::class, 'dataProcessing'])->name('dataProcessing');
    });
    Route::name('installationFee.')->prefix('installationFee')->group(function () {
        Route::get('/list', [InstallationFeeController::class, 'index'])->name('index');
        Route::get('/dataProcessing', [InstallationFeeController::class, 'dataProcessing'])->name('dataProcessing');
        Route::get('/create', [InstallationFeeController::class, 'create'])->name('create');
        Route::post('/store', [InstallationFeeController::class, 'store'])->name('store');
        Route::get('/show/{installationFee:id}', [InstallationFeeController::class, 'show'])->name('show');
        Route::get('/edit/{installationFee:id}', [InstallationFeeController::class, 'edit'])->name('edit');
        Route::get('/pay/{installationFee:id}', [InstallationFeeController::class, 'pay'])->name('pay');
        Route::post('/update/{installationFee:id}', [InstallationFeeController::class, 'update'])->name('update');
        Route::get('/delete/{installationFee:id}', [InstallationFeeController::class, 'destroy'])->name('destroy');
        Route::get('/status/{installationFee:id}/{status}', [InstallationFeeController::class, 'statusUpdate'])->name('status');
    });
    //income operation end

    //Discount operation start
    Route::name('discounts.')->prefix('discounts')->group(function () {
        Route::get('/list', [DiscountController::class, 'index'])->name('index');
        Route::get('/dataProcessing', [DiscountController::class, 'dataProcessing'])->name('dataProcessing');
        Route::get('/create', [DiscountController::class, 'create'])->name('create');
        Route::post('/store', [DiscountController::class, 'store'])->name('store');
        Route::get('/show/{discount:id}', [DiscountController::class, 'show'])->name('show');
        Route::get('/edit/{discount:id}', [DiscountController::class, 'edit'])->name('edit');
        Route::post('/update/{discount:id}', [DiscountController::class, 'update'])->name('update');
        Route::get('/delete/{discount:id}', [DiscountController::class, 'destroy'])->name('destroy');
        Route::get('/status/{discount:id}/{status}', [DiscountController::class, 'statusUpdate'])->name('status');
    });
    //discount operation end

    //Employe status start
    Route::name('employees.')->prefix('employees')->group(function () {
        Route::get('/list', [EmployeeController::class, 'index'])->name('index');
        Route::get('/dataProcessing', [EmployeeController::class, 'dataProcessing'])->name('dataProcessing');
        Route::get('/create', [EmployeeController::class, 'create'])->name('create');
        Route::post('/store', [EmployeeController::class, 'store'])->name('store');
        Route::get('/show/{employee:id}', [EmployeeController::class, 'show'])->name('show');
        Route::get('/edit/{employee:id}', [EmployeeController::class, 'edit'])->name('edit');
        Route::post('/update/{employee:id}', [EmployeeController::class, 'update'])->name('update');
        Route::get('/delete/{employee:id}', [EmployeeController::class, 'destroy'])->name('destroy');
    });
    //Employe status end

    //Ticketing start
    Route::name('ticketing.')->prefix('ticketing')->group(function () {
        Route::get('/list', [TicketingController::class, 'index'])->name('index');
        Route::get('/dataProcessing', [TicketingController::class, 'dataProcessing'])->name('dataProcessing');
        Route::get('/create', [TicketingController::class, 'create'])->name('create');
        Route::post('/store', [TicketingController::class, 'store'])->name('store');
        Route::get('/show/{ticketing:id}', [TicketingController::class, 'show'])->name('show');
        Route::get('/edit/{ticketing:id}', [TicketingController::class, 'edit'])->name('edit');
        Route::post('/update/{ticketing:id}', [TicketingController::class, 'update'])->name('update');
        Route::get('/delete/{ticketing:id}', [TicketingController::class, 'destroy'])->name('destroy');
    });
    //Ticketing end

    //Ticketing start
    Route::name('supporthistory.')->prefix('supporthistory')->group(function () {
        Route::get('/list', [SupportHistoryController::class, 'index'])->name('index');
        Route::get('/dataProcessing', [SupportHistoryController::class, 'dataProcessing'])->name('dataProcessing');
        Route::get('/create', [SupportHistoryController::class, 'create'])->name('create');
        Route::post('/store', [SupportHistoryController::class, 'store'])->name('store');
        Route::get('/show/{supporthistory:id}', [SupportHistoryController::class, 'show'])->name('show');
        Route::get('/edit/{supporthistory:id}', [SupportHistoryController::class, 'edit'])->name('edit');
        Route::post('/update/{supporthistory:id}', [SupportHistoryController::class, 'update'])->name('update');
        Route::get('/delete/{supporthistory:id}', [SupportHistoryController::class, 'destroy'])->name('destroy');
    });
    //Ticketing end

    //Employe Expense status start
    Route::name('em_expense.')->prefix('em_expense')->group(function () {
        Route::get('/list', [EmployeeExpenseController::class, 'index'])->name('index');
        Route::get('/dataProcessing', [EmployeeExpenseController::class, 'dataProcessing'])->name('dataProcessing');
        Route::get('/create', [EmployeeExpenseController::class, 'create'])->name('create');
        Route::post('/store', [EmployeeExpenseController::class, 'store'])->name('store');
        Route::get('/show/{Expense:id}', [EmployeeExpenseController::class, 'show'])->name('show');
        Route::get('/edit/{Expense:id}', [EmployeeExpenseController::class, 'edit'])->name('edit');
        Route::post('/update/{Expense:id}', [EmployeeExpenseController::class, 'update'])->name('update');
        Route::get('/delete/{Expense:id}', [EmployeeExpenseController::class, 'destroy'])->name('destroy');
        Route::get('/status/{Expense:id}/{status}', [EmployeeExpenseController::class, 'statusUpdate'])->name('status');
    });
    //Employe Expense status end

    //Employe salarys status start
    Route::name('salarys.')->prefix('salarys')->group(function () {
        Route::get('/list', [SalaryController::class, 'index'])->name('index');
        Route::get('/dataProcessing', [SalaryController::class, 'dataProcessing'])->name('dataProcessing');
        Route::get('/create', [SalaryController::class, 'create'])->name('create');
        Route::post('/store', [SalaryController::class, 'store'])->name('store');
        Route::get('/show/{Salary:id}', [SalaryController::class, 'show'])->name('show');
        Route::get('/edit/{Salary:id}', [SalaryController::class, 'edit'])->name('edit');
        Route::get('/view/ajax', [SalaryController::class, 'viewAjax'])->name('ajax');
        Route::post('/update/{Salary:id}', [SalaryController::class, 'update'])->name('update');
        Route::get('/delete/{Salary:id}', [SalaryController::class, 'destroy'])->name('destroy');
        Route::get('/status/{Salary:id}/{status}', [SalaryController::class, 'statusUpdate'])->name('status');
    });
    //Employe salarys status end

    //sms status start
    Route::name('sms.')->prefix('sms')->group(function () {
        Route::get('/list', [SmsController::class, 'index'])->name('index');
        Route::get('/dataProcessing', [SmsController::class, 'dataProcessing'])->name('dataProcessing');
        Route::get('/create', [SmsController::class, 'create'])->name('create');
        Route::post('/store', [SmsController::class, 'store'])->name('store');
        Route::get('/show/{sms:id}', [SmsController::class, 'show'])->name('show');
        Route::get('/edit/{sms:id}', [SmsController::class, 'edit'])->name('edit');
        Route::post('/update/{sms:id}', [SmsController::class, 'update'])->name('update');
        Route::get('/delete/{sms:id}', [SmsController::class, 'destroy'])->name('destroy');
        Route::get('/status/{sms:id}/send-message', [SmsController::class, 'sendMessage'])->name('send.message');
    });
    //sms status end
    //PPP Profile status start
    Route::name('m_p_p_p_profiles.')->prefix('ppp-profiles')->group(function () {
        Route::get('/list', [MPPPProfileController::class, 'index'])->name('index');
        Route::get('/dataProcessing', [MPPPProfileController::class, 'dataProcessing'])->name('dataProcessing');
        Route::get('/create', [MPPPProfileController::class, 'create'])->name('create');
        Route::post('/store', [MPPPProfileController::class, 'store'])->name('store');
        Route::get('/show/{m_p_p_p_profile:id}', [MPPPProfileController::class, 'show'])->name('show');
        Route::get('/edit/{m_p_p_p_profile:id}', [MPPPProfileController::class, 'edit'])->name('edit');
        Route::post('/update/{m_p_p_p_profile:id}', [MPPPProfileController::class, 'update'])->name('update');
        Route::get('/delete/{m_p_p_p_profile:id}', [MPPPProfileController::class, 'destroy'])->name('destroy');
        Route::get('/status/{m_p_p_p_profile:id}/send-message', [MPPPProfileController::class, 'sendMessage'])->name('send.message');
    });
    //Profile status status end

    //PPP Active Connection status start
    Route::name('activeconnections.')->prefix('active-connections')->group(function () {
        Route::get('/list', [ActiveConnectionController::class, 'index'])->name('index');
        Route::get('/dataProcessing', [ActiveConnectionController::class, 'dataProcessing'])->name('dataProcessing');
        Route::get('/show/{m_p_p_p_profile:id}', [ActiveConnectionController::class, 'show'])->name('show');
    });
    //Active Connection status end

    //PPP Interface status start
    Route::name('minterface.')->prefix('interface')->group(function () {
        Route::get('/list', [MInterfaceController::class, 'index'])->name('index');
        Route::get('/dataProcessing', [MInterfaceController::class, 'dataProcessing'])->name('dataProcessing');
        Route::get('/show/{m_p_p_p_profile:id}', [MInterfaceController::class, 'show'])->name('show');
    });
    //Interface status end

    //Pool status start
    Route::name('mpool.')->prefix('mpool')->group(function () {
        Route::get('/list', [MPoolController::class, 'index'])->name('index');
        Route::get('/dataProcessing', [MPoolController::class, 'dataProcessing'])->name('dataProcessing');
        Route::get('/create', [MPoolController::class, 'create'])->name('create');
        Route::post('/store', [MPoolController::class, 'store'])->name('store');
        Route::get('/show/{mpool:id}', [MPoolController::class, 'show'])->name('show');
        Route::get('/edit/{mpool:id}', [MPoolController::class, 'edit'])->name('edit');
        Route::post('/update/{mpool:id}', [MPoolController::class, 'update'])->name('update');
        Route::get('/delete/{mpool:id}', [MPoolController::class, 'destroy'])->name('destroy');
        Route::get('/status/{mpool:id}/send-message', [MPoolController::class, 'sendMessage'])->name('send.message');
    });
    //Pool Interface status end

    //Billcollect start
    Route::name('billcollect.')->prefix('billcollect')->group(function () {
        Route::get('/list', [BillingController::class, 'index'])->name('index');
        Route::get('/dataProcessing', [BillingController::class, 'dataProcessing'])->name('dataProcessing');
        Route::get('/create', [BillingController::class, 'create'])->name('create');
        Route::post('/store', [BillingController::class, 'store'])->name('store');
        // Route::get('/show/{billing:id}', [BillingController::class, 'show'])->name('show');
        // Route::get('/edit/{billing:id}', [BillingController::class, 'edit'])->name('edit');
        Route::post('/update/{billing:id}', [BillingController::class, 'update'])->name('update');
        // Route::get('/delete/{billing:id}', [BillingController::class, 'destroy'])->name('destroy');
        Route::get('/pay-bill-details/{billing:id}', [BillingController::class, 'payment'])->name('payment');
        Route::get('/pay-bill/{billing:id}', [BillingController::class, 'pay'])->name('pay');
        Route::get('/invoice/{billing:id}', [BillingController::class, 'invoice'])->name('invoice');
        Route::get('/invoice-print', [BillingController::class, 'invoiceprint'])->name('invoice.print');
        Route::get('/pay-list/{billing:id}', [BillingController::class, 'paylist'])->name('paylist');
    });
    //Billcollect end

    //Advance Billing start
    Route::name('advancebilling.')->prefix('advancebilling')->group(function () {
        Route::get('/list', [AdvanceBillingController::class, 'index'])->name('index');
        Route::get('/dataProcessing', [AdvanceBillingController::class, 'dataProcessing'])->name('dataProcessing');
        Route::get('/create', [AdvanceBillingController::class, 'create'])->name('create');
        Route::post('/store', [AdvanceBillingController::class, 'store'])->name('store');
        // Route::get('/show/{billing:id}', [AdvanceBillingController::class, 'show'])->name('show');
        Route::get('/edit/{advancebilling:id}', [AdvanceBillingController::class, 'edit'])->name('edit');
        Route::post('/update/{advancebilling:id}', [AdvanceBillingController::class, 'update'])->name('update');
        Route::get('/delete/{advancebilling:id}', [AdvanceBillingController::class, 'destroy'])->name('destroy');
        // Route::get('/pay-bill-details/{billing:id}', [AdvanceBillingController::class, 'payment'])->name('payment');
        // Route::get('/pay-bill/{billing:id}', [AdvanceBillingController::class, 'pay'])->name('pay');
        // Route::get('/invoice/{billing:id}', [AdvanceBillingController::class, 'invoice'])->name('invoice');
        // Route::get('/invoice-print', [AdvanceBillingController::class, 'invoiceprint'])->name('invoice.print');
        // Route::get('/pay-list/{billing:id}', [AdvanceBillingController::class, 'paylist'])->name('paylist');
    });
    //Advance Billing end

    //Billing Details start
    Route::name('billing_details.')->prefix('billing_details')->group(function () {
        Route::get('/list', [BillingDetailsController::class, 'index'])->name('index');
        Route::get('/dataProcessing', [BillingDetailsController::class, 'dataProcessing'])->name('dataProcessing');
        Route::get('/create', [BillingDetailsController::class, 'create'])->name('create');
        Route::post('/store', [BillingDetailsController::class, 'store'])->name('store');
        // Route::get('/show/{billing:id}', [BillingDetailsController::class, 'show'])->name('show');
        // Route::get('/edit/{billing:id}', [BillingDetailsController::class, 'edit'])->name('edit');
        Route::post('/update/{billingdetails:id}', [BillingDetailsController::class, 'update'])->name('update');
        // Route::get('/delete/{billing:id}', [BillingDetailsController::class, 'destroy'])->name('destroy');
        Route::get('/pay-bill-details/{billingdetails:id}', [BillingDetailsController::class, 'payment'])->name('payment');
        Route::get('/pay-bill/{billingdetails:id}', [BillingDetailsController::class, 'pay'])->name('pay');
        Route::get('/invoice/{billingdetails:id}', [BillingDetailsController::class, 'invoice'])->name('invoice');
        Route::get('/invoice-print', [BillingDetailsController::class, 'invoiceprint'])->name('invoice.print');
        Route::get('/pay-list/{billingdetails:id}', [BillingDetailsController::class, 'paylist'])->name('paylist');
    });
    //Billing Details end

    //Package Update and Down Rate start
    Route::name('package_update_and_down_rate.')->prefix('package_update_and_down_rate')->group(function () {
        Route::get('/list', [PackageUpdateDownRateController::class, 'index'])->name('index');
        Route::get('/dataProcessing', [PackageUpdateDownRateController::class, 'dataProcessing'])->name('dataProcessing');
        Route::get('/create', [PackageUpdateDownRateController::class, 'create'])->name('create');
        Route::post('/store', [PackageUpdateDownRateController::class, 'store'])->name('store');
        // Route::get('/show/{billing:id}', [PackageUpdateDownRateController::class, 'show'])->name('show');
        Route::get('/edit/{Packageupdatedownrate:id}', [PackageUpdateDownRateController::class, 'edit'])->name('edit');
        Route::post('/update/{Packageupdatedownrate:id}', [PackageUpdateDownRateController::class, 'update'])->name('update');
        Route::get('/delete/{Packageupdatedownrate:id}', [PackageUpdateDownRateController::class, 'destroy'])->name('destroy');
    });
    //Package Update and Down Rate end

    //Billcollected status start
    Route::name('billcollected.')->prefix('billcollected')->group(function () {
        Route::get('/list', [CollectedBillingController::class, 'index'])->name('index');
        Route::get('/dataProcessing', [CollectedBillingController::class, 'dataProcessing'])->name('dataProcessing');
        Route::get('/pay-list/{billcollected:id}', [CollectedBillingController::class, 'paylist'])->name('paylist');
    });
    //Billcollected Interface status end

    //District start
    Route::name('district.')->prefix('district')->group(function () {
        Route::get('/list', [DistrictController::class, 'index'])->name('index');
        Route::get('/dataProcessing', [DistrictController::class, 'dataProcessing'])->name('dataProcessing');
        Route::get('/create', [DistrictController::class, 'create'])->name('create');
        Route::post('/store', [DistrictController::class, 'store'])->name('store');
        Route::get('/show/{district:id}', [DistrictController::class, 'show'])->name('show');
        Route::get('/edit/{district:id}', [DistrictController::class, 'edit'])->name('edit');
        Route::post('/update/{district:id}', [DistrictController::class, 'update'])->name('update');
        Route::get('/delete/{district:id}', [DistrictController::class, 'destroy'])->name('destroy');
    });
    //District end

    //Upozilla start
    Route::name('upozilla.')->prefix('upozilla')->group(function () {
        Route::get('/list', [UpozillaController::class, 'index'])->name('index');
        Route::get('/dataProcessing', [UpozillaController::class, 'dataProcessing'])->name('dataProcessing');
        Route::get('/create', [UpozillaController::class, 'create'])->name('create');
        Route::post('/store', [UpozillaController::class, 'store'])->name('store');
        Route::get('/show/{upozilla:id}', [UpozillaController::class, 'show'])->name('show');
        Route::get('/edit/{upozilla:id}', [UpozillaController::class, 'edit'])->name('edit');
        Route::post('/update/{upozilla:id}', [UpozillaController::class, 'update'])->name('update');
        Route::get('/delete/{upozilla:id}', [UpozillaController::class, 'destroy'])->name('destroy');
    });
    //Upozilla end

    //Zone start
    Route::name('zones.')->prefix('zones')->group(function () {
        Route::get('/list', [ZoneController::class, 'index'])->name('index');
        Route::get('/dataProcessing', [ZoneController::class, 'dataProcessing'])->name('dataProcessing');
        Route::get('/create', [ZoneController::class, 'create'])->name('create');
        Route::post('/store', [ZoneController::class, 'store'])->name('store');
        Route::get('/show/{zone:id}', [ZoneController::class, 'show'])->name('show');
        Route::get('/edit/{zone:id}', [ZoneController::class, 'edit'])->name('edit');
        Route::post('/update/{zone:id}', [ZoneController::class, 'update'])->name('update');
        Route::get('/delete/{zone:id}', [ZoneController::class, 'destroy'])->name('destroy');
        Route::get('/upozilla/ajax', [ZoneController::class, 'getSubCat'])->name('getUpozilla');
    });
    //Zone end

    //subzone start
    Route::name('subzones.')->prefix('subzones')->group(function () {
        Route::get('/list', [SubzoneController::class, 'index'])->name('index');
        Route::get('/dataProcessing', [SubzoneController::class, 'dataProcessing'])->name('dataProcessing');
        Route::get('/create', [SubzoneController::class, 'create'])->name('create');
        Route::post('/store', [SubzoneController::class, 'store'])->name('store');
        Route::get('/show/{subzone:id}', [SubzoneController::class, 'show'])->name('show');
        Route::get('/edit/{subzone:id}', [SubzoneController::class, 'edit'])->name('edit');
        Route::post('/update/{subzone:id}', [SubzoneController::class, 'update'])->name('update');
        Route::get('/delete/{subzone:id}', [SubzoneController::class, 'destroy'])->name('destroy');
        Route::get('/zone/ajax', [SubzoneController::class, 'getSubSubCat'])->name('getZone');
    });
    //subzone end

    //Tjs start
    Route::name('tjs.')->prefix('tjs')->group(function () {
        Route::get('/list', [TjController::class, 'index'])->name('index');
        Route::get('/dataProcessing', [TjController::class, 'dataProcessing'])->name('dataProcessing');
        Route::get('/create', [TjController::class, 'create'])->name('create');
        Route::post('/store', [TjController::class, 'store'])->name('store');
        Route::get('/show/{tj:id}', [TjController::class, 'show'])->name('show');
        Route::get('/edit/{tj:id}', [TjController::class, 'edit'])->name('edit');
        Route::post('/update/{tj:id}', [TjController::class, 'update'])->name('update');
        Route::get('/delete/{tj:id}', [TjController::class, 'destroy'])->name('destroy');
    });
    //Tjs end

    //spliters start
    Route::name('splitters.')->prefix('splitters')->group(function () {
        Route::get('/list', [SplitterController::class, 'index'])->name('index');
        Route::get('/dataProcessing', [SplitterController::class, 'dataProcessing'])->name('dataProcessing');
        Route::get('/create', [SplitterController::class, 'create'])->name('create');
        Route::post('/store', [SplitterController::class, 'store'])->name('store');
        Route::get('/show/{splitter:id}', [SplitterController::class, 'show'])->name('show');
        Route::get('/edit/{splitter:id}', [SplitterController::class, 'edit'])->name('edit');
        Route::post('/update/{splitter:id}', [SplitterController::class, 'update'])->name('update');
        Route::get('/delete/{splitter:id}', [SplitterController::class, 'destroy'])->name('destroy');
    });
    //spliters end

    //box start
    Route::name('boxes.')->prefix('boxes')->group(function () {
        Route::get('/list', [BoxController::class, 'index'])->name('index');
        Route::get('/dataProcessing', [BoxController::class, 'dataProcessing'])->name('dataProcessing');
        Route::get('/create', [BoxController::class, 'create'])->name('create');
        Route::post('/store', [BoxController::class, 'store'])->name('store');
        Route::get('/show/{box:id}', [BoxController::class, 'show'])->name('show');
        Route::get('/edit/{box:id}', [BoxController::class, 'edit'])->name('edit');
        Route::post('/update/{box:id}', [BoxController::class, 'update'])->name('update');
        Route::get('/delete/{box:id}', [BoxController::class, 'destroy'])->name('destroy');
    });
    //box end

    //Product category start
    Route::name('productCategory.')->prefix('product-category')->group(function () {
        Route::get('/list', [ProductCategoryController::class, 'index'])->name('index');
        Route::get('/dataProcessing', [ProductCategoryController::class, 'dataProcessing'])->name('dataProcessing');
        Route::get('/create', [ProductCategoryController::class, 'create'])->name('create');
        Route::post('/store', [ProductCategoryController::class, 'store'])->name('store');
        Route::get('/show/{productcategory:id}', [ProductCategoryController::class, 'show'])->name('show');
        Route::get('/edit/{productcategory:id}', [ProductCategoryController::class, 'edit'])->name('edit');
        Route::post('/update/{productcategory:id}', [ProductCategoryController::class, 'update'])->name('update');
        Route::get('/delete/{productcategory:id}', [ProductCategoryController::class, 'destroy'])->name('destroy');
    });
    //Product category end

    //Unit start
    Route::name('units.')->prefix('units')->group(function () {
        Route::get('/list', [UnitController::class, 'index'])->name('index');
        Route::get('/dataProcessing', [UnitController::class, 'dataProcessing'])->name('dataProcessing');
        Route::get('/create', [UnitController::class, 'create'])->name('create');
        Route::post('/store', [UnitController::class, 'store'])->name('store');
        Route::get('/show/{unit:id}', [UnitController::class, 'show'])->name('show');
        Route::get('/edit/{unit:id}', [UnitController::class, 'edit'])->name('edit');
        Route::post('/update/{unit:id}', [UnitController::class, 'update'])->name('update');
        Route::get('/delete/{unit:id}', [UnitController::class, 'destroy'])->name('destroy');
    });
    //Unit end

    //products start
    Route::name('products.')->prefix('products')->group(function () {
        Route::get('/list', [ProductController::class, 'index'])->name('index');
        Route::get('/dataProcessing', [ProductController::class, 'dataProcessing'])->name('dataProcessing');
        Route::get('/create', [ProductController::class, 'create'])->name('create');
        Route::post('/store', [ProductController::class, 'store'])->name('store');
        Route::get('/show/{products:id}', [ProductController::class, 'show'])->name('show');
        Route::get('/edit/{products:id}', [ProductController::class, 'edit'])->name('edit');
        Route::post('/update/{products:id}', [ProductController::class, 'update'])->name('update');
        Route::get('/delete/{products:id}', [ProductController::class, 'destroy'])->name('destroy');
    });
    //products end

    //Supplier start
    Route::name('suppliers.')->prefix('suppliers')->group(function () {
        Route::get('/list', [SupplierController::class, 'index'])->name('index');
        Route::get('/dataProcessing', [SupplierController::class, 'dataProcessing'])->name('dataProcessing');
        Route::get('/create', [SupplierController::class, 'create'])->name('create');
        Route::post('/store', [SupplierController::class, 'store'])->name('store');
        Route::get('/show/{supplier:id}', [SupplierController::class, 'show'])->name('show');
        Route::get('/edit/{supplier:id}', [SupplierController::class, 'edit'])->name('edit');
        Route::post('/update/{supplier:id}', [SupplierController::class, 'update'])->name('update');
        Route::get('/delete/{supplier:id}', [SupplierController::class, 'destroy'])->name('destroy');
    });
    //Supplier end

    //Asset management start
    Route::name('assets.')->prefix('assets')->group(function () {
        Route::get('/list', [AssetCategoryController::class, 'index'])->name('index');
        Route::get('/dataProcessing', [AssetCategoryController::class, 'dataProcessing'])->name('dataProcessing');
        Route::get('/create', [AssetCategoryController::class, 'create'])->name('create');
        Route::post('/store', [AssetCategoryController::class, 'store'])->name('store');
        Route::get('/show/{assetscategory:id}', [AssetCategoryController::class, 'show'])->name('show');
        Route::get('/edit/{assetscategory:id}', [AssetCategoryController::class, 'edit'])->name('edit');
        Route::post('/update/{assetscategory:id}', [AssetCategoryController::class, 'update'])->name('update');
        Route::get('/delete/{assetscategory:id}', [AssetCategoryController::class, 'destroy'])->name('destroy');
        Route::get('/status/{assetscategory:id}', [AssetCategoryController::class, 'status'])->name('status');
    });
    Route::name('reasons.')->prefix('reasons')->group(function () {
        Route::get('/list', [ReasonController::class, 'index'])->name('index');
        Route::get('/dataProcessing', [ReasonController::class, 'dataProcessing'])->name('dataProcessing');
        Route::get('/create', [ReasonController::class, 'create'])->name('create');
        Route::post('/store', [ReasonController::class, 'store'])->name('store');
        Route::get('/show/{assetcategory:id}', [ReasonController::class, 'show'])->name('show');
        Route::get('/edit/{assetcategory:id}', [ReasonController::class, 'edit'])->name('edit');
        Route::post('/update/{assetcategory:id}', [ReasonController::class, 'update'])->name('update');
        Route::get('/delete/{assetcategory:id}', [ReasonController::class, 'destroy'])->name('destroy');
    });
    Route::name('assetlist.')->prefix('assetlist')->group(function () {
        Route::get('/list', [AssetContoller::class, 'index'])->name('index');
        Route::get('/dataProcessing', [AssetContoller::class, 'dataProcessing'])->name('dataProcessing');
        Route::get('/create', [AssetContoller::class, 'create'])->name('create');
        Route::post('/store', [AssetContoller::class, 'store'])->name('store');
        Route::get('/show/{assetlist:id}', [AssetContoller::class, 'show'])->name('show');
        Route::get('/edit/{assetlist:id}', [AssetContoller::class, 'edit'])->name('edit');
        Route::post('/update/{assetlist:id}', [AssetContoller::class, 'update'])->name('update');
        Route::get('/delete/{assetlist:id}', [AssetContoller::class, 'destroy'])->name('destroy');
        Route::get('/status/{assetlist:id}', [AssetContoller::class, 'status'])->name('status');
    });
    Route::name('destroyitems.')->prefix('destroyitems')->group(function () {
        Route::get('/list', [DestroyItemController::class, 'index'])->name('index');
        Route::get('/dataProcessing', [DestroyItemController::class, 'dataProcessing'])->name('dataProcessing');
        Route::get('/create', [DestroyItemController::class, 'create'])->name('create');
        Route::post('/store', [DestroyItemController::class, 'store'])->name('store');
        Route::get('/show/{destroyitems:id}', [DestroyItemController::class, 'show'])->name('show');
        Route::get('/edit/{destroyitems:id}', [DestroyItemController::class, 'edit'])->name('edit');
        Route::post('/update/{destroyitems:id}', [DestroyItemController::class, 'update'])->name('update');
        Route::get('/delete/{destroyitems:id}', [DestroyItemController::class, 'destroy'])->name('destroy');
    });
    //Asset management end

    //Brand start
    Route::name('brands.')->prefix('brands')->group(function () {
        Route::get('/list', [BrandController::class, 'index'])->name('index');
        Route::get('/dataProcessing', [BrandController::class, 'dataProcessing'])->name('dataProcessing');
        Route::get('/create', [BrandController::class, 'create'])->name('create');
        Route::post('/store', [BrandController::class, 'store'])->name('store');
        Route::get('/show/{brans:id}', [BrandController::class, 'show'])->name('show');
        Route::get('/edit/{brans:id}', [BrandController::class, 'edit'])->name('edit');
        Route::post('/update/{brans:id}', [BrandController::class, 'update'])->name('update');
        Route::get('/delete/{brans:id}', [BrandController::class, 'destroy'])->name('destroy');
    });
    //Brand end

    //Brand start
    Route::name('companies.')->prefix('companies')->group(function () {
        Route::get('/list', [CompanyController::class, 'index'])->name('index');
        Route::get('/dataProcessing', [CompanyController::class, 'dataProcessing'])->name('dataProcessing');
        // Route::get('/create', [CompanyController::class, 'create'])->name('create');
        // Route::post('/store', [CompanyController::class, 'store'])->name('store');
        Route::get('/show/{company:id}', [CompanyController::class, 'show'])->name('show');
        Route::get('/edit/{company:id}', [CompanyController::class, 'edit'])->name('edit');
        Route::post('/update/{company:id}', [CompanyController::class, 'update'])->name('update');
        Route::get('/delete/{company:id}', [CompanyController::class, 'destroy'])->name('destroy');
    });
    //Brand end

    //Purchase start
    Route::name('purchases.')->prefix('purchases')->group(function () {
        Route::get('/list', [PurchaseController::class, 'index'])->name('index');
        Route::get('/dataProcessing', [PurchaseController::class, 'dataProcessing'])->name('dataProcessing');
        Route::get('/create', [PurchaseController::class, 'create'])->name('create');
        Route::post('/store', [PurchaseController::class, 'store'])->name('store');
        Route::get('/show/{purchase:id}', [PurchaseController::class, 'show'])->name('show');
        Route::get('/edit/{purchase:id}', [PurchaseController::class, 'edit'])->name('edit');
        Route::post('/update/{purchase:id}', [PurchaseController::class, 'update'])->name('update');
        Route::get('/delete/{purchase:id}', [PurchaseController::class, 'destroy'])->name('destroy');
        Route::get('/get-product', [PurchaseController::class, 'getProductList'])->name('get.product');
        Route::get('/get-unitPice', [PurchaseController::class, 'unitPrice'])->name('unitPice');
        Route::get('/get-account', [PurchaseController::class, 'getAccounts'])->name('accounts');
        Route::get('/get-balance', [AccountController::class, 'getBalance'])->name('getBalance');
        Route::get('/all-stock', [PurchaseController::class, 'allstock'])->name('stock.list');

        Route::get('/invoice/{purchase:id}', [PurchaseController::class, 'invoice'])->name('invoice');
    });
    //Purchase end

    //Stock Out start
    Route::name('stockout.')->prefix('stockout')->group(function () {
        Route::get('/list', [StockOutController::class, 'index'])->name('index');
        Route::get('/dataProcessing', [StockOutController::class, 'dataProcessing'])->name('dataProcessing');
        Route::get('/create', [StockOutController::class, 'create'])->name('create');
        Route::post('/store', [StockOutController::class, 'store'])->name('store');
        Route::get('/show/{brans:id}', [StockOutController::class, 'show'])->name('show');
        Route::get('/edit/{brans:id}', [StockOutController::class, 'edit'])->name('edit');
        Route::post('/update/{brans:id}', [StockOutController::class, 'update'])->name('update');
        Route::get('/delete/{brans:id}', [StockOutController::class, 'destroy'])->name('destroy');
        Route::get('/get-product', [StockOutController::class, 'getProductList'])->name('get.product');
        Route::get('/get-quantity', [StockOutController::class, 'getQty'])->name('get.quantity');
    });
    //Stock Out end

    //Mac package  start
    Route::name('macpackage.')->prefix('macpackage')->group(function () {
        Route::get('/list', [MacPackageController::class, 'index'])->name('index');
        Route::get('/dataProcessing', [MacPackageController::class, 'dataProcessing'])->name('dataProcessing');
        Route::get('/create', [MacPackageController::class, 'create'])->name('create');
        Route::post('/store', [MacPackageController::class, 'store'])->name('store');
        Route::get('/show/{macpackage:id}', [MacPackageController::class, 'show'])->name('show');
        Route::get('/edit/{macpackage:id}', [MacPackageController::class, 'edit'])->name('edit');
        Route::post('/update/{macpackage:id}', [MacPackageController::class, 'update'])->name('update');
        Route::get('/delete/{macpackage:id}', [MacPackageController::class, 'destroy'])->name('destroy');
    });
    //Mac Reseller end

    //package operation start
    Route::name('packages2.')->prefix('packages2')->group(function () {
        Route::get('/list', [Package2Controller::class, 'index'])->name('index');
        Route::get('/dataProcessing', [Package2Controller::class, 'dataProcessing'])->name('dataProcessing');
        Route::get('/create', [Package2Controller::class, 'create'])->name('create')->middleware(['ismac']);
        Route::post('/store', [Package2Controller::class, 'store'])->name('store');
        Route::get('/edit/{package2:id}', [Package2Controller::class, 'edit'])->name('edit');
        Route::get('/show/{package2:id}', [Package2Controller::class, 'show'])->name('show');
        Route::post('/update/{package2:id}', [Package2Controller::class, 'update'])->name('update');
        Route::get('/delete/{package2:id}', [Package2Controller::class, 'destroy'])->name('destroy');
        Route::get('/status/{package2:id}/{status}', [Package2Controller::class, 'statusUpdate'])->name('status');
    });
    //package operation end

    //Mac Tariff Config start
    Route::name('mactariffconfig.')->prefix('mactariffconfig')->group(function () {
        Route::get('/list', [MacTariffConfigController::class, 'index'])->name('index');
        Route::get('/dataProcessing', [MacTariffConfigController::class, 'dataProcessing'])->name('dataProcessing');
        Route::get('/create', [MacTariffConfigController::class, 'create'])->name('create');
        Route::post('/store', [MacTariffConfigController::class, 'store'])->name('store');
        Route::get('/show/{mactariffconfig:id}', [MacTariffConfigController::class, 'show'])->name('show');
        Route::get('/edit/{mactariffconfig:id}', [MacTariffConfigController::class, 'edit'])->name('edit');
        Route::post('/update/{mactariffconfig:id}', [MacTariffConfigController::class, 'update'])->name('update');
        Route::get('/delete/{mactariffconfig:id}', [MacTariffConfigController::class, 'destroy'])->name('destroy');
        Route::get('/get-profile', [MacTariffConfigController::class, 'getprofile'])->name('getprofile');
    });
    //Mac Tariff Config end

    //User Package start
    Route::name('userpackage.')->prefix('userpackage')->group(function () {
        Route::get('/list', [UserPackageController::class, 'index'])->name('index');
        Route::get('/dataProcessing', [UserPackageController::class, 'dataProcessing'])->name('dataProcessing');
        Route::get('/create', [UserPackageController::class, 'create'])->name('create');
        Route::post('/store', [UserPackageController::class, 'store'])->name('store');
        Route::get('/show/{userpackage:id}', [UserPackageController::class, 'show'])->name('show');
        Route::get('/edit/{userpackage:id}', [UserPackageController::class, 'edit'])->name('edit');
        Route::post('/update/{userpackage:id}', [UserPackageController::class, 'update'])->name('update');
        Route::get('/delete/{userpackage:id}', [UserPackageController::class, 'destroy'])->name('destroy');
        Route::get('/get-profile', [UserPackageController::class, 'getprofile'])->name('getprofile');
    });
    //User Package end

    //Mac Reseller start
    Route::name('macreseller.')->prefix('macreseller')->group(function () {
        Route::get('/list', [MacResellerController::class, 'index'])->name('index');
        Route::get('/dataProcessing', [MacResellerController::class, 'dataProcessing'])->name('dataProcessing');
        Route::get('/create', [MacResellerController::class, 'create'])->name('create');
        Route::post('/store', [MacResellerController::class, 'store'])->name('store');
        Route::get('/show/{MacReseller:id}', [MacResellerController::class, 'show'])->name('show');
        Route::get('/edit/{MacReseller:id}', [MacResellerController::class, 'edit'])->name('edit');
        Route::post('/update/{MacReseller:id}', [MacResellerController::class, 'update'])->name('update');
        Route::get('/delete/{MacReseller:id}', [MacResellerController::class, 'destroy'])->name('destroy');
    });
    //Mac Reseller end
    //Device start
    Route::name('devices.')->prefix('devices')->group(function () {
        Route::get('/list', [DeviceController::class, 'index'])->name('index');
        Route::get('/dataProcessing', [DeviceController::class, 'dataProcessing'])->name('dataProcessing');
        Route::get('/create', [DeviceController::class, 'create'])->name('create');
        Route::post('/store', [DeviceController::class, 'store'])->name('store');
        Route::get('/show/{device:id}', [DeviceController::class, 'show'])->name('show');
        Route::get('/edit/{device:id}', [DeviceController::class, 'edit'])->name('edit');
        Route::post('/update/{device:id}', [DeviceController::class, 'update'])->name('update');
        Route::get('/delete/{device:id}', [DeviceController::class, 'destroy'])->name('destroy');
    });
    //Device end

    //Connection Type start
    Route::name('connections.')->prefix('connections')->group(function () {
        Route::get('/list', [ConnectionTypeController::class, 'index'])->name('index');
        Route::get('/dataProcessing', [ConnectionTypeController::class, 'dataProcessing'])->name('dataProcessing');
        Route::get('/create', [ConnectionTypeController::class, 'create'])->name('create');
        Route::post('/store', [ConnectionTypeController::class, 'store'])->name('store');
        Route::get('/show/{connection:id}', [ConnectionTypeController::class, 'show'])->name('show');
        Route::get('/edit/{connection:id}', [ConnectionTypeController::class, 'edit'])->name('edit');
        Route::post('/update/{connection:id}', [ConnectionTypeController::class, 'update'])->name('update');
        Route::get('/delete/{connection:id}', [ConnectionTypeController::class, 'destroy'])->name('destroy');
    });
    //Connection Type end

    //Protocol Type start
    Route::name('protocols.')->prefix('protocols')->group(function () {
        Route::get('/list', [ProtocolController::class, 'index'])->name('index');
        Route::get('/dataProcessing', [ProtocolController::class, 'dataProcessing'])->name('dataProcessing');
        Route::get('/create', [ProtocolController::class, 'create'])->name('create');
        Route::post('/store', [ProtocolController::class, 'store'])->name('store');
        Route::get('/show/{protocol:id}', [ProtocolController::class, 'show'])->name('show');
        Route::get('/edit/{protocol:id}', [ProtocolController::class, 'edit'])->name('edit');
        Route::post('/update/{protocol:id}', [ProtocolController::class, 'update'])->name('update');
        Route::get('/delete/{protocol:id}', [ProtocolController::class, 'destroy'])->name('destroy');
    });
    //Protocol Type end

    //Protocol Type start
    Route::name('billingstatus.')->prefix('billing-status')->group(function () {
        Route::get('/list', [BillingStatusController::class, 'index'])->name('index');
        Route::get('/dataProcessing', [BillingStatusController::class, 'dataProcessing'])->name('dataProcessing');
        Route::get('/create', [BillingStatusController::class, 'create'])->name('create');
        Route::post('/store', [BillingStatusController::class, 'store'])->name('store');
        Route::get('/show/{billingstatus:id}', [BillingStatusController::class, 'show'])->name('show');
        Route::get('/edit/{billingstatus:id}', [BillingStatusController::class, 'edit'])->name('edit');
        Route::post('/update/{billingstatus:id}', [BillingStatusController::class, 'update'])->name('update');
        Route::get('/delete/{billingstatus:id}', [BillingStatusController::class, 'destroy'])->name('destroy');
    });
    //Protocol Type end

    //Protocol Type start
    Route::name('payments.')->prefix('payment-method')->group(function () {
        Route::get('/list', [PaymentMethodController::class, 'index'])->name('index');
        Route::get('/dataProcessing', [PaymentMethodController::class, 'dataProcessing'])->name('dataProcessing');
        Route::get('/create', [PaymentMethodController::class, 'create'])->name('create');
        Route::post('/store', [PaymentMethodController::class, 'store'])->name('store');
        Route::get('/show/{payment:id}', [PaymentMethodController::class, 'show'])->name('show');
        Route::get('/edit/{payment:id}', [PaymentMethodController::class, 'edit'])->name('edit');
        Route::post('/update/{payment:id}', [PaymentMethodController::class, 'update'])->name('update');
        Route::get('/delete/{payment:id}', [PaymentMethodController::class, 'destroy'])->name('destroy');
    });
    //Protocol Type end

    //Item categories start
    Route::name('itemcategory.')->prefix('itemcategory')->group(function () {
        Route::get('/list', [ItemCategoryController::class, 'index'])->name('index');
        Route::get('/dataProcessing', [ItemCategoryController::class, 'dataProcessing'])->name('dataProcessing');
        Route::get('/create', [ItemCategoryController::class, 'create'])->name('create');
        Route::post('/store', [ItemCategoryController::class, 'store'])->name('store');
        Route::get('/show/{ItemCategory:id}', [ItemCategoryController::class, 'show'])->name('show');
        Route::get('/edit/{ItemCategory:id}', [ItemCategoryController::class, 'edit'])->name('edit');
        Route::post('/update/{ItemCategory:id}', [ItemCategoryController::class, 'update'])->name('update');
        Route::get('/delete/{ItemCategory:id}', [ItemCategoryController::class, 'destroy'])->name('destroy');
    });
    //Item categories end

    //Item start
    Route::name('items.')->prefix('items')->group(function () {
        Route::get('/list', [ItemController::class, 'index'])->name('index');
        Route::get('/dataProcessing', [ItemController::class, 'dataProcessing'])->name('dataProcessing');
        Route::get('/create', [ItemController::class, 'create'])->name('create');
        Route::post('/store', [ItemController::class, 'store'])->name('store');
        Route::get('/show/{Item:id}', [ItemController::class, 'show'])->name('show');
        Route::get('/edit/{Item:id}', [ItemController::class, 'edit'])->name('edit');
        Route::post('/update/{Item:id}', [ItemController::class, 'update'])->name('update');
        Route::get('/delete/{Item:id}', [ItemController::class, 'destroy'])->name('destroy');
    });
    //Item end

    //Provider start
    Route::name('providers.')->prefix('providers')->group(function () {
        Route::get('/list', [ProviderController::class, 'index'])->name('index');
        Route::get('/dataProcessing', [ProviderController::class, 'dataProcessing'])->name('dataProcessing');
        Route::get('/create', [ProviderController::class, 'create'])->name('create');
        Route::post('/store', [ProviderController::class, 'store'])->name('store');
        Route::get('/show/{Provider:id}', [ProviderController::class, 'show'])->name('show');
        Route::get('/edit/{Provider:id}', [ProviderController::class, 'edit'])->name('edit');
        Route::post('/update/{Provider:id}', [ProviderController::class, 'update'])->name('update');
        Route::get('/delete/{Provider:id}', [ProviderController::class, 'destroy'])->name('destroy');
    });
    //Provider end
    //Provider start
    Route::name('mikrotikserver.')->prefix('mikrotikserver')->group(function () {
        Route::get('/list', [MikrotikServerController::class, 'index'])->name('index');
        Route::get('/dataProcessing', [MikrotikServerController::class, 'dataProcessing'])->name('dataProcessing');
        Route::get('/create', [MikrotikServerController::class, 'create'])->name('create');
        Route::post('/store', [MikrotikServerController::class, 'store'])->name('store');
        Route::get('/show/{mikrotik_server:id}', [MikrotikServerController::class, 'show'])->name('show');
        Route::get('/edit/{mikrotik_server:id}', [MikrotikServerController::class, 'edit'])->name('edit');
        Route::post('/update/{mikrotik_server:id}', [MikrotikServerController::class, 'update'])->name('update');
        Route::get('/delete/{mikrotik_server:id}', [MikrotikServerController::class, 'destroy'])->name('destroy');
        Route::post('/sync', [MikrotikServerController::class, 'sync'])->name('sync');
    });
    //Provider end
    //Provider start
    Route::name('client_types.')->prefix('client_types')->group(function () {
        Route::get('/list', [ClientTypeController::class, 'index'])->name('index');
        Route::get('/dataProcessing', [ClientTypeController::class, 'dataProcessing'])->name('dataProcessing');
        Route::get('/create', [ClientTypeController::class, 'create'])->name('create');
        Route::post('/store', [ClientTypeController::class, 'store'])->name('store');
        Route::get('/show/{ClientType:id}', [ClientTypeController::class, 'show'])->name('show');
        Route::get('/edit/{ClientType:id}', [ClientTypeController::class, 'edit'])->name('edit');
        Route::post('/update/{ClientType:id}', [ClientTypeController::class, 'update'])->name('update');
        Route::get('/delete/{ClientType:id}', [ClientTypeController::class, 'destroy'])->name('destroy');
    });
    //Provider end

    //Provider start
    Route::name('bandwidthCustomers.')->prefix('bandwidthCustomers')->group(function () {
        Route::get('/list', [BandwidthCustomerController::class, 'index'])->name('index');
        Route::get('/dataProcessing', [BandwidthCustomerController::class, 'dataProcessing'])->name('dataProcessing');
        Route::get('/create', [BandwidthCustomerController::class, 'create'])->name('create');
        Route::post('/store', [BandwidthCustomerController::class, 'store'])->name('store');
        Route::get('/show/{bandwidthCustomer:id}', [BandwidthCustomerController::class, 'show'])->name('show');
        Route::get('/edit/{bandwidthCustomer:id}', [BandwidthCustomerController::class, 'edit'])->name('edit');
        Route::post('/update/{bandwidthCustomer:id}', [BandwidthCustomerController::class, 'update'])->name('update');
        Route::get('/delete/{bandwidthCustomer:id}', [BandwidthCustomerController::class, 'destroy'])->name('destroy');
    });
    //Provider end

    //Bandwidth Sale Invoice start
    Route::name('bandwidthsaleinvoice.')->prefix('bandwidthsaleinvoice')->group(function () {
        Route::get('/list', [BandwidthSaleInvoiceController::class, 'index'])->name('index');
        Route::get('/dataProcessing', [BandwidthSaleInvoiceController::class, 'dataProcessing'])->name('dataProcessing');
        Route::get('/create', [BandwidthSaleInvoiceController::class, 'create'])->name('create');
        Route::post('/store', [BandwidthSaleInvoiceController::class, 'store'])->name('store');
        Route::get('/invoice/{banseidthsaleinvoice:id}', [BandwidthSaleInvoiceController::class, 'invoice'])->name('invoice');
        Route::get('/edit/{banseidthsaleinvoice:id}', [BandwidthSaleInvoiceController::class, 'edit'])->name('edit');
        Route::post('/update/{banseidthsaleinvoice:id}', [BandwidthSaleInvoiceController::class, 'update'])->name('update');
        Route::get('/delete/{banseidthsaleinvoice:id}', [BandwidthSaleInvoiceController::class, 'destroy'])->name('destroy');
        Route::get('/delete', [BandwidthSaleInvoiceController::class, 'itemval'])->name('getItemVal');
        Route::get('/pay/{banseidthsaleinvoice:id}', [BandwidthSaleInvoiceController::class, 'pay'])->name('pay');
        Route::post('/paystore/{banseidthsaleinvoice:id}', [BandwidthSaleInvoiceController::class, 'paystore'])->name('paystore');
    });
    //Bandwidth Sale Invoice end

    //Support Category Sale Invoice start
    Route::name('supportcategory.')->prefix('supportcategory')->group(function () {
        Route::get('/list', [SupportCategoryController::class, 'index'])->name('index');
        Route::get('/dataProcessing', [SupportCategoryController::class, 'dataProcessing'])->name('dataProcessing');
        Route::get('/create', [SupportCategoryController::class, 'create'])->name('create');
        Route::post('/store', [SupportCategoryController::class, 'store'])->name('store');
        Route::get('/invoice/{supportcategory:id}', [SupportCategoryController::class, 'invoice'])->name('invoice');
        Route::get('/edit/{supportcategory:id}', [SupportCategoryController::class, 'edit'])->name('edit');
        Route::post('/update/{supportcategory:id}', [SupportCategoryController::class, 'update'])->name('update');
        Route::get('/delete/{supportcategory:id}', [SupportCategoryController::class, 'destroy'])->name('destroy');
    });
    //Support Category Sale Invoice end

    //Support Ticket Sale Invoice start
    Route::name('supportticket.')->prefix('supportticket')->group(function () {
        Route::get('/list', [SupportTicketController::class, 'index'])->name('index');
        Route::get('/dataProcessing', [SupportTicketController::class, 'dataProcessing'])->name('dataProcessing');
        Route::get('/create', [SupportTicketController::class, 'create'])->name('create');
        Route::post('/store', [SupportTicketController::class, 'store'])->name('store');
        Route::get('/invoice/{supportticket:id}', [SupportTicketController::class, 'invoice'])->name('invoice');
        Route::get('/edit/{supportticket:id}', [SupportTicketController::class, 'edit'])->name('edit');
        Route::post('/update/{supportticket:id}', [SupportTicketController::class, 'update'])->name('update');
        Route::get('/delete/{supportticket:id}', [SupportTicketController::class, 'destroy'])->name('destroy');
        Route::get('/user-Details', [SupportTicketController::class, 'userDetails'])->name('userdetails');
        Route::get('/status/{supportticket:id}', [SupportTicketController::class, 'status'])->name('status');
        Route::post('/status-update/{supportticket:id}', [SupportTicketController::class, 'statusupdate'])->name('statusupdate');
    });
    //Support Ticket Sale Invoice end


    //Reports start
    Route::name('reports.')->prefix('reports')->group(function () {
        Route::get('/btrc', [BtrcReportController::class, 'index'])->name('btrc');
        Route::get('/dataProcessing', [BtrcReportController::class, 'dataProcessing'])->name('dataProcessing');

        Route::get('/bill-list', [BillCollectionReportController::class, 'index'])->name('bill.index');
        Route::get('/process-billcollection', [BillCollectionReportController::class, 'bill_collections'])->name('bill_collections');

        Route::get('/discounts', [DiscountReportController::class, 'index'])->name('discounts');
        Route::get('/process-discounts', [DiscountReportController::class, 'discount_process'])->name('discount_process');

        Route::get('/customers', [CustomerReportController::class, 'index'])->name('customers');
        Route::get('/customer-process', [CustomerReportController::class, 'customer_process'])->name('customer_process');
    });
    //Reports end
    //Daily Income report start
    Route::name('dailyincomereports.')->prefix('dailyincomereports')->group(function () {
        Route::get('/list', [DailyIncomeReportController::class, 'index'])->name('index');
        Route::get('/dataProcessing', [DailyIncomeReportController::class, 'dataProcessing'])->name('dataProcessing');

        Route::get('/bill-list', [DailyIncomeReportController::class, 'index'])->name('bill.index');
        Route::get('/process-billcollection', [DailyIncomeReportController::class, 'bill_collections'])->name('bill_collections');

        Route::get('/discounts', [DiscountReportController::class, 'index'])->name('discounts');
        Route::get('/process-discounts', [DiscountReportController::class, 'discount_process'])->name('discount_process');

        Route::get('/customers', [CustomerReportController::class, 'index'])->name('customers');
        Route::get('/customer-process', [CustomerReportController::class, 'customer_process'])->name('customer_process');
    });
    //Daily Income report end

    //Imports start
    Route::name('imports.')->prefix('imports')->group(function () {
        Route::get('/customers', [ImportController::class, 'user_import_form'])->name('customer');
        Route::post('/customers', [ImportController::class, 'user_file_import']);

        /**
         * Billing
         */
        Route::get('/billings', [ImportController::class, 'billing_import_form'])->name('billings');
        Route::post('/billings', [ImportController::class, 'billing_file_import']);
    });
    //Imports end


    //Support Category Sale Invoice start
    Route::name('rollPermission.')->prefix('rollPermission')->group(function () {
        Route::get('/list', [RollPermissionController::class, 'index'])->name('index');
        Route::get('/dataProcessing', [RollPermissionController::class, 'dataProcessing'])->name('dataProcessing');
        Route::get('/create', [RollPermissionController::class, 'create'])->name('create');
        Route::post('/store', [RollPermissionController::class, 'store'])->name('store');
        Route::get('/invoice/{rollpermission:id}', [RollPermissionController::class, 'invoice'])->name('invoice');
        Route::get('/edit/{rollpermission:id}', [RollPermissionController::class, 'edit'])->name('edit');
        Route::post('/update/{rollpermission:id}', [RollPermissionController::class, 'update'])->name('update');
        Route::get('/delete/{rollpermission:id}', [RollPermissionController::class, 'destroy'])->name('destroy');
    });
    //Support Category Sale Invoice end

    //Department start
    Route::name('department.')->prefix('department')->group(function () {
        Route::get('/list', [DepartmentController::class, 'index'])->name('index');
        Route::get('/dataProcessing', [DepartmentController::class, 'dataProcessing'])->name('dataProcessing');
        Route::get('/create', [DepartmentController::class, 'create'])->name('create');
        Route::post('/store', [DepartmentController::class, 'store'])->name('store');
        Route::get('/invoice/{department:id}', [DepartmentController::class, 'invoice'])->name('invoice');
        Route::get('/edit/{department:id}', [DepartmentController::class, 'edit'])->name('edit');
        Route::post('/update/{department:id}', [DepartmentController::class, 'update'])->name('update');
        Route::get('/delete/{department:id}', [DepartmentController::class, 'destroy'])->name('destroy');
    });
    //Department end

    //designation start
    Route::name('designation.')->prefix('designation')->group(function () {
        Route::get('/list', [DesignationController::class, 'index'])->name('index');
        Route::get('/dataProcessing', [DesignationController::class, 'dataProcessing'])->name('dataProcessing');
        Route::get('/create', [DesignationController::class, 'create'])->name('create');
        Route::post('/store', [DesignationController::class, 'store'])->name('store');
        Route::get('/invoice/{designation:id}', [DesignationController::class, 'invoice'])->name('invoice');
        Route::get('/edit/{designation:id}', [DesignationController::class, 'edit'])->name('edit');
        Route::post('/update/{designation:id}', [DesignationController::class, 'update'])->name('update');
        Route::get('/delete/{designation:id}', [DesignationController::class, 'destroy'])->name('destroy');
    });
    //designation end

    //opening balance start
    Route::name('openingbalance.')->prefix('openingbalance')->group(function () {
        Route::get('/list', [OpeningBalanceController::class, 'index'])->name('index');
        Route::get('/dataProcessing', [OpeningBalanceController::class, 'dataProcessing'])->name('dataProcessing');
        Route::get('/create', [OpeningBalanceController::class, 'create'])->name('create');
        Route::post('/store', [OpeningBalanceController::class, 'store'])->name('store');
        Route::get('/invoice/{designation:id}', [OpeningBalanceController::class, 'invoice'])->name('invoice');
        Route::get('/edit/{designation:id}', [OpeningBalanceController::class, 'edit'])->name('edit');
        Route::post('/update/{designation:id}', [OpeningBalanceController::class, 'update'])->name('update');
        Route::get('/delete/{designation:id}', [OpeningBalanceController::class, 'destroy'])->name('destroy');
    });
    //opening balance end

    //balance Transfer start
    Route::name('balancetransfer.')->prefix('balancetransfer')->group(function () {
        Route::get('/list', [BalanceTransferController::class, 'index'])->name('index');
        Route::get('/dataProcessing', [BalanceTransferController::class, 'dataProcessing'])->name('dataProcessing');
        Route::get('/create', [BalanceTransferController::class, 'create'])->name('create');
        Route::post('/store', [BalanceTransferController::class, 'store'])->name('store');
        Route::get('/invoice/{designation:id}', [BalanceTransferController::class, 'invoice'])->name('invoice');
        Route::get('/edit/{designation:id}', [BalanceTransferController::class, 'edit'])->name('edit');
        Route::post('/update/{designation:id}', [BalanceTransferController::class, 'update'])->name('update');
        Route::get('/delete/{designation:id}', [BalanceTransferController::class, 'destroy'])->name('destroy');
    });
    //balance Transfer end

    //vlan start
    Route::name('vlan.')->prefix('vlan')->group(function () {
        Route::get('/list', [VlanController::class, 'index'])->name('index');
        Route::get('/dataProcessing', [VlanController::class, 'dataProcessing'])->name('dataProcessing');
        Route::get('/create', [VlanController::class, 'create'])->name('create');
        Route::post('/store', [VlanController::class, 'store'])->name('store');
        Route::get('/invoice/{vlan:id}', [VlanController::class, 'invoice'])->name('invoice');
        Route::get('/edit/{vlan:id}', [VlanController::class, 'edit'])->name('edit');
        Route::post('/update/{vlan:id}', [VlanController::class, 'update'])->name('update');
        Route::get('/delete/{vlan:id}', [VlanController::class, 'destroy'])->name('destroy');
        Route::get('/disabled/{vlan:id}', [VlanController::class, 'disabled'])->name('disabled');
    });
    //vlan end

    //ip_address start
    Route::name('ip_address.')->prefix('ip_address')->group(function () {
        Route::get('/list', [IpAddressController::class, 'index'])->name('index');
        Route::get('/dataProcessing', [IpAddressController::class, 'dataProcessing'])->name('dataProcessing');
        Route::get('/create', [IpAddressController::class, 'create'])->name('create');
        Route::post('/store', [IpAddressController::class, 'store'])->name('store');
        Route::get('/invoice/{ipaddress:id}', [IpAddressController::class, 'invoice'])->name('invoice');
        Route::get('/edit/{ipaddress:id}', [IpAddressController::class, 'edit'])->name('edit');
        Route::get('/disabled/{ipaddress:id}', [IpAddressController::class, 'disabled'])->name('disabled');
        Route::post('/update/{ipaddress:id}', [IpAddressController::class, 'update'])->name('update');
        Route::get('/delete/{ipaddress:id}', [IpAddressController::class, 'destroy'])->name('destroy');
    });
    //ip_address end

});
require __DIR__ . '/auth.php';
