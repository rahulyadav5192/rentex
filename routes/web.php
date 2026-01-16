<?php

use App\Http\Controllers\AdditionalController;
use App\Http\Controllers\AdvantageController;
use App\Http\Controllers\AgreementController;
use App\Http\Controllers\AmenityController;
use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Controllers\AuthPageController;
use App\Http\Controllers\BlogController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\NoticeBoardController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\FAQController;
use App\Http\Controllers\HomePageController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\OTPController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\PaymentController;
use App\Models\User;

use App\Http\Controllers\PropertyController;
use App\Http\Controllers\TenantController;
use App\Http\Controllers\TenantImportController;
use App\Http\Controllers\TypeController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\InvoiceImportController;
use App\Http\Controllers\AutoInvoiceController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\ExpenseImportController;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\InvoicePaymentController;
use App\Http\Controllers\MaintainerController;
use App\Http\Controllers\MaintenanceRequestController;
use App\Http\Controllers\ReportController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

require __DIR__ . '/auth.php';

// Sitemap route - Must be before other routes
Route::get('/sitemap.xml', [\App\Http\Controllers\SitemapController::class, 'index'])->name('sitemap');

// Robots.txt route - Dynamic with sitemap reference
Route::get('/robots.txt', function () {
    $sitemapUrl = url('/sitemap.xml');
    $content = "User-agent: *\n";
    $content .= "Disallow:\n\n";
    $content .= "Sitemap: {$sitemapUrl}\n";
    return response($content, 200)->header('Content-Type', 'text/plain');
})->name('robots');

Route::get('/', [HomeController::class, 'index'])->middleware(
    [

        'XSS',
    ]
);
Route::get('home', [HomeController::class, 'index'])->name('home')->middleware(
    [

        'XSS',
    ]
);
Route::get('dashboard', [HomeController::class, 'index'])->name('dashboard')->middleware(
    [

        'XSS',
    ]
);

//-------------------------------User-------------------------------------------

Route::resource('users', UserController::class)->middleware(
    [
        'auth',
        'XSS',
    ]
);


Route::get('login/otp', [OTPController::class, 'show'])->name('otp.show')->middleware(
    [

        'XSS',
    ]
);
Route::post('login/otp', [OTPController::class, 'check'])->name('otp.check')->middleware(
    [

        'XSS',
    ]
);
Route::get('login/2fa/disable', [OTPController::class, 'disable'])->name('2fa.disable')->middleware(['XSS',]);

//-------------------------------Subscription-------------------------------------------

Route::group(
    [
        'middleware' => [
            'auth',
            'XSS',
        ],
    ],
    function () {

        Route::resource('subscriptions', SubscriptionController::class);
        Route::get('coupons/history', [CouponController::class, 'history'])->name('coupons.history');
        Route::delete('coupons/history/{id}/destroy', [CouponController::class, 'historyDestroy'])->name('coupons.history.destroy');
        Route::get('coupons/apply', [CouponController::class, 'apply'])->name('coupons.apply');
        Route::resource('coupons', CouponController::class);
        Route::get('subscription/transaction', [SubscriptionController::class, 'transaction'])->name('subscription.transaction');
    }
);

//-------------------------------Subscription Payment-------------------------------------------

