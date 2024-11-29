<?php

use App\Http\Controllers\Admin\company\CompanyController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Company\Persons\PersonsController;
use App\Http\Controllers\Admin\Roller\RoleController;
use App\Http\Controllers\Admin\User\UserController;
use App\Http\Controllers\Admin\Language\LanguageController;
use App\Http\Controllers\Admin\Language\TranslationController;
use App\Http\Controllers\api\CarsController as ApiCarsController;
use App\Http\Controllers\Company\Calender\CalenderController;
use App\Http\Controllers\Company\Cars\CarsController;
use App\Http\Controllers\Company\Contracts\ContractsController;
use App\Http\Controllers\api\ContractsController as ApiContractsController;
use App\Http\Controllers\Company\Customers\CustomersController;
use App\Http\Controllers\Company\invoices\InvoiceController;
use App\Http\Controllers\Company\Payment\PaymentController;
use App\Http\Controllers\Company\Punishment\PunishmentController;
use App\Http\Controllers\Company\Settings\SettingsController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\CheckoutController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

//  tek sayfa olucak role göre şekillenicek üye ise üyenin yapabiliceği işlemler

Route::get('/dil/{lang}/', [LanguageController::class, 'switchLang'])->name('change.language');
Route::post('/reset-database', [PageController::class, 'resetDatabase'])->name('reset.database');

