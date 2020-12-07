<?php

use App\Http\Controllers\Accounting\MoneyTransactionsController;
use App\Http\Controllers\Accounting\GlobalSummaryController;
use App\Http\Controllers\Accounting\SummaryController;
use App\Http\Controllers\Accounting\WalletController;
use App\Http\Controllers\Accounting\WeblingApiController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Badges\BadgeMakerController;
use App\Http\Controllers\Bank\CodeCardController;
use App\Http\Controllers\Bank\CouponTypesController;
use App\Http\Controllers\Bank\ImportExportController;
use App\Http\Controllers\Bank\MaintenanceController;
use App\Http\Controllers\Bank\PeopleController as BankPeopleController;
use App\Http\Controllers\People\PeopleController;
use App\Http\Controllers\ChangelogController;
use App\Http\Controllers\Collaboration\ArticleController;
use App\Http\Controllers\Collaboration\SearchController;
use App\Http\Controllers\Collaboration\TagController;
use App\Http\Controllers\CommunityVolunteers\ExportController;
use App\Http\Controllers\CommunityVolunteers\ImportController;
use App\Http\Controllers\CommunityVolunteers\ListController;
use App\Http\Controllers\CommunityVolunteers\ResponsibilitiesController;
use App\Http\Controllers\Fundraising\FundraisingController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Library\LibraryController;
use App\Http\Controllers\PrivacyPolicy;
use App\Http\Controllers\Settings\SettingsController;
use App\Http\Controllers\UserManagement\RoleController;
use App\Http\Controllers\UserManagement\UserController;
use App\Http\Controllers\UserManagement\UserProfileController;
use Illuminate\Support\Facades\Route;

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

Route::middleware('language')->group(function () {

    Route::middleware('auth')->group(function () {
        // Home (Dashboard)
        Route::get('/', [HomeController::class, 'index'])
            ->name('home');

        // Reporting
        Route::view('reporting', 'reporting.index')
            ->name('reporting.index')
            ->middleware('can:view-reports');
    });

    // Authentication
    Auth::routes();

    $socialite_drivers = config('auth.socialite.drivers');
    Route::get('login/{driver}/redirect', [LoginController::class, 'redirectToProvider'])
        ->name('login.provider')
        ->where('driver', implode('|', $socialite_drivers));
    Route::get('login/{driver}/callback', [LoginController::class, 'handleProviderCallback'])
        ->name('login.callback')
        ->where('driver', implode('|', $socialite_drivers));

    // Privacy policy
    Route::get('userPrivacyPolicy', [PrivacyPolicy::class, 'userPolicy'])
        ->name('userPrivacyPolicy');

    // Settings
    Route::get('settings', [SettingsController::class, 'edit'])
        ->name('settings.edit');
    Route::put('settings', [SettingsController::class, 'update'])
        ->name('settings.update');
});

//
// User management
//
Route::middleware(['auth', 'language'])
    ->group(function () {

        // User management
        Route::prefix('admin')
            ->group(function () {
                // Users
                Route::put('users/{user}/disable2FA', [UserController::class, 'disable2FA'])
                    ->name('users.disable2FA');
                Route::put('users/{user}/disableOAuth', [UserController::class, 'disableOAuth'])
                    ->name('users.disableOAuth');
                Route::resource('users', UserController::class);

                // Roles
                Route::get('roles/{role}/members', [RoleController::class, 'manageMembers'])
                    ->name('roles.manageMembers');
                Route::put('roles/{role}/members', [RoleController::class, 'updateMembers'])
                    ->name('roles.updateMembers');
                Route::resource('roles', RoleController::class);

                // Reporting
                Route::group(['middleware' => ['can:view-usermgmt-reports']], function () {
                    Route::get('reporting/users/permissions', [UserController::class, 'permissions'])
                        ->name('users.permissions');
                    Route::get('reporting/users/sensitiveData', [UserController::class, 'sensitiveDataReport'])
                        ->name('reporting.privacy');
                    Route::get('reporting/roles/permissions', [RoleController::class, 'permissions'])
                        ->name('roles.permissions');
                });
            });

        // User profile
        Route::get('userprofile', [UserProfileController::class, 'index'])
            ->name('userprofile');
        Route::post('userprofile', [UserProfileController::class, 'update'])
            ->name('userprofile.update');
        Route::post('userprofile/updatePassword', [UserProfileController::class, 'updatePassword'])
            ->name('userprofile.updatePassword');
        Route::delete('userprofile', [UserProfileController::class, 'delete'])
            ->name('userprofile.delete');
        Route::get('userprofile/2FA', [UserProfileController::class, 'view2FA'])
            ->name('userprofile.view2FA');
        Route::post('userprofile/2FA', [UserProfileController::class, 'store2FA'])
            ->name('userprofile.store2FA');
        Route::delete('userprofile/2FA', [UserProfileController::class, 'disable2FA'])
            ->name('userprofile.disable2FA');
    });