Route::group(
    [
        'middleware' => [
            'auth',
            'XSS',
        ],
    ],
    function () {

        Route::post('subscription/{id}/stripe/payment', [SubscriptionController::class, 'stripePayment'])->name('subscription.stripe.payment');
    }
);
//-------------------------------Settings-------------------------------------------
Route::group(
    [
        'middleware' => [
            'auth',
            'XSS',
        ],
    ],
    function () {
        Route::get('settings', [SettingController::class, 'index'])->name('setting.index');

        Route::post('settings/account', [SettingController::class, 'accountData'])->name('setting.account');
        Route::delete('settings/account/delete', [SettingController::class, 'accountDelete'])->name('setting.account.delete');
        Route::post('settings/password', [SettingController::class, 'passwordData'])->name('setting.password');
        Route::post('settings/general', [SettingController::class, 'generalData'])->name('setting.general');
        Route::post('settings/smtp', [SettingController::class, 'smtpData'])->name('setting.smtp');
        Route::get('settings/smtp-test', [SettingController::class, 'smtpTest'])->name('setting.smtp.test');
        Route::post('settings/smtp-test', [SettingController::class, 'smtpTestMailSend'])->name('setting.smtp.testing');
        Route::post('settings/payment', [SettingController::class, 'paymentData'])->name('setting.payment');
        Route::post('settings/site-seo', [SettingController::class, 'siteSEOData'])->name('setting.site.seo');
        Route::post('settings/google-recaptcha', [SettingController::class, 'googleRecaptchaData'])->name('setting.google.recaptcha');
        Route::post('settings/company', [SettingController::class, 'companyData'])->name('setting.company');
        Route::post('settings/2fa', [SettingController::class, 'twofaEnable'])->name('setting.twofa.enable');
        Route::post('settings/agreement', [SettingController::class, 'agreement'])->name('setting.agreement');

        Route::get('footer-setting', [SettingController::class, 'footerSetting'])->name('footerSetting');
        Route::post('settings/footer', [SettingController::class, 'footerData'])->name('setting.footer');

        Route::get('language/{lang}', [SettingController::class, 'lanquageChange'])->name('language.change');
        Route::post('theme/settings', [SettingController::class, 'themeSettings'])->name('theme.settings');

        Route::post('storage/settings', [SettingController::class, 'storageSetting'])->name('storage.setting');

        Route::post('settings/twilio', [SettingController::class, 'twilio'])->name('setting.twilio');
    }
);

//-------------------------------Auto Invoice Settings-------------------------------------------
// Cron endpoint for auto-invoice generation (no auth required, uses token)
Route::get('/auto-invoice/cron/generate', [AutoInvoiceController::class, 'cronGenerate'])->name('auto.invoice.cron.generate');

// Super Admin Auto Invoice Management
Route::prefix('admin/auto-invoice')->name('admin.auto.invoice.')->middleware(['auth', 'XSS'])->group(function () {
    Route::get('/', [AutoInvoiceController::class, 'adminIndex'])->name('index');
    Route::get('/logs', [AutoInvoiceController::class, 'adminLogs'])->name('logs');
    Route::post('/generate/{parentId}', [AutoInvoiceController::class, 'adminGenerate'])->name('generate');
});

Route::prefix('auto-invoice')->name('auto.invoice.')->middleware(['auth', 'XSS'])->group(function () {
    Route::get('/', [AutoInvoiceController::class, 'index'])->name('index');
    Route::post('/global-settings', [AutoInvoiceController::class, 'updateGlobalSettings'])->name('global.settings');
    Route::post('/property/{id}/settings', [AutoInvoiceController::class, 'updatePropertySettings'])->name('property.settings');
    Route::post('/unit/{id}/settings', [AutoInvoiceController::class, 'updateUnitSettings'])->name('unit.settings');
    Route::post('/preview', [AutoInvoiceController::class, 'preview'])->name('preview');
    Route::post('/generate', [AutoInvoiceController::class, 'generate'])->name('generate');
    Route::get('/logs', [AutoInvoiceController::class, 'logs'])->name('logs');
    Route::get('/logs/{id}/details', [AutoInvoiceController::class, 'logDetails'])->name('log.details');
});


//-------------------------------Role & Permissions-------------------------------------------
Route::resource('permission', PermissionController::class)->middleware(
    [
        'auth',
        'XSS',
    ]
);

Route::resource('role', RoleController::class)->middleware(
    [
        'auth',
        'XSS',
    ]
);

//-------------------------------Note-------------------------------------------
Route::resource('note', NoticeBoardController::class)->middleware(
    [
        'auth',
        'XSS',
    ]
);

//-------------------------------Contact-------------------------------------------
// Exclude 'index' from resource to avoid conflict with landing page /contact route
// Define contact.index separately for admin panel
Route::get('/admin/contact', [ContactController::class, 'index'])->middleware(['auth', 'XSS'])->name('contact.index');

Route::resource('contact', ContactController::class)->except(['index'])->middleware(
    [
        'auth',
        'XSS',
    ]
);

//-------------------------------Enquiry-------------------------------------------
Route::resource('enquiry', \App\Http\Controllers\EnquiryController::class)->middleware(
    [
        'auth',
        'XSS',
    ]
);