Route::get('/book/index', [PageController::class, 'bookPage'])->name('book');
Route::get('/book/detail/{id}', [PageController::class, 'bookDetail'])->name('book.detail');
Route::post('/create-payment-intent', [CheckoutController::class, 'createCheckoutSession'])->name('checkout.session');
Route::get('/book/checkout', [CheckoutController::class, 'CheckoutForm'])->name('checkout.form');
Route::get('/book/success', [CheckoutController::class, 'CheckoutSuccess'])->name('checkout.success');
Route::get('/book/error', [CheckoutController::class, 'CheckoutError'])->name('checkout.error');
Route::get('/book/get-cars-by-group/{groupId}', [ApiContractsController::class, 'getCarsByGroup']);
Route::post('/book/contract/add', [ApiContractsController::class, 'addContract'])->name('book.contract.add');
Route::get('/book/cars-by-company', [ApiCarsController::class, 'getCarsByCompany']);
Route::get('/book/car/groups', [ApiCarsController::class, 'getCarGroupsByCompany']);
Route::get('/book/cars-avability/{id}', [ApiCarsController::class, 'getCarAvailability']);
Route::middleware(['auth'])->group(function () {
    Route::get('kayit-ol/onay-bekleniyor', [PageController::class, 'awaitingApproval'])->name('awaiting.approval');
    // Kullanıcı yetkilendirme kontrolleri için route grubu
    Route::group(['middleware' => ['role_or_permission:Süper Admin']], function () {
        Route::get('/superadmin/dashboard', [HomeController::class, 'SuperAdminDashboard'])->name('home.superadmin');
        Route::get('/roller', [UserController::class, 'roles'])->name('roles');
        Route::get('/rol/ekle', [RoleController::class, 'create'])->name('role.create');
        Route::post('/role/store', [RoleController::class, 'store'])->name('role.store');
        Route::get('/rol/{id}/duzenle', [RoleController::class, 'edit'])->name('roles.edit');
        Route::put('/rol/{id}', [RoleController::class, 'update'])->name('roles.update');
        Route::delete('/rol/{id}', [RoleController::class, 'destroy'])->name('roles.destroy');

        Route::get('/languages', [LanguageController::class, 'languages'])->name('languages');
        Route::get('/languages/language-add', [LanguageController::class, 'LanguageNew'])->name('languages.new');
        Route::post('/languages/new-language', [LanguageController::class, 'LanguageStore'])->name('languages.store');
        Route::get('/languages/language-update/{language}', [LanguageController::class, 'LanguageEdit'])->name('languages.edit');
        Route::put('/languages/language-upp/{language}', [LanguageController::class, 'LanguageUpdate'])->name('languages.update');
        Route::delete('/languages/{language}', [LanguageController::class, 'LanguageDestroy'])->name('languages.destroy');
        Route::get('/languages/{code}/keys', [TranslationController::class, 'index'])->name('languages.translations');
        Route::post('/languages/{code}/key', [TranslationController::class, 'update'])->name('languages.translations.update');

        Route::get('/kullanicilar', [UserController::class, 'users'])->name('users');
        Route::get('/yeni-kullanici', [UserController::class, 'create'])->name('user.create');
        Route::post('/kullanici-ekle', [UserController::class, 'store'])->name('user.store');
        Route::get('/kullanici/{id}/edit', [UserController::class, 'edit'])->name('user.edit');
        Route::put('/kullanici/{id}', [UserController::class, 'update'])->name('user.update');
        Route::post('/sifre-guncelle/{id}', [UserController::class, 'changePassword'])->name('user.change-password');
        Route::delete('/kullanici/{id}/sil', [UserController::class, 'destroy'])->name('user.destroy');
        Route::post('/kullanici/onayla/{id}', [UserController::class, 'approveUser'])->name('user.approve');

        Route::get('/companies', [CompanyController::class, 'companies'])->name('companies');
        Route::get('/company/new-company', [CompanyController::class, 'NewCompany'])->name('companies.new');
        Route::post('/company/company-create', [CompanyController::class, 'AddCompany'])->name('companies.add');
        Route::get('/company/{id}/edit', [CompanyController::class, 'EditCompany'])->name('companies.edit');
        Route::put('/company/{id}/edit', [CompanyController::class, 'UpdateCompany'])->name('companies.update');
        Route::delete('/company/{id}/sil', [CompanyController::class, 'destroy'])->name('companies.destroy');
        Route::post('/company/onayla/{id}', [CompanyController::class, 'approveCompany'])->name('company.approve');
    });
    
    Route::group(['middleware' => ['ensureUserHasCompletedProfile']], function () {
        Route::get('/', [HomeController::class, 'home'])->name('home');
        Route::get('/profile/edit', [PageController::class, 'editProfile'])->name('profile.edit');
        Route::get('/profile/edit', [PageController::class, 'editProfile'])->name('profile.edit');
        Route::put('/profile/edit', [PageController::class, 'upProfile'])->name('profile.update');
        Route::put('/profile/address/edit', [PageController::class, 'upAddressProfile'])->name('profile.address.update');
        Route::put('/profile/image/edit', [PageController::class, 'UserProfilePhotoUpdate'])->name('profile.image.update');
        Route::post('/profile/password/edit', [PageController::class, 'upPasswordProfile'])->name('profile.password.update');
        Route::post('/profile/sign/edit', [PageController::class, 'upSignProfile'])->name('profile.sign.update');

        Route::get('/company/profile', [PageController::class, 'CompanyProfile'])->name('company.profile');

        Route::group(['middleware' => ['role_or_permission:Firmenleiter'],], function () {
            Route::get('/company-admin/dashboard', [HomeController::class, 'CompanyAdminDashboard'])->name('home.company');

            Route::get('/company/profile-edit/{id}/{reference_token}', [PageController::class, 'CompanyProfileEdit'])->name('company.profile.edit');
            Route::put('/company/profile-edit', [PageController::class, 'CompanyProfileUpdate'])->name('company.profile.update');
            Route::put('/company/profile/address-edit', [PageController::class, 'CompanyProfileAddressUpdate'])->name('company.profile.address.update');
            Route::put('/company/profile/profile-image/edit', [PageController::class, 'CompanyProfilePhotoUpdate'])->name('company.profile.photo.update');

            Route::get('/emplooyes/', [PersonsController::class, 'Persons'])->name('persons');
            Route::get('/emplooyes/new-emplooye', [PersonsController::class, 'NewPerson'])->name('persons.new');
            Route::post('/emplooyes/new-emplooye-add', [PersonsController::class, 'AddPerson'])->name('persons.add');
            Route::get('/emplooye/{id}/edit', [PersonsController::class, 'EditPerson'])->name('persons.edit');
            Route::put('/emplooye/{id}', [PersonsController::class, 'UpdatePerson'])->name('persons.update');
            Route::post('/emplooye/sign/{id}', [PersonsController::class, 'SignPerson'])->name('persons.edit-sign');
            Route::post('/emplooye/password-edit/{id}', [PersonsController::class, 'PersonEditPassword'])->name('persons.edit-password');
            Route::post('/emplooye/approved/{id}', [PersonsController::class, 'approveUser'])->name('employee.approve');
            Route::delete('/emplooye/{id}', [PersonsController::class, 'PersonDestroy'])->name('persons.destroy');

            Route::get('/customers/', [CustomersController::class, 'Customers'])->name('customers');
            Route::get('/customers/detail/{id}', [CustomersController::class, 'CustomerDetail'])->name('customers.detail');
            Route::get('/customers/new-customer/', [CustomersController::class, 'CustomerAdd'])->name('customers.add');
            Route::get('/customers/edit/{id}', [CustomersController::class, 'CustomerEdit'])->name('customers.edit');
            Route::post('/customers/add-customer/', [CustomersController::class, 'CustomerStore'])->name('customers.store');
            Route::post('/customers/edit-customer/{id}', [CustomersController::class, 'CustomerUpp'])->name('customers.update');

            Route::get('/cars/', [CarsController::class, 'Cars'])->name('cars');
            Route::get('/cars/detail/{id}', [CarsController::class, 'CarDetail'])->name('cars.detail');
            Route::get('/cars/new-car/', [CarsController::class, 'CarAdd'])->name('cars.add');
            Route::get('/cars/edit-car/{id}', [CarsController::class, 'CarEdit'])->name('cars.edit');
            Route::post('/car/delete/{id}', [CarsController::class, 'CarDelete'])->name('cars.delete');
            Route::post('/car/delete-image', [CarsController::class, 'deleteImage'])->name('car.delete.image');
            Route::post('/cars/create-car/', [CarsController::class, 'CarStore'])->name('cars.store');
            Route::post('/cars/update-car/{id}', [CarsController::class, 'CarUpdate'])->name('cars.update');

            Route::get('/cars/groups/', [CarsController::class, 'CarGroups'])->name('cars.groups');
            Route::get('/cars/new-car-group/', [CarsController::class, 'CarGroupAdd'])->name('cars.group.add');
            Route::get('/cars/edit-car-group/{id}', [CarsController::class, 'CarGroupEdit'])->name('cars.group.edit');
            Route::post('/cars/add-car-group/', [CarsController::class, 'CarGroupStore'])->name('cars.group.store');
            Route::post('/cars/group/update/{id}', [CarsController::class, 'CarGroupUpdate'])->name('cars.group.update');
            Route::post('/cars/group/delete/{id}', [CarsController::class, 'CarGroupDelete'])->name('cars.group.delete');
            Route::post('/cars/copy/{id}', [CarsController::class, 'CarCopy'])->name('cars.copy');

            Route::get('/contracts/', [ContractsController::class, 'Contracts'])->name('contracts');
            Route::post('/contracts/resend/{contract}', [ContractsController::class, 'resendContract'])->name('contracts.resend');
            Route::post('/contract/{id}/cancel', [ContractsController::class, 'cancelContract'])->name('contract.cancel');
            Route::get('/contracts/detail/{id}', [ContractsController::class, 'ContractDetail'])->name('contracts.detail');
            Route::get('/contracts/sign/{id}', [ContractsController::class, 'ContractSign'])->name('contracts.sign');
            Route::post('/contracts/sign/contract/{id}', [ContractsController::class, 'ContractSignStore'])->name('contracts.sign.upp');
            Route::get('/contracts/new-contract/', [ContractsController::class, 'ContractAdd'])->name('contracts.add');
            Route::get('/contracts/deliver-contract/{id}', [ContractsController::class, 'ContractDeliver'])->name('contracts.deliver');
            Route::get('/contracts/pickup-contract/{id}', [ContractsController::class, 'ContractPickup'])->name('contracts.pickup');
            
            Route::post('/contracts/pickup-store/', [ContractsController::class, 'ContractPickupStore'])->name('contracts.pickup.store');

            Route::post('/contracts/create-contract/step-1/', [ContractsController::class, 'ContractStoreStep1'])->name('contracts.store.step1');
            Route::post('/contracts/create-contract/step-2', [ContractsController::class, 'ContractStoreStep2'])->name('contracts.store.step2');
            Route::post('/contracts/create-contract/step-3', [ContractsController::class, 'ContractStoreStep3'])->name('contracts.store.step3');
            Route::post('/contracts/create-contract/step-4', [ContractsController::class, 'ContractStoreStep4'])->name('contracts.store.step4');

            Route::post('/contracts/create-contract/back-step-1', [ContractsController::class, 'ContractStoreBackStep1'])->name('contracts.store.back.step1');
            Route::post('/contracts/create-contract/back-step-2', [ContractsController::class, 'ContractStoreBackStep2'])->name('contracts.store.back.step2');
            Route::post('/contracts/create-contract/back-step-3', [ContractsController::class, 'ContractStoreBackStep3'])->name('contracts.store.back.step3');

            Route::post('/contracts/create-contract/deliver/step-1/', [ContractsController::class, 'ContractDeliverStoreStep1'])->name('contracts.deliver.store.step1');
            Route::post('/contracts/create-contract/deliver/step-2', [ContractsController::class, 'ContractDeliverStoreStep2'])->name('contracts.deliver.store.step2');
            Route::post('/contracts/create-contract/deliver/step-3', [ContractsController::class, 'ContractDeliverStoreStep3'])->name('contracts.deliver.store.step3');
            Route::post('/contracts/create-contract/deliver/step-4', [ContractsController::class, 'ContractDeliverStoreStep4'])->name('contracts.deliver.store.step4');

            Route::post('/contracts/create-contract/deliver/back-step-2', [ContractsController::class, 'ContractDeliverStoreBackStep1'])->name('contracts.deliver.store.back.step2');
            Route::post('/contracts/create-contract/deliver/back-step-3', [ContractsController::class, 'ContractDeliverStoreBackStep2'])->name('contracts.deliver.store.back.step3');
            Route::post('/contracts/create-contract/deliver/back-step-4', [ContractsController::class, 'ContractDeliverStoreBackStep3'])->name('contracts.deliver.store.back.step4');

            Route::post('/contracts/deliver/store/without-signature', [ContractsController::class, 'ContractStoreWithoutSignature'])->name('contracts.deliver.store.withoutSignature');
            Route::get('/contracts/extra-date/{id}', [ContractsController::class, 'ContractExtraDate'])->name('contracts.extradate');
            Route::post('/contracts/ex-date/', [ContractsController::class, 'ContractExtraDateSend'])->name('contracts.extradate.send');
            Route::get('/contracts/pdf/{id}', [ContractsController::class, 'ContractPdf'])->name('contracts.pdf');

            
            Route::post('/contracts/remove-damage', [ContractsController::class, 'removeDamage'])->name('contracts.remove.damage');

            Route::get('/invoices', [InvoiceController::class, 'Invoices'])->name('invoices');
            Route::get('/invoices/add/{id}', [InvoiceController::class, 'InvoiceAdd'])->name('contracts.invoice');
            Route::post('/invoices/new', [InvoiceController::class, 'addInvoice'])->name('invoices.add');
            Route::get('/invoices/show/{id}', [InvoiceController::class, 'InvoiceShow'])->name('invoices.show');
            Route::post('/invoices/resend/{invoice}', [InvoiceController::class, 'resendInvoice'])->name('invoices.resend');
            Route::post('/invoices/payment/{invoice}', [InvoiceController::class, 'PaymentInvoice'])->name('invoices.payment');
            Route::post('/invoices/approved/{invoice}', [InvoiceController::class, 'ApprovedInvoice'])->name('invoices.approved');
            Route::post('/invoices/cancelled/{invoice}', [InvoiceController::class, 'CancelledInvoice'])->name('invoices.cancelled');
            Route::get('/invoices/download/{invoice}', [InvoiceController::class, 'downloadInvoice'])->name('invoices.download');

            Route::get('/invoices/manuel-add/', [InvoiceController::class, 'ManuelInvoice'])->name('invoices.manuel.add');
            Route::post('/invoices/manuel-store/', [InvoiceController::class, 'ManuelInvoiceAdd'])->name('invoices.manuel.store');

            Route::get('/get-cars-by-group/{groupId}', [ContractsController::class, 'getCarsByGroup']);
            Route::get('/calendar/', [CalenderController::class, 'Calender'])->name('calender');
            Route::get('/calendar/events', [CalenderController::class, 'CalenderEvents']);
            Route::post('/api/stripe/', [PaymentController::class, 'handlePost'])->name('checkout.stripe');

            Route::get('/contracts/{id}', [PunishmentController::class, 'getContract']);
            Route::get('/company/punishment/{id}/', [PunishmentController::class, 'Punishment'])->name('company.punishment');
            Route::get('/company/punishments/', [PunishmentController::class, 'Punishments'])->name('punishments');
            Route::post('/company/punishment/created', [PunishmentController::class, 'PunishmentStore'])->name('punishment.store');

            Route::get('/company/mail-setting/{id}/', [SettingsController::class, 'MailSetting'])->name('company.mail.settings');
            Route::post('/settings', [SettingsController::class, 'update'])->name('settings.update');

            Route::get('/api/contractData/{interval}', [PageController::class, 'getContractData'])->name('contract-data');


        });
        
    });
});

Auth::routes();
