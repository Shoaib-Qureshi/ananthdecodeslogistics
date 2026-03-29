<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\CheckUserLog;
use App\Http\Controllers\Front\HomeController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Admin\BlogController;
use App\Http\Controllers\Front\ArticleController;
use App\Http\Controllers\Admin\BoardInsightsController;
use App\Http\Controllers\Admin\PageContentController;
use App\Http\Controllers\Contributor\ContributorRegistrationController;
use App\Http\Controllers\Contributor\GuestAuthController;
use App\Http\Controllers\Contributor\GuestPostController;
use App\Http\Controllers\Admin\AdminContributorController;
use App\Http\Controllers\Front\ContributorBlogController;
use Illuminate\Support\Facades\Password;

// ********************** SUPER ADMIN *****************************
Route::get('admin/adl-login',[AdminController::class,'showAdminLogin'])->name('showAdminLogin');
Route::post('admin/admin-login',[AdminController::class,'login'])->name('adminloginRequest');
Route::post('admin/logout',[AdminController::class,'logOut'])->name('adminLogout');

Route::middleware([admin::class])->group(function () {
    Route::get('admin/dashboard',[AdminController::class,'showDashboard'])->name('admin.dashboard');
    Route::get('admin/messages',[AdminController::class,'messages'])->name('messages');
    Route::get('admin/users-list',[AdminController::class,'usersList'])->name('usersList');
    Route::post('admin/delete-user/{id}',[AdminController::class,'deleteUser'])->name('admin.users.delete');
    
    Route::get('admin/add-user',[AdminController::class,'addUser'])->name('addUser');
    Route::post('admin/save-user',[AdminController::class,'saveUser'])->name('saveUser');
    Route::get('admin/edit/user/{id}',[AdminController::class,'editUser']);
    Route::post('admin/update/user/{id}',[AdminController::class,'updateUser']);

    Route::get('admin/create-blog',[BlogController::class,'createBlog']);
    Route::post('admin/save-blog/',[BlogController::class,'saveBlog'])->name('saveBlog');
    Route::post('admin/image_upload', [BlogController::class, 'upload'])->name('upload');
    Route::get('admin/live-blogs',[BlogController::class,'liveBlogs'])->name('admin/blogs-list');
    Route::get('admin/draft-blogs',[BlogController::class,'draftBlogs'])->name('admin/draft-posts');
    Route::get('admin/edit/blog/{id}',[BlogController::class,'editBlog']);
    Route::post('admin/update/blog/{id}',[BlogController::class,'updateBlog']);
    Route::get('admin/delete/blog/{id}',[BlogController::class,'deleteBlog']); 
    Route::post('admin/delete/blog/{id}',[BlogController::class,'deleteBlog'])->name('admin.blogs.delete');

    Route::get('admin/add-book-review',[BlogController::class,'addBookReview']);
    Route::post('admin/save-book-review/',[BlogController::class,'saveBookReview'])->name('saveBookReview');
    Route::get('admin/book-reviews',[BlogController::class,'bookReviewList'])->name('bookReviewList');
    Route::get('admin/edit/book-review/{id}',[BlogController::class,'editBookReview']);
    Route::post('admin/update/book-review/{id}',[BlogController::class,'updatedBookReview']);
    
    Route::get('admin/add-member',[AdminController::class,'addMember'])->name('addMember');
    Route::post('admin/save-member',[AdminController::class,'saveMember'])->name('saveMember');
    Route::get('admin/members-list',[AdminController::class,'listMember'])->name('listMember');
    Route::get('admin/edit-member/{id}',[AdminController::class,'editMember'])->name('editMember');
    Route::post('admin/update-member/{id}',[AdminController::class,'updateMember'])->name('updateMember');
    Route::get('admin/delete-member/{id}',[AdminController::class,'deleteMember'])->name('deleteMember');
    
    Route::get('admin/create-insight',[BoardInsightsController::class,'createInsight']);
    Route::post('admin/save-insight/',[BoardInsightsController::class,'saveInsight'])->name('saveInsight');
    Route::get('admin/live-insights',[BoardInsightsController::class,'liveInsight']);
    Route::get('admin/edit/insight/{id}',[BoardInsightsController::class,'editInsight']);
    Route::post('admin/update/insight/{id}',[BoardInsightsController::class,'updateInsight']);
    Route::get('admin/delete/insight/{id}',[BoardInsightsController::class,'deleteInsight']);

    Route::get('admin/edit-home-page',[PageContentController::class,'editHomePage'])->name('editHomePage');
    Route::post('admin/update-home-page',[PageContentController::class,'updateHomePage'])->name('updateHomePage');
    Route::get('admin/edit-about-page',[PageContentController::class,'editAboutPage'])->name('editAboutPage');
    Route::post('admin/update-about-page',[PageContentController::class,'updateAboutPage'])->name('updateAboutPage');
    Route::get('admin/manage-milestones',[PageContentController::class,'manageMilestones'])->name('manageMilestones');
    Route::get('admin/add-milestone',[PageContentController::class,'addMilestone'])->name('addMilestone');
    Route::post('admin/save-milestone',[PageContentController::class,'saveMilestone'])->name('saveMilestone');
    Route::get('admin/edit-milestone/{id}',[PageContentController::class,'editMilestone'])->name('editMilestone');
    Route::post('admin/update-milestone/{id}',[PageContentController::class,'updateMilestone'])->name('updateMilestone');
    Route::get('admin/delete-milestone/{id}',[PageContentController::class,'deleteMilestone'])->name('deleteMilestone');

    // ── Contributor Registrations (admin manages) ────────────────
    Route::get('admin/registrations', [AdminContributorController::class, 'registrations'])->name('admin.registrations');
    Route::post('admin/registrations/{id}/approve', [AdminContributorController::class, 'approveRegistration'])->name('admin.registrations.approve');
    Route::post('admin/registrations/{id}/reject', [AdminContributorController::class, 'rejectRegistration'])->name('admin.registrations.reject');

    // ── Contributor Posts (admin manages) ────────────────────────
    Route::get('admin/contributor-posts', [AdminContributorController::class, 'posts'])->name('admin.contributor.posts');
    Route::get('admin/contributor-posts/{id}/edit', [AdminContributorController::class, 'editPost'])->name('admin.contributor.posts.edit');
    Route::post('admin/contributor-posts/{id}/update', [AdminContributorController::class, 'updatePost'])->name('admin.contributor.posts.update');
    Route::post('admin/contributor-posts/{id}/approve', [AdminContributorController::class, 'approvePost'])->name('admin.contributor.posts.approve');
    Route::post('admin/contributor-posts/{id}/reject', [AdminContributorController::class, 'rejectPost'])->name('admin.contributor.posts.reject');
    Route::post('admin/contributor-posts/{id}/delete', [AdminContributorController::class, 'deletePost'])->name('admin.contributor.posts.delete');
});