Route::get('users/{user}/avatar', [UserController::class, 'avatar'])
    ->name('users.avatar');

//
// Changelog
//

Route::middleware(['language'])
    ->group(function () {
        Route::get('changelog', [ChangelogController::class, 'index'])
            ->name('changelog');
    });

//
// Badges
//
Route::middleware(['language', 'auth'])
    ->name('badges.')
    ->prefix('badges')
    ->group(function () {
        Route::middleware(['can:create-badges'])
            ->group(function () {
                Route::get('/', [BadgeMakerController::class, 'index'])
                    ->name('index');
                Route::post('selection', [BadgeMakerController::class, 'selection'])
                    ->name('selection');
                Route::post('make', [BadgeMakerController::class, 'make'])
                    ->name('make');
            });
    });

//
// Fundraising
//

Route::middleware(['language', 'auth'])
    ->prefix('fundraising')
    ->name('fundraising.')
    ->group(function () {
        // SPA
        Route::get('', [FundraisingController::class, 'index'])
            ->name('index');
        Route::get('/{any}', [FundraisingController::class, 'index'])
            ->where('any', '.*');
    });

//
// Accounting
//

Route::middleware(['language', 'auth'])
    ->prefix('accounting')
    ->name('accounting.')
    ->group(function () {

        // Overview
        Route::get('', [WalletController::class, 'index'])
            ->name('index');
        Route::get('transactions/summary', [GlobalSummaryController::class, 'summary'])
            ->name('transactions.globalSummary');

        // Transactions
        Route::get('wallets/{wallet}/transactions/export', [MoneyTransactionsController::class, 'export'])
            ->name('transactions.export');
        Route::post('wallets/{wallet}/transactions/doExport', [MoneyTransactionsController::class, 'doExport'])
            ->name('transactions.doExport');
        Route::get('wallets/{wallet}/transactions/summary', [SummaryController::class, 'summary'])
            ->name('transactions.summary');
        Route::put('transactions/{transaction}/undoBooking', [MoneyTransactionsController::class, 'undoBooking'])
            ->name('transactions.undoBooking');
        Route::get('wallets/{wallet}/transactions', [MoneyTransactionsController::class, 'index'])
            ->name('transactions.index');
        Route::get('wallets/{wallet}/transactions/create', [MoneyTransactionsController::class, 'create'])
            ->name('transactions.create');
        Route::post('wallets/{wallet}/transactions', [MoneyTransactionsController::class, 'store'])
            ->name('transactions.store');
        Route::get('transactions/{transaction}', [MoneyTransactionsController::class, 'show'])
            ->name('transactions.show');
        Route::get('transactions/{transaction}/edit', [MoneyTransactionsController::class, 'edit'])
            ->name('transactions.edit');
        Route::put('transactions/{transaction}', [MoneyTransactionsController::class, 'update'])
            ->name('transactions.update');
        Route::delete('transactions/{transaction}', [MoneyTransactionsController::class, 'destroy'])
            ->name('transactions.destroy');

        // Webling
        Route::get('wallets/{wallet}/webling', [WeblingApiController::class, 'index'])
            ->name('webling.index');
        Route::get('wallets/{wallet}/webling/prepare', [WeblingApiController::class, 'prepare'])
            ->name('webling.prepare');
        Route::post('wallets/{wallet}/webling', [WeblingApiController::class, 'store'])
            ->name('webling.store');
        Route::get('wallets/{wallet}/webling/sync', [WeblingApiController::class, 'sync'])
            ->name('webling.sync');

        // Wallets
        Route::view('wallets', 'accounting.wallets')
            ->name('wallets');
        Route::view('wallets/{any}', 'accounting.wallets')
            ->where('any', '.*')
            ->name('wallets.any');

        // Suppliers
        Route::view('suppliers', 'accounting.suppliers')
            ->name('suppliers');
        Route::view('suppliers/{supplier}', 'accounting.suppliers')
            ->name('suppliers.show');
        Route::view('suppliers/{any}', 'accounting.suppliers')
            ->where('any', '.*')
            ->name('suppliers.any');
    });