//-------------------------------logged History-------------------------------------------

Route::group(
    [
        'middleware' => [
            'auth',
            'XSS',
        ],
    ],
    function () {

        Route::get('logged/history', [UserController::class, 'loggedHistory'])->name('logged.history');
        Route::get('logged/{id}/history/show', [UserController::class, 'loggedHistoryShow'])->name('logged.history.show');
        Route::delete('logged/{id}/history', [UserController::class, 'loggedHistoryDestroy'])->name('logged.history.destroy');
    }
);


//-------------------------------Plan Payment-------------------------------------------
Route::group(
    [
        'middleware' => [
            'auth',
            'XSS',
        ],
    ],
    function () {
        Route::post('subscription/{id}/bank-transfer', [PaymentController::class, 'subscriptionBankTransfer'])->name('subscription.bank.transfer');
        Route::get('subscription/{id}/bank-transfer/action/{status}', [PaymentController::class, 'subscriptionBankTransferAction'])->name('subscription.bank.transfer.action');
        Route::post('subscription/{id}/paypal', [PaymentController::class, 'subscriptionPaypal'])->name('subscription.paypal');
        Route::get('subscription/{id}/paypal/{status}', [PaymentController::class, 'subscriptionPaypalStatus'])->name('subscription.paypal.status');
        Route::post('subscription/{id}/{user_id}/manual-assign-package', [PaymentController::class, 'subscriptionManualAssignPackage'])->name('subscription.manual_assign_package');
    }
);

//-------------------------------Notification-------------------------------------------
Route::resource('notification', NotificationController::class)->middleware(
    [
        'auth',
        'XSS',

    ]
);

Route::get('email-verification/{token}', [VerifyEmailController::class, 'verifyEmail'])->name('email-verification')->middleware(
    [
        'XSS',
    ]
);

//-------------------------------FAQ-------------------------------------------
Route::resource('FAQ', FAQController::class)->middleware(
    [
        'auth',
        'XSS',
    ]
);

//-------------------------------Home Page-------------------------------------------
Route::resource('homepage', HomePageController::class)->middleware(
    [
        'auth',
        'XSS',
    ]
);
//-------------------------------FAQ-------------------------------------------
Route::resource('pages', PageController::class)->middleware(
    [
        'auth',
        'XSS',
    ]
);

//-------------------------------Auth page-------------------------------------------
Route::resource('authPage', AuthPageController::class)->middleware(
    [
        'auth',
        'XSS',
    ]
);


//-------------------------------Property-------------------------------------------
Route::group(
    [
        'middleware' => [
            'auth',
            'XSS',
        ],
    ],
    function () {
        Route::resource('property', PropertyController::class);
        Route::get('property/{pid}/unit/create', [PropertyController::class, 'unitCreate'])->name('unit.create');
        Route::post('property/{pid}/unit/store', [PropertyController::class, 'unitStore'])->name('unit.store');
        Route::get('units/direct-create', [PropertyController::class, 'unitdirectCreate'])->name('unit.direct-create');
        Route::post('unit/direct-store', [PropertyController::class, 'unitdirectStore'])->name('unit.direct-store');
        Route::get('property/{pid}/unit/{id}/edit', [PropertyController::class, 'unitEdit'])->name('unit.edit');
        Route::get('unit/{id}/show', [PropertyController::class, 'unitShow'])->name('unit.show');
        Route::get('units', [PropertyController::class, 'units'])->name('unit.index');
        Route::put('property/{pid}/unit/{id}/update', [PropertyController::class, 'unitUpdate'])->name('unit.update');
        Route::delete('property/{pid}/unit/{id}/destroy', [PropertyController::class, 'unitDestroy'])->name('unit.destroy');
        Route::get('property/{pid}/unit', [PropertyController::class, 'getPropertyUnit'])->name('property.unit');
        Route::delete('/property/document/{pid}', [PropertyController::class, 'fileDestroy'])->name('property.image.delete');
        
        // Property Import Routes
        Route::prefix('property-import')->name('property.import.')->group(function () {
            Route::get('/', [\App\Http\Controllers\PropertyImportController::class, 'index'])->name('index');
            Route::get('/mapping', [\App\Http\Controllers\PropertyImportController::class, 'mapping'])->name('mapping');
            Route::post('/upload', [\App\Http\Controllers\PropertyImportController::class, 'upload'])->name('upload');
            Route::post('/validate', [\App\Http\Controllers\PropertyImportController::class, 'validateImport'])->name('validate');
            Route::post('/execute', [\App\Http\Controllers\PropertyImportController::class, 'import'])->name('execute');
            Route::get('/result', [\App\Http\Controllers\PropertyImportController::class, 'result'])->name('result');
            Route::get('/cancel', [\App\Http\Controllers\PropertyImportController::class, 'cancel'])->name('cancel');
        });
    }
);