// ********************** SUPER ADMIN END *************************

// ─── Password Reset (for contributors set-password flow) ─────────────────
Route::get('password/reset', fn() => view('auth.passwords.email'))->name('password.request');
Route::post('password/email', function(\Illuminate\Http\Request $request) {
    $request->validate(['email' => 'required|email']);
    $status = Password::sendResetLink($request->only('email'));
    return $status === Password::RESET_LINK_SENT
        ? back()->with('status', __($status))
        : back()->withErrors(['email' => __($status)]);
})->name('password.email');
Route::get('password/reset/{token}', fn($token) => view('auth.passwords.reset', ['token' => $token]))->name('password.reset');
Route::post('password/reset', function(\Illuminate\Http\Request $request) {
    $request->validate([
        'token'    => 'required',
        'email'    => 'required|email',
        'password' => 'required|confirmed|min:8',
    ]);
    $status = Password::reset($request->only('email', 'password', 'password_confirmation', 'token'), function ($user, $password) {
        $user->forceFill(['password' => bcrypt($password)])->save();
    });
    return $status === Password::PASSWORD_RESET
        ? redirect('/contributor-login')->with('success', 'Password set successfully. Please log in.')
        : back()->withErrors(['email' => __($status)]);
})->name('password.update');

// *********************** User Authentication ***********************
// Route::get('signup',[AuthController::class,'userSignup'])->name('userSignup');
// Route::post('user-signup', [AuthController::class, 'saveSignup'])->name('saveSignup');
// Route::get('login',[AuthController::class,'userLogin'])->name('userLogin');
// Route::post('user-login', [AuthController::class, 'postLogin'])->name('postLogin');
// Route::get('logout', [AuthController::class, 'logout'])->name('logout')->middleware('CheckUserLog');
// Route::get('user/verify/{token}', [AuthController::class, 'verifyEmail'])->name('verifyEmail');
// Route::get('forget-password', [AuthController::class, 'showForgetPasswordForm'])->name('forget.password.get');
// Route::post('forget-password', [AuthController::class, 'submitForgetPasswordForm'])->name('forget.password.post'); 
// Route::get('reset-password/{token}', [AuthController::class, 'showResetPasswordForm'])->name('reset.password.get');
// Route::post('reset-password', [AuthController::class, 'submitResetPasswordForm'])->name('reset.password.post');