//
// Collaboration
//

Route::middleware(['language'])
    ->prefix('kb')
    ->name('kb.')
    ->group(function () {
        Route::group(['middleware' => ['auth']], function () {
            Route::get('', [SearchController::class, 'index'])
                ->name('index');
            Route::get('latest_changes', [SearchController::class, 'latestChanges'])
                ->name('latestChanges');

            Route::get('tags', [TagController::class, 'tags'])
                ->name('tags');
            Route::get('tags/{tag}/pdf', [TagController::class, 'pdf'])
                ->name('tags.pdf');

            Route::get('articles/{article}/pdf', [ArticleController::class, 'pdf'])
                ->name('articles.pdf');
            Route::resource('articles', ArticleController::class)
                ->except('show');
        });
        Route::get('tags/{tag}', [TagController::class, 'tag'])
            ->name('tag');
        Route::resource('articles', ArticleController::class)
            ->only('show');
    });

//
// People
//

Route::middleware(['auth', 'language'])
    ->group(function () {

        // People
        Route::get('people/bulkSearch', [PeopleController::class, 'bulkSearch'])
            ->name('people.bulkSearch')
            ->middleware('can:viewAny,App\Models\People\Person');
        Route::post('people/bulkSearch', [PeopleController::class, 'doBulkSearch'])
            ->name('people.doBulkSearch')
            ->middleware('can:viewAny,App\Models\People\Person');
        Route::get('people/export', [PeopleController::class, 'export'])
            ->name('people.export')
            ->middleware('can:export,App\Models\People\Person');
        Route::get('people/import', [PeopleController::class, 'import'])
            ->name('people.import')
            ->middleware('can:create,App\Models\People\Person');
        Route::post('people/doImport', [PeopleController::class, 'doImport'])
            ->name('people.doImport')
            ->middleware('can:create,App\Models\People\Person');
        Route::get('people/duplicates', [PeopleController::class, 'duplicates'])
            ->name('people.duplicates');
        Route::post('people/duplicates', [PeopleController::class, 'applyDuplicates'])
            ->name('people.applyDuplicates');
        Route::resource('people', PeopleController::class);

        // Reporting
        Route::prefix('reporting')
            ->middleware(['can:view-people-reports'])
            ->group(function () {

                // Monthly summary report
                Route::view('monthly-summary', 'people.reporting.monthly-summary')
                    ->name('reporting.monthly-summary');

                // People report
                Route::view('people', 'people.reporting.people')
                    ->name('reporting.people');
            });
    });

//
// Bank
//