//-------------------------------Tenant-------------------------------------------
Route::resource('tenant', TenantController::class)->middleware(
    [
        'auth',
        'XSS',
    ]
);

Route::get('tenant/{tid}/exit', [TenantController::class, 'tenantExit'])->name('tenant.exit');
Route::put('tenant/{tid}/update', [TenantController::class, 'tenantExitUpdate'])->name('tenant.exitupdate');

Route::delete('/tenant/document/{id}', [TenantController::class, 'fileDestroy'])->name('tenant.document.delete');
Route::get('tenant/{pid}/unit', [TenantController::class, 'getPropertyUnit'])->name('tenant.unit');

Route::get('/tenant/unit-details/{id}', [TenantController::class, 'getUnitDetails'])->name('tenant.unit.details');

// Tenant Import Routes
Route::prefix('tenant-import')->name('tenant.import.')->middleware(['auth', 'XSS'])->group(function () {
    Route::get('/', [TenantImportController::class, 'index'])->name('index');
    Route::post('/upload', [TenantImportController::class, 'upload'])->name('upload');
    Route::get('/mapping', [TenantImportController::class, 'mapping'])->name('mapping');
    Route::post('/validate', [TenantImportController::class, 'validateImport'])->name('validate');
    Route::post('/execute', [TenantImportController::class, 'import'])->name('execute');
    Route::get('/result', [TenantImportController::class, 'result'])->name('result');
    Route::post('/cancel', [TenantImportController::class, 'cancel'])->name('cancel');
    Route::get('/units', [TenantImportController::class, 'getUnits'])->name('units');
});

Route::prefix('invoice-import')->name('invoice.import.')->middleware(['auth', 'XSS'])->group(function () {
    Route::get('/', [InvoiceImportController::class, 'index'])->name('index');
    Route::post('/upload', [InvoiceImportController::class, 'upload'])->name('upload');
    Route::get('/mapping', [InvoiceImportController::class, 'mapping'])->name('mapping');
    Route::post('/validate', [InvoiceImportController::class, 'validateImport'])->name('validate');
    Route::post('/execute', [InvoiceImportController::class, 'import'])->name('execute');
    Route::get('/result', [InvoiceImportController::class, 'result'])->name('result');
    Route::post('/cancel', [InvoiceImportController::class, 'cancel'])->name('cancel');
    Route::get('/units', [InvoiceImportController::class, 'getUnits'])->name('units');
});

Route::prefix('expense-import')->name('expense.import.')->middleware(['auth', 'XSS'])->group(function () {
    Route::get('/', [ExpenseImportController::class, 'index'])->name('index');
    Route::get('/mapping', [ExpenseImportController::class, 'mapping'])->name('mapping');
    Route::post('/upload', [ExpenseImportController::class, 'upload'])->name('upload');
    Route::post('/validate', [ExpenseImportController::class, 'validateImport'])->name('validate');
    Route::get('/units', [ExpenseImportController::class, 'getUnits'])->name('units');
    Route::post('/execute', [ExpenseImportController::class, 'import'])->name('execute');
    Route::get('/result', [ExpenseImportController::class, 'result'])->name('result');
    Route::get('/cancel', [ExpenseImportController::class, 'cancel'])->name('cancel');
});

