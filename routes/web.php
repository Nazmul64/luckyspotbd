<?php

use App\Http\Controllers\Backend\AboutController;
use App\Http\Controllers\Backend\AdminAuthController;
use App\Http\Controllers\Backend\AdminBlanceController;
use App\Http\Controllers\Backend\AdminController;
use App\Http\Controllers\Backend\AdmindepositeblanceaddController;
use App\Http\Controllers\Backend\AdminpasswordchangeController;
use App\Http\Controllers\Backend\AdminuseraccountviewController;
use App\Http\Controllers\Backend\AdminWithdrawController;
use App\Http\Controllers\Backend\AllTicketController;
use App\Http\Controllers\Backend\CommissionSettingController;
use App\Http\Controllers\Backend\ContactController;
use App\Http\Controllers\Backend\LotterycreateController;
use App\Http\Controllers\Backend\LotteryResultController;
use App\Http\Controllers\Backend\NoticesController;
use App\Http\Controllers\Backend\PrivacypolicyController;
use App\Http\Controllers\Backend\SettingController;
use App\Http\Controllers\Backend\SliderController;
use App\Http\Controllers\Backend\SupportControler;
use App\Http\Controllers\Backend\TermsconditionController;
use App\Http\Controllers\Backend\UserlottryController;
use App\Http\Controllers\Backend\WaletaSetupController;
use App\Http\Controllers\Backend\WithdrawcommissonController;
use App\Http\Controllers\Frontend\AdminDepositeApprovedController;
use App\Http\Controllers\Frontend\DepositeController;
use App\Http\Controllers\Frontend\FrontendAuthController;
use App\Http\Controllers\Frontend\FrontendController;
use App\Http\Controllers\Frontend\FrontendDashboardController;
use App\Http\Controllers\Frontend\PaswordchangeController;
use App\Http\Controllers\Frontend\UserprofileController;
use App\Http\Controllers\Frontend\WithdrawController;
use App\Http\Controllers\Frontend\LanguageController;
use App\Http\Controllers\Frontend\WinnerListController;
use App\Models\CommissionSetting;
use App\Models\Deposite;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


Auth::routes();

// Frontend Routes

Route::get('/', [FrontendController::class, 'frontend'])->name('frontend');


Route::get('frontend/login', [FrontendAuthController::class, 'frontend_login'])->name('frontend.login');

Route::post('frontend/login/submit', [FrontendAuthController::class, 'frontend_login_submit'])->name('frontend.login.submit');

Route::post('frontend/logout', [FrontendAuthController::class, 'frontend_logout'])->name('frontend.logout');
Route::get('frontend/register', [FrontendAuthController::class, 'frontend_register'])->name('frontend.register');
Route::post('frontend/register/submit', [FrontendAuthController::class, 'frontend_register_submit'])->name('frontend.register.submit');

// Protect Dashboard (login required)
Route::middleware(['user'])->group(function () {
    Route::post('/change-language', [LanguageController::class, 'changeLanguage'])->name('language.change');
    Route::get('/get-texts', [LanguageController::class, 'getText'])->name('language.get_texts');
    Route::get('frontend/dashboard', [FrontendDashboardController::class, 'frontend'])->name('frontend.dashboard');
    Route::get('user/deposte', [DepositeController::class, 'deposte_index'])->name('deposte.index');
    Route::post('user/deposte/store', [DepositeController::class, 'store'])->name('frontend.deposit.store');
    Route::post('/buy-package/{packageId}', [UserlottryController::class, 'buyPackage'])->name('buy.package');
  // user profile update route and controller

   Route::get('/profile', [UserprofileController::class, 'profile'])->name('profile.index');
   Route::put('/profile/{id}', [UserprofileController::class, 'updateProfile'])->name('profile.update');
   Route::get('/password', [PaswordchangeController::class, 'password'])->name('password.index');
   Route::post('/password/change', [PaswordchangeController::class, 'passwordchange'])->name('password.change');
  // user profile update route and controller End
   Route::get('Withdraw', [WithdrawController::class, 'Withdraw'])->name('Withdraw.index');
   Route::post('withdraw/submit', [WithdrawController::class, 'submit'])->name('Withdraw.submit');
   Route::get('/all/ticket', [AllTicketController::class, 'ticket'])->name('all.ticket');
   Route::get('/my/ticket', [AllTicketController::class, 'myticket'])->name('my.ticket');
   Route::get('winnerlist', [WinnerListController::class, 'winnerlist'])->name('winnerlist.index');

});


// End Frontend Routes




// Admin Auth Routes
Route::get('admin/login', [AdminAuthController::class, 'admin_login'])->name('admin.login');
Route::post('admin/login/submit', [AdminAuthController::class, 'admin_login_submit'])->name('admin.login.submit');
Route::post('admin/logout', [AdminAuthController::class, 'admin_logout'])->name('admin.logout');





