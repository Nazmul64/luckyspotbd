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
use App\Http\Controllers\Backend\AdminkeyapprovedController;
use App\Http\Controllers\Backend\UserlottryController;
use App\Http\Controllers\Backend\WaletaSetupController;
use App\Http\Controllers\Backend\WithdrawcommissonController;
use App\Http\Controllers\Backend\AdminandchatuserController;
use App\Http\Controllers\Backend\AdminsupportemailController;
use App\Http\Controllers\Backend\FaqController;
use App\Http\Controllers\Backend\TestimonialController;
use App\Http\Controllers\Backend\UsertoadminchatController;
use App\Http\Controllers\Backend\WhychooseusticketController;
use App\Http\Controllers\Frontend\AdminDepositeApprovedController;
use App\Http\Controllers\Frontend\DepositeController;
use App\Http\Controllers\Frontend\FrontendAuthController;
use App\Http\Controllers\Frontend\FrontendController;
use App\Http\Controllers\Frontend\KeyController;
use App\Http\Controllers\Frontend\FrontendDashboardController;
use App\Http\Controllers\Frontend\PaswordchangeController;
use App\Http\Controllers\Frontend\UserprofileController;
use App\Http\Controllers\Frontend\WithdrawController;
use App\Http\Controllers\Frontend\LanguageController;
use App\Http\Controllers\Frontend\WinnerListController;
use App\Http\Controllers\Frontend\UserchatController;
use App\Http\Controllers\SupportEmailController;
use App\Models\CommissionSetting;
use Illuminate\Support\Facades\Session;
use App\Models\Deposite;
use App\Models\Whychooseusticket;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


Auth::routes();

// Frontend Routes

Route::get('/', [FrontendController::class, 'frontend'])->name('frontend');
Route::get('contactpages', [FrontendController::class, 'contactpages'])->name('contact.pages');
Route::get('privacy', [FrontendController::class, 'privacy'])->name('privacy.pages');
Route::get('trmsandcondation', [FrontendController::class, 'trmsandcondation'])->name('trmsandcondation');
Route::get('supportcontact', [FrontendController::class, 'supportcontact'])->name('supportcontact');
Route::post('/supportemail', [SupportEmailController::class, 'supportemail'])->name('contact.message');


Route::get('frontend/login', [FrontendAuthController::class, 'frontend_login'])->name('frontend.login');

Route::post('frontend/login/submit', [FrontendAuthController::class, 'frontend_login_submit'])->name('frontend.login.submit');

Route::post('frontend/logout', [FrontendAuthController::class, 'frontend_logout'])->name('frontend.logout');
Route::get('register', [FrontendAuthController::class, 'frontend_register'])->name('frontend.register');
Route::post('register', [FrontendAuthController::class, 'frontend_register_submit'])->name('frontend.register.submit');

// Protect Dashboard (login required)
Route::middleware(['user'])->group(function () {

    Route::get('/get-locale', [LanguageController::class, 'getLocale'])->name('language.locale');
    Route::get('/get-texts', [LanguageController::class, 'getText'])->name('language.get_texts');


// Language Route
Route::post('/language/change', [LanguageController::class, 'changeLanguage'])->name('language.change');

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



   /* User Chat Route Start*/
Route::get('chat/frontend/list', [UserchatController::class, 'frontend_chat_list'])->name('frontend.user.chat.list');
Route::post('chat/frontend/submit', [UserchatController::class, 'frontend_chat_submit'])->name('frontend.user.chat.submit');
Route::get('chat/frontend/messages', [UserchatController::class, 'frontend_chat_messages'])->name('frontend.user.chat.messages');
Route::get('/chat/unread-counts', [UserchatController::class, 'getUnreadCounts'])->name('frontend.user.chat.unread');



Route::get('/usertoadminchat/fetch', [UsertoadminchatController::class, 'fetchMessages'])->name('usertoadminchat.fetch');
Route::post('/usertoadminchat/send', [UsertoadminchatController::class, 'sendMessage'])->name('usertoadminchat.send');
Route::post('/usertoadminchat/mark-read', [UsertoadminchatController::class, 'markRead'])->name('usertoadminchat.markread');
Route::get('/usertoadminchat/unread-count', [UsertoadminchatController::class, 'unreadCount'])->name('usertoadminchat.unreadcount');

Route::get('frontend/key', [KeyController::class, 'frontend_key'])->name('frontend.key');
Route::post('frontend/key', [KeyController::class, 'frontend_key_submit'])->name('frontend.key.submit');



}); // End Protect Dashboard (login required)



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

   // Admin and User Chat Routes
   Route::get('admin/to/user/tochat/list', [AdminandchatuserController::class, 'adminuserchat'])->name('admin.userchat');
   Route::get('admin/to/chat/fetch/{user_id}', [AdminandchatuserController::class, 'fetchMessages'])->name('admin.chat.fetch');
   Route::post('admin/to/chat/send', [AdminandchatuserController::class, 'sendMessage'])->name('admin.chat.send');
   Route::get('admin/to/user/unread', [AdminandchatuserController::class, 'unreadCount'])->name('admin.user.unread');
   Route::post('admin/to/chat/mark-read/{user_id}', [AdminandchatuserController::class, 'markRead'])->name('admin.chat.markread');



  Route::get('contactmessages', [AdminsupportemailController::class, 'contact_messages'])->name('contact.messages');
  Route::get('contactmessagesdelete/{id}', [AdminsupportemailController::class, 'contactmessagesdelete'])->name('contactmessagesdelete');
  Route::resource('whychooseustickets',WhychooseusticketController::class);
  Route::resource('faq',FaqController::class);
  Route::resource('testimonial',TestimonialController::class);
  Route::get('kyc/kyclist', [AdminkeyapprovedController::class,'kyclist'])->name('kyc.list');
  Route::post('kyc/approve/{id}', [AdminkeyapprovedController::class,'approvedkey'])->name('admin.kyc.approve');
  Route::post('kyc/reject/{id}', [AdminkeyapprovedController::class,'rejectapprovedkey'])->name('admin.kyc.reject');


});
// End Admin Auth Routes