Route::prefix('invoice-import')->name('invoice.import.')->middleware(['auth', 'XSS'])->group(function () {
    Route::get('/', [\App\Http\Controllers\InvoiceImportController::class, 'index'])->name('index');
    Route::get('/mapping', [\App\Http\Controllers\InvoiceImportController::class, 'mapping'])->name('mapping');
    Route::post('/upload', [\App\Http\Controllers\InvoiceImportController::class, 'upload'])->name('upload');
    Route::post('/validate', [\App\Http\Controllers\InvoiceImportController::class, 'validateImport'])->name('validate');
    Route::get('/units', [\App\Http\Controllers\InvoiceImportController::class, 'getUnits'])->name('units');
    Route::post('/execute', [\App\Http\Controllers\InvoiceImportController::class, 'import'])->name('execute');
    Route::get('/result', [\App\Http\Controllers\InvoiceImportController::class, 'result'])->name('result');
    Route::get('/cancel', [\App\Http\Controllers\InvoiceImportController::class, 'cancel'])->name('cancel');
});

Route::prefix('expense-import')->name('expense.import.')->middleware(['auth', 'XSS'])->group(function () {
    Route::get('/', [\App\Http\Controllers\ExpenseImportController::class, 'index'])->name('index');
    Route::get('/mapping', [\App\Http\Controllers\ExpenseImportController::class, 'mapping'])->name('mapping');
    Route::post('/upload', [\App\Http\Controllers\ExpenseImportController::class, 'upload'])->name('upload');
    Route::post('/validate', [\App\Http\Controllers\ExpenseImportController::class, 'validateImport'])->name('validate');
    Route::get('/units', [\App\Http\Controllers\ExpenseImportController::class, 'getUnits'])->name('units');
    Route::post('/execute', [\App\Http\Controllers\ExpenseImportController::class, 'import'])->name('execute');
    Route::get('/result', [\App\Http\Controllers\ExpenseImportController::class, 'result'])->name('result');
    Route::get('/cancel', [\App\Http\Controllers\ExpenseImportController::class, 'cancel'])->name('cancel');
});

//-------------------------------Type-------------------------------------------
Route::resource('type', TypeController::class)->middleware(
    [
        'auth',
        'XSS',
    ]
);

//-------------------------------Invoice-------------------------------------------

Route::group(
    [
        'middleware' => [
            'auth',
            'XSS',
        ],
    ],
    function () {
        Route::get('invoice/{id}/payment/create', [InvoiceController::class, 'invoicePaymentCreate'])->name('invoice.payment.create');
        Route::post('invoice/{id}/payment/store', [InvoiceController::class, 'invoicePaymentStore'])->name('invoice.payment.store');
        Route::delete('invoice/{id}/payment/{pid}/destroy', [InvoiceController::class, 'invoicePaymentDestroy'])->name('invoice.payment.destroy');
        Route::delete('invoice/type/destroy', [InvoiceController::class, 'invoiceTypeDestroy'])->name('invoice.type.destroy');
        Route::get('invoice/{id}/reminder', [InvoiceController::class, 'invoicePaymentRemind'])->name('invoice.reminder');
        Route::post('invoice/{id}/reminder', [InvoiceController::class, 'invoicePaymentRemindData'])->name('invoice.sendEmail');
        Route::resource('invoice', InvoiceController::class);
    }
);

//-------------------------------Expense-------------------------------------------
Route::resource('expense', ExpenseController::class)->middleware(
    [
        'auth',
        'XSS',
    ]
);

//-------------------------------Maintainer-------------------------------------------
Route::resource('maintainer', MaintainerController::class)->middleware(
    [
        'auth',
        'XSS',
    ]
);

//-------------------------------Maintenance Request-------------------------------------------


Route::group(
    [
        'middleware' => [
            'auth',
            'XSS',
        ],
    ],
    function () {
        Route::get('maintenance-request/pending', [MaintenanceRequestController::class, 'pendingRequest'])->name('maintenance-request.pending');
        Route::get('maintenance-request/in-progress', [MaintenanceRequestController::class, 'inProgressRequest'])->name('maintenance-request.inprogress');
        Route::get('maintenance-request/{id}/action', [MaintenanceRequestController::class, 'action'])->name('maintenance-request.action');
        Route::post('maintenance-request/{id}/action', [MaintenanceRequestController::class, 'actionData'])->name('maintenance-request.action');
        Route::resource('maintenance-request', MaintenanceRequestController::class);
        Route::post('maintenance-request/comment/{id}', [MaintenanceRequestController::class, 'comment'])->name('maintenance-request.comment');
        Route::delete('/maintenance-request/comment/{id}', [MaintenanceRequestController::class, 'commentDestroy'])->name('maintenance-request.comment.destroy');
    }
);