Route::middleware(['admin'])->group(function () {
    Route::get('admin/dashboard', [AdminController::class, 'admin'])->name('admin.dashboard');
    Route::resource('commissionsetting', CommissionSettingController::class);
    Route::resource('withdrawcommisson', WithdrawcommissonController::class);
    Route::get('userlist-for-admin', [AdminController::class, 'userlistadmin'])->name('admin.userlist');
    Route::put('/users/{id}/status', [AdminController::class, 'updateStatus'])->name('users.updateStatus');
    Route::delete('/user/delete/{id}', [AdminController::class, 'userDelete'])->name('user.delete');
    //  admin user account view start
    Route::get('/admin/impersonate/{user}', [AdminuseraccountviewController::class, 'impersonateUser'])->name('admin.impersonate');
    Route::get('/admin/stop-impersonate', [AdminuseraccountviewController::class, 'stopImpersonate'])->name('admin.stopImpersonate');
    // admin user account view end

    // Waleta Setting Route
    Route::resource('waletesetting', WaletaSetupController::class);
    // End Waleta Setting Route


    // Additional admin routes can be added here
     Route::resource('aboutus', AboutController::class);
     // End Additional admin routes
     Route::resource('privacypolicy',PrivacypolicyController::class);
     Route::resource('settings', SettingController::class);
     Route::resource('contact',ContactController::class);
     Route::resource('Termscondition',TermsconditionController::class);
     Route::resource('slider',SliderController::class);
     Route::resource('supportlink',SupportControler::class);
     Route::resource('notices',NoticesController::class);
     Route::get('/admin/user/depositebalances', [AdmindepositeblanceaddController::class, 'adminuserdepositecheck'])->name('admin.depositeblanceadd');
     Route::get('/admin/user/{id}/depositebalances',[AdmindepositeblanceaddController::class, 'depositebalanceEdit'])->name('admin.deposite.edit');
     Route::put('/admin/user/{id}/depositebalances',[AdmindepositeblanceaddController::class, 'depositebalanceUpdate'])->name('admin.deposite.update');
     Route::delete('/admin/user/{id}/delete', [AdmindepositeblanceaddController::class, 'usrdelete'])->name('admin.usrdelete');
     //  admin blance added
     Route::get('/admin/user/balance', [AdminBlanceController::class, 'adminusercheck'])->name('admin.balance.index');
     Route::get('/admin/user/{id}/balance', [AdminBlanceController::class, 'adminBalanceEdit'])->name('admin.balance.edit');
     Route::put('/admin/user/{id}/balance', [AdminBlanceController::class, 'update'])->name('admin.balance.update');
     Route::delete('/admin/user/{id}/delete', [AdminBlanceController::class, 'usrdelete'])->name('admin.usrdelete');
     //  admin blance End
    Route::get('/admin/password/change', [AdminpasswordchangeController::class, 'adminpasswordchange'])->name('adminpassword.change');
    Route::post('/admin/password/change/submit', [AdminpasswordchangeController::class, 'adminpasswordsubmit'])->name('adminpassword.submit');
    Route::get('/admin/profile/change', [AdminpasswordchangeController::class, 'adminProfile'])->name('profile.change');
    Route::put('/admin/profile/{id}', [AdminpasswordchangeController::class, 'adminProfileSubmit'])->name('admin.profile.update');

    Route::post('/deposites/{deposit}/status', [AdminDepositeApprovedController::class, 'updateStatus'])->name('deposites.updateStatus');
    Route::get('/deposites/index', [AdminDepositeApprovedController::class, 'approveindex'])->name('approve.index');
    Route::get('/deposites/delete/{id}', [AdminDepositeApprovedController::class, 'approvedelete'])->name('approve.delete');
    Route::resource('lottery', LotterycreateController::class);
    Route::get('/admin/lottery/statistics', [LotterycreateController::class, 'statistics']) ->name('lottery.statistics');
    // Show withdrawals
    Route::get('admin/withdraw/show', [AdminWithdrawController::class, 'Withdrawshow'])->name('admin.withdraw.show');

    // Approve & Reject
    Route::get('admin/withdraw/approve/{id}', [AdminWithdrawController::class,'approve'])->name('admin.withdraw.approve');
    Route::get('admin/withdraw/reject/{id}', [AdminWithdrawController::class,'reject'])->name('admin.withdraw.reject');

    // Show all purchases
    Route::get('/admin/lottery/purchases', [LotteryResultController::class, 'purchasedTickets'])->name('admin.lottery.purchases');

        // Show form to declare winners
    Route::get('/admin/lottery/{lotteryId}/declare', [LotteryResultController::class, 'showDeclareForm'])->name('admin.lottery.showDeclare');

        // Declare winners
    Route::post('/admin/lottery/{lotteryId}/declare', [LotteryResultController::class, 'declareResult'])->name('admin.lottery.declare');

    Route::resource('theme', \App\Http\Controllers\Backend\ThemeSettingController::class);


});
// End Admin Auth Routes