// ─── Contributor Registration (public) ───────────────────────────────────
Route::get('write-for-us', [ContributorRegistrationController::class, 'showForm'])->name('contributor.register');
Route::post('write-for-us', [ContributorRegistrationController::class, 'submit'])->name('contributor.register.submit');

// ─── Guest Auth ───────────────────────────────────────────────────────────
Route::get('contributor-login', [GuestAuthController::class, 'showLogin'])->name('contributor.login');
Route::post('contributor-login', [GuestAuthController::class, 'login'])->name('contributor.login.submit');
Route::post('contributor-logout', [GuestAuthController::class, 'logout'])->name('contributor.logout');

// ─── Guest Dashboard ──────────────────────────────────────────────────────
Route::middleware(['guest.contributor'])->prefix('dashboard')->group(function () {
    Route::get('/', [GuestPostController::class, 'index'])->name('dashboard');
    Route::get('/posts', [GuestPostController::class, 'index'])->name('dashboard.posts');
    Route::get('/posts/create', [GuestPostController::class, 'create'])->name('dashboard.posts.create');
    Route::post('/posts', [GuestPostController::class, 'store'])->name('dashboard.posts.store');
    Route::get('/posts/{id}/edit', [GuestPostController::class, 'edit'])->name('dashboard.posts.edit');
    Route::post('/posts/{id}', [GuestPostController::class, 'update'])->name('dashboard.posts.update');
});

// ─── Public Blog (admin/Ananthakrishnan posts only) ───────────────────────
Route::get('blog', [ContributorBlogController::class, 'blog'])->name('blog.index');
Route::get('blog/{slug}', [ContributorBlogController::class, 'showBlog'])->name('blog.show');

// ─── Public Contributors Posts ────────────────────────────────────────────
Route::get('contributors', [ContributorBlogController::class, 'contributors'])->name('contributors.index');
Route::get('contributors/{slug}', [ContributorBlogController::class, 'showContributor'])->name('contributors.show');

// *********************** Front Routes ***********************
Route::get('/',[HomeController::class,'homePage']);
Route::get('about-us',[HomeController::class,'aboutUs']);
Route::get('privacy-policy',[HomeController::class,'privacyPolicy']);
Route::get('terms-and-conditions',[HomeController::class,'termsConditions']);
Route::get('contact-us',[HomeController::class,'contactUs']);
Route::post('save-contact',[HomeController::class,'saveContact'])->name('saveContact');
Route::get('disclaimer',[HomeController::class,'disclaimer']);
Route::redirect('contribute-a-guest-post', 'write-for-us', 301);
// Route::get('blog',[ArticleController::class,'allPost']); // replaced by blog.index route above

Route::get('topic/{slug}',[ArticleController::class,'categoryPage']);
Route::get('author/{slug}',[ArticleController::class,'authorPage']);

Route::get('board-insights',[BoardInsightsController::class,'insightList']);
Route::get('board-insights/{slug}',[BoardInsightsController::class,'insightDetails']);

Route::get('book-review',[ArticleController::class,'bookReviews']);
Route::get('book-review/{slug}',[ArticleController::class,'reviewPage']);

Route::get('google/redirect', [AuthController::class, 'redirectToGoogle']);
Route::get('google/callback', [AuthController::class, 'handleGoogleCallback']);

Route::get('{slug}',[ArticleController::class,'articlePage'])->name('articlePage');