//-------------------------------Plan Payment-------------------------------------------

Route::group(
    [
        'middleware' => [
            'auth',
            'XSS',
        ],
    ],
    function () {
        Route::post('subscription/{id}/bank-transfer', [PaymentController::class, 'subscriptionBankTransfer'])->name('subscription.bank.transfer');
        Route::get('subscription/{id}/bank-transfer/action/{status}', [PaymentController::class, 'subscriptionBankTransferAction'])->name('subscription.bank.transfer.action');
        Route::post('subscription/{id}/paypal', [PaymentController::class, 'subscriptionPaypal'])->name('subscription.paypal');
        Route::get('subscription/{id}/paypal/{status}', [PaymentController::class, 'subscriptionPaypalStatus'])->name('subscription.paypal.status');
        Route::get('subscription/flutterwave/{sid}/{tx_ref}', [PaymentController::class, 'subscriptionFlutterwave'])->name('subscription.flutterwave');


        Route::post('/subscription-pay-with-paystack', [PaymentController::class, 'subscriptionPaystack'])->name('subscription.pay.with.paystack')->middleware(['auth', 'XSS']);
        Route::get('/subscription/paystack/{pay_id}/{s_id}', [PaymentController::class, 'subscriptionPaystackStatus'])->name('subscription.paystack');
    }
);

//-------------------------------Reports-------------------------------------------


Route::get('report/income', [ReportController::class, 'income'])->name('report.income');
Route::get('report/expense', [ReportController::class, 'expense'])->name('report.expense');
Route::get('report/profit-loss', [ReportController::class, 'reportProfitLoss'])->name('report.profit_loss');
Route::get('report/property-unit', [ReportController::class, 'reportPropertyUnit'])->name('report.property_unit');
Route::get('report/tenant', [ReportController::class, 'tenant'])->name('report.tenant');
Route::get('report/maintenance', [ReportController::class, 'maintenance'])->name('report.maintenance');


//-------------------------------Agreement-------------------------------------------
Route::resource('agreement', AgreementController::class)->middleware(
    [
        'auth',
        'XSS',
    ]
);

//-------------------------------Amenity-------------------------------------------
Route::resource('amenity', AmenityController::class)->middleware(
    [
        'auth',
        'XSS',
    ]
);

//-------------------------------Advantage-------------------------------------------
Route::resource('advantage', AdvantageController::class)->middleware(
    [
        'auth',
        'XSS',
    ]
);



//-------------------------------Landing Pages-------------------------------------------
// IMPORTANT: These routes must be defined BEFORE resource routes to avoid conflicts
Route::get('/about', function () {
    return view('landing.about-us');
})->name('landing.about');

Route::get('/services', function () {
    return view('landing.services');
})->name('landing.services');

Route::get('/service-details', function () {
    return view('landing.service-details');
})->name('landing.service-details');

Route::get('/service/property-automation', function () {
    return view('landing.service-property-automation');
})->name('landing.service.property-automation');

Route::get('/service/tenant-management', function () {
    return view('landing.service-tenant-management');
})->name('landing.service.tenant-management');

Route::get('/service/rent-billing-automation', function () {
    return view('landing.service-rent-billing');
})->name('landing.service.rent-billing');

Route::get('/service/maintenance-tasks', function () {
    return view('landing.service-maintenance-tasks');
})->name('landing.service.maintenance-tasks');

Route::get('/service/lease-contract-management', function () {
    return view('landing.service-lease-contract');
})->name('landing.service.lease-contract');

Route::get('/service/complete-visibility-reports', function () {
    return view('landing.service-visibility-reports');
})->name('landing.service.visibility-reports');

Route::get('/service/rental-applications', function () {
    return view('landing.service-rental-applications');
})->name('landing.service.rental-applications');

Route::get('/service/rent-reporting', function () {
    return view('landing.service-rent-reporting');
})->name('landing.service.rent-reporting');

Route::get('/service/listing-website', function () {
    return view('landing.service-listing-website');
})->name('landing.service.listing-website');