Route::middleware(['auth', 'language'])
    ->group(function () {

        Route::prefix('bank')
            ->name('bank.')
            ->group(function () {

                // Withdrawals
                Route::middleware('can:do-bank-withdrawals')
                    ->group(function () {

                        Route::redirect('', 'bank/withdrawal')
                            ->name('index');

                        Route::view('withdrawal', 'bank.withdrawal.search')
                            ->name('withdrawal.search');

                        Route::view('withdrawal/transactions', 'bank.withdrawal.transactions')
                            ->name('withdrawal.transactions')
                            ->middleware('can:viewAny,App\Models\People\Person');

                        Route::get('codeCard', [CodeCardController::class, 'create'])
                            ->name('prepareCodeCard');

                        Route::post('codeCard', [CodeCardController::class, 'download'])
                            ->name('createCodeCard');
                    });

                // People
                Route::resource('people', BankPeopleController::class)
                    ->except(['index', 'store', 'update']);

                // Maintenance
                Route::middleware('can:cleanup,App\Models\People\Person')
                    ->group(function () {
                        Route::get('maintenance', [MaintenanceController::class, 'maintenance'])
                            ->name('maintenance');
                        Route::post('maintenance', [MaintenanceController::class, 'updateMaintenance'])
                            ->name('updateMaintenance');
                    });

                // Export
                Route::middleware('can:export,App\Models\People\Person')
                    ->group(function () {
                        Route::get('export', [ImportExportController::class, 'export'])
                            ->name('export');
                        Route::post('doExport', [ImportExportController::class, 'doExport'])
                            ->name('doExport');
                    });
            });

        // Coupons
        Route::middleware('can:configure-bank')
            ->prefix('bank')
            ->group(function () {
                Route::resource('coupons', CouponTypesController::class);
            });

        // Reporting
        Route::middleware('can:view-bank-reports')
            ->name('reporting.bank.')
            ->prefix('reporting/bank')
            ->group(function () {
                Route::view('withdrawals', 'bank.reporting.withdrawals')
                    ->name('withdrawals');
                Route::view('visitors', 'bank.reporting.visitors')
                    ->name('visitors');
            });
    });

//
// Community volunteers
//

Route::middleware(['auth', 'language'])
    ->group(function () {
        Route::redirect('helpers', 'cmtyvol');
        Route::name('cmtyvol.')
            ->prefix('cmtyvol')
            ->group(function () {

                // Overview
                Route::view('overview', 'cmtyvol.overview')
                    ->name('overview')
                    ->middleware('can:viewAny,App\Models\CommunityVolunteers\CommunityVolunteer');

                // Report view
                Route::view('report', 'cmtyvol.report')
                    ->name('report')
                    ->middleware('can:viewAny,App\Models\CommunityVolunteers\CommunityVolunteer');

                // Export view
                Route::get('export', [ExportController::class, 'export'])
                    ->name('export')
                    ->middleware('can:export,App\Models\CommunityVolunteers\CommunityVolunteer');

                // Export download
                Route::post('doExport', [ExportController::class, 'doExport'])
                    ->name('doExport')
                    ->middleware('can:export,App\Models\CommunityVolunteers\CommunityVolunteer');

                // Import view
                Route::get('import', [ImportController::class, 'import'])
                    ->name('import')
                    ->middleware('can:import,App\Models\CommunityVolunteers\CommunityVolunteer');

                // Import upload
                Route::post('doImport', [ImportController::class, 'doImport'])
                    ->name('doImport')
                    ->middleware('can:import,App\Models\CommunityVolunteers\CommunityVolunteer');

                // Download vCard
                Route::get('{cmtyvol}/vcard', [ExportController::class, 'vcard'])
                    ->name('vcard');

                // Responsibilities resource
                Route::resource('responsibilities', ResponsibilitiesController::class)
                    ->except('show');
            });

        // Community volunteers resource
        Route::resource('cmtyvol', ListController::class);
    });

//
// Library
//

Route::middleware(['auth', 'language', 'can:operate-library'])
    ->prefix('library')
    ->name('library.')
    ->group(function () {
        // SPA
        Route::get('', [LibraryController::class, 'index'])
            ->name('index');
        Route::get('/{any}', [LibraryController::class, 'index'])
            ->where('any', '.*');
    });

//
// Shop
//

Route::middleware(['auth', 'language'])
    ->prefix('shop')
    ->name('shop.')
    ->group(function () {
        Route::middleware(['can:validate-shop-coupons'])
            ->group(function () {
                Route::view('/', 'shop.index')
                    ->name('index');
                Route::view('manageCards', 'shop.manageCards')
                    ->name('manageCards');
            });
    });

//
// Visitors
//
Route::middleware(['auth', 'language'])
    ->prefix('visitors')
    ->name('visitors.')
    ->group(function () {
        // TODO authorization
        Route::view('', 'visitors.index')
            ->name('index');
        Route::view('/{any}', 'visitors.index')
            ->where('any', '.*')
            ->name('any');
    });

Route::group(['prefix' => 'laravel-filemanager', 'middleware' => ['web', 'auth']], function () {
    \UniSharp\LaravelFilemanager\Lfm::routes();
});