Route::get('/service/custom-domain', function () {
    return view('landing.service-custom-domain');
})->name('landing.service.custom-domain');

Route::get('/service/lead-tracking', function () {
    return view('landing.service-lead-tracking');
})->name('landing.service.lead-tracking');

Route::get('/service/listing-syndication', function () {
    return view('landing.service-listing-syndication');
})->name('landing.service.listing-syndication');

Route::get('/service/team-management', function () {
    return view('landing.service-team-management');
})->name('landing.service.team-management');

Route::get('/service/email-alerts', function () {
    return view('landing.service-email-alerts');
})->name('landing.service.email-alerts');

Route::get('/team', function () {
    return view('landing.team');
})->name('landing.team');

Route::get('/team-details', function () {
    return view('landing.team-details');
})->name('landing.team-details');

Route::get('/pricing', function () {
    $subscriptions = \App\Models\Subscription::orderBy('package_amount', 'asc')->get();
    return view('landing.pricing', compact('subscriptions'));
})->name('landing.pricing');

Route::get('/faqs', function () {
    return view('landing.faqs');
})->name('landing.faqs');

//-------------------------------Blog Management (Admin) - Must come before landing routes-------------------------------------------
// Blog management for super admin - These routes must be defined BEFORE landing blog routes to avoid conflicts
Route::get('/admin/blog', [BlogController::class, 'index'])->middleware(['auth', 'XSS'])->name('blog.index');
Route::get('/blog/create', [BlogController::class, 'create'])->middleware(['auth', 'XSS'])->name('blog.create');
Route::post('/blog', [BlogController::class, 'store'])->middleware(['auth', 'XSS'])->name('blog.store');
Route::get('/blog/{blog}/edit', [BlogController::class, 'edit'])->middleware(['auth', 'XSS'])->name('blog.edit');
Route::put('/blog/{blog}', [BlogController::class, 'update'])->middleware(['auth', 'XSS'])->name('blog.update');
Route::patch('/blog/{blog}', [BlogController::class, 'update'])->middleware(['auth', 'XSS'])->name('blog.update');
Route::delete('/blog/{blog}', [BlogController::class, 'destroy'])->middleware(['auth', 'XSS'])->name('blog.destroy');

// Landing page blog routes (public)
Route::get('/blog', function () {
    // Get all enabled blogs (super admin blogs have parent_id = 0)
    $query = \App\Models\Blog::where('parent_id', 0)
        ->where('enabled', 1);
    
    // Filter by search term
    if (request()->filled('search')) {
        $searchTerm = request('search');
        $query->where(function($q) use ($searchTerm) {
            $q->where('title', 'like', '%' . $searchTerm . '%')
              ->orWhere('description', 'like', '%' . $searchTerm . '%')
              ->orWhere('content', 'like', '%' . $searchTerm . '%');
        });
    }
    
    // Filter by category
    if (request()->filled('category')) {
        $query->where('category', request('category'));
    }
    
    // Filter by tag
    if (request()->filled('tag')) {
        $tag = request('tag');
        $query->where('tags', 'like', '%' . $tag . '%');
    }
    
    $blogs = $query->latest()->paginate(9);
    return view('landing.blog', compact('blogs'));
})->name('landing.blog');

Route::get('/blog/{slug}', function ($slug) {
    // Skip if slug is a reserved word (like 'create', 'edit', etc.)
    if (in_array($slug, ['create', 'edit'])) {
        abort(404);
    }
    
    // Get super admin blog (parent_id = 0) that is enabled
    $blog = \App\Models\Blog::where('parent_id', 0)
        ->where('enabled', 1)
        ->where('slug', $slug)
        ->firstOrFail();
    
    // Increment views
    $blog->increment('views');

    // Get related blogs (same category, excluding current)
    $relatedBlogs = \App\Models\Blog::where('parent_id', 0)
        ->where('enabled', 1)
        ->where('id', '!=', $blog->id)
        ->where(function($query) use ($blog) {
            if ($blog->category) {
                $query->where('category', $blog->category);
            }
        })
        ->latest()
        ->take(3)
        ->get();

    // If not enough related blogs, get any recent blogs
    if ($relatedBlogs->count() < 3) {
        $additionalBlogs = \App\Models\Blog::where('parent_id', 0)
            ->where('enabled', 1)
            ->where('id', '!=', $blog->id)
            ->whereNotIn('id', $relatedBlogs->pluck('id'))
            ->latest()
            ->take(3 - $relatedBlogs->count())
            ->get();
        $relatedBlogs = $relatedBlogs->merge($additionalBlogs);
    }

    return view('landing.blog-details', compact('blog', 'relatedBlogs'));
})->name('landing.blog-details');

Route::get('/contact', function () {
    return view('landing.contact');
})->name('landing.contact');

Route::get('/error', function () {
    return view('landing.error');
})->name('landing.error');

Route::prefix('web/{code}')->group(function () {
    Route::get('/', [FrontendController::class, 'themePage'])->name('web.page');

    Route::get('/search/location', [FrontendController::class, 'searchLocation'])->name('search.location');

    Route::get('/blog', [FrontendController::class, 'blogPage'])->name('blog.home');
    Route::get('/blog/{slug}', [FrontendController::class, 'blogDetailPage'])->name('blog.detail');

    Route::get('/contact', [FrontendController::class, 'contactPage'])->name('contact.home');

    Route::get('/properties', [FrontendController::class, 'propertyPage'])->name('property.home');
    Route::get('/search/filter', [FrontendController::class, 'search'])->name('search.filter');
    Route::get('/search/package', [FrontendController::class, 'searchpackage'])->name('search.package');

    Route::get('/property/{id}', [FrontendController::class, 'detailPage'])->name('property.detail');

    Route::post('contact-us', [ContactController::class, 'frontDetailStore'])->name('contact-us');

    Route::get('/get-states', [FrontendController::class, 'getStates'])->name('get-states');
    Route::get('/get-cities', [FrontendController::class, 'getCities'])->name('get-cities');

});

//-------------------------------Front Home Page-------------------------------------------
Route::resource('front-home', FrontendController::class)->middleware(
    [
        'auth',
        'XSS',
    ]
);

//-------------------------------Lead Form Fields-------------------------------------------
Route::group(
    [
        'middleware' => [
            'auth',
            'XSS',
        ],
    ],
    function () {
        Route::post('lead-form-field', [FrontendController::class, 'storeLeadField'])->name('lead-form-field.store');
        Route::put('lead-form-field/{id}', [FrontendController::class, 'updateLeadField'])->name('lead-form-field.update');
        Route::delete('lead-form-field/{id}', [FrontendController::class, 'destroyLeadField'])->name('lead-form-field.destroy');
        Route::post('lead-form-field/reorder', [FrontendController::class, 'reorderLeadFields'])->name('lead-form-field.reorder');
    }
);


//-------------------------------Additional Page-------------------------------------------
Route::resource('additional',   AdditionalController::class)->middleware(
    [
        'auth',
        'XSS',
    ]
);





//-------------------------------Invoice Payment-------------------------------------------

Route::group(
    [
        'middleware' => [
            'auth',
            'XSS',
        ],
    ],
    function () {

        Route::post('invoice/{id}/banktransfer/payment', [InvoicePaymentController::class, 'banktransferPayment'])->name('invoice.banktransfer.payment');
        Route::post('invoice/{id}/stripe/payment', [InvoicePaymentController::class, 'stripePayment'])->name('invoice.stripe.payment');
        Route::post('invoice/{id}/paypal', [InvoicePaymentController::class, 'invoicePaypal'])->name('invoice.paypal');
        Route::get('invoice/{id}/paypal/{status}', [InvoicePaymentController::class, 'invoicePaypalStatus'])->name('invoice.paypal.status');
        Route::get('invoice/flutterwave/{id}/{tx_ref}', [InvoicePaymentController::class, 'invoiceFlutterwave'])->name('invoice.flutterwave');

        Route::post('invoice/{id}/paystack/payment', [InvoicePaymentController::class, 'invoicePaystack'])->name('invoice.paystack.payment');
        Route::get('/invoice/paystack/{pay_id}/{i_id}', [InvoicePaymentController::class, 'invoicePaystackStatus'])->name('invoice.paystack');
    }
);


Route::get('page/{slug}', [PageController::class, 'page'])->name('page');
//-------------------------------FAQ-------------------------------------------
Route::impersonate();
