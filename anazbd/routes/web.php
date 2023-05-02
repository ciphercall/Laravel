<?php

use App\Menu;
use App\Seller;
use App\Traits\SMS;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Mail;
use App\User;
use Jenssegers\Agent\Agent;

/*
 * Backend Routes
 */

require_once __DIR__ . '/backend/authentication.php';

Route::get('/admin/login','Admin\AuthController@showLoginForm')->name('admin.login.form');
Route::post('/admin/login','Admin\AuthController@login')->name('admin.login');
Route::post('/admin/logout','Admin\AuthController@logout')->name('admin.logout');

Route::group(['prefix'=>'/admin','middleware' => ['admin','auth:admin','NewAdminMiddleware'],'namespace'=>'Admin'],function(){
    // Dashboard
    require_once __DIR__ . '/admin/dashboard.php';

    // Campaign
    require_once __DIR__.'/admin/campaign.php';

    // Orders
    require_once __DIR__.'/admin/product.php';

    // Orders
    require_once __DIR__.'/admin/orders.php';

    // Transaction
    require_once __DIR__.'/admin/transaction.php';

    // Menu
    require_once __DIR__.'/admin/menu.php';

    // Notifications
    require_once __DIR__.'/admin/notifications.php';
});

// Route::group(['prefix' => '/anaz/superAdmin', 'middleware' => ['admin','auth:admin'], 'namespace' => 'Backend'], function () {
Route::group(['prefix' => '/anaz/superAdmin', 'middleware' => ['admin','auth:admin'], 'namespace' => 'Backend'], function () {

    Route::group(['middleware'=>'can:edit_product'],function(){
        Route::get('/unpublished/edit/{id}', 'ItemController@editUnpublished')
        ->name('backend.product.items.unpublished.edit');
        Route::get('/published/edit/{id}', 'ItemController@editPublished')
        ->name('backend.product.items.published.edit');
    });


    // non view
    Route::get('/destroy/{id}', 'ItemController@destroy')
        ->name('backend.product.items.destroy')->middleware('can:delete_product');
    Route::post('/update/{id}', 'ItemController@update')
        ->name('backend.product.items.update')->middleware('can:edit_product');

});
Route::group(['prefix' => '/anaz/superAdmin', 'middleware' => ['admin','auth:admin','can:access_old_admin_panel'], 'namespace' => 'Backend'], function () {


    // Dashboard
    require_once __DIR__ . '/backend/dashboard.php';

    // Site Config
    require_once __DIR__ . '/backend/site_config.php';

    // Product Config
    require_once __DIR__ . '/backend/product.php';

    // Customer
    require_once __DIR__ . '/backend/customer.php';

    // Admin
    require_once __DIR__ . '/backend/admin.php';

    // EConfig
    require_once __DIR__ . '/backend/econfig.php';

    // Social link
    require_once __DIR__ . '/backend/social.php';

    // Blog
    require_once __DIR__ . '/backend/blog.php';

    // Seller
    require_once __DIR__ . '/backend/seller.php';

    // SMS, Email
    require_once __DIR__ . '/backend/sms & email.php';

    // Area Division
    require_once __DIR__ . '/backend/area_division.php';

    // City
    require_once __DIR__ . '/backend/city.php';

    // Post Code
    require_once __DIR__ . '/backend/post_code.php';

    // Campaign
    require_once __DIR__ . '/backend/campaign.php';

    // Agent
    require_once __DIR__ . '/backend/agent.php';

    // Comment
    require_once __DIR__ . '/backend/comment.php';

    // Order
    require_once __DIR__ . '/backend/order.php';

    // Chalan
    require_once __DIR__ . '/backend/chalan.php';

    // Transaction
    require_once __DIR__ . '/backend/transaction.php';

    Route::get('/questions','QuestionController@index')->name('backend.questions.all');
    Route::post('/questions/{question}/approve','QuestionController@approve')->name('backend.questions.approve');

    /*
        ! Cart & Wishlist Routes
    */
    Route::get('/cart/items','CartController@index')->name('backend.cart.index');
    Route::get('/wishlist/items','WishlistController@index')->name('backend.wishlist.index');
});


/*
 * Seller Routes
 */

require_once __DIR__ . '/seller/authentication.php';

Route::group(['prefix' => 'seller', 'middleware' => ['auth:seller', 'seller'], 'namespace' => 'Seller'], function () {

    // Dashboard
    require_once __DIR__ . '/seller/dashboard.php';

    // Product
    require_once __DIR__ . '/seller/product.php';

    // Order
    require_once __DIR__ . '/seller/order.php';

    // Campaign
    require_once __DIR__ . '/seller/campaign.php';

    // Transaction
    require_once __DIR__ . '/seller/transaction.php';

    // Questions
    require_once __DIR__ . '/seller/question.php';

});


/*
 * Delivery Routes
 */

require_once __DIR__ . '/delivery/authentication.php';

Route::group(['prefix' => 'delivery', 'middleware' => ['auth:delivery', 'delivery'], 'namespace' => 'Delivery'], function () {

    // Dashboard
    require_once __DIR__ . '/delivery/dashboard.php';

    // Order
    require_once __DIR__ . '/delivery/order.php';

    // Transaction
    require_once __DIR__ . '/delivery/transaction.php';

});

/*
 * Frontend Routes
 */

require_once __DIR__ . '/frontend/authentication.php';

Route::group(['prefix' => '/', 'namespace' => 'Frontend'], function () {
    // home
    require_once __DIR__ . '/frontend/home.php';

    //page
    require_once __DIR__ . '/frontend/page.php';

    //blog page
    require_once __DIR__ . '/frontend/blog.php';

    //wishlist page
    require_once __DIR__ . '/frontend/wishlist.php';

    // cart
    require_once __DIR__ . '/frontend/cart-checkout.php';

    // comment
    require_once __DIR__ . '/frontend/comment.php';

    //mobile
    require_once __DIR__ . '/mobile/category.php';
});

/*
 * Hybrid Routes
 */

Route::get('/log',function(){
    $dirtyMenus = Menu::with('submenus')->get();
    $menus = $dirtyMenus->filter(function($menu){
        return $menu->submenus->count() > 0 || $menu->parent_id == null;
    });
    dd($menus);
});

// Route::get('/point',function(){
//     $userId = 33;
//     $pointChart = PointChart::where('amount','<=',500)->get();
//     if($pointChart != null && $pointChart->count() > 0){
//         $point = $pointChart->last()->point ?? 0;
//         if($point > 0){
//             try{
//                 DB::beginTransaction();
//                 $userPoint = UserPoint::where('user_id',$userId)->first();
//                 $previousPoint = $userPoint->point ?? 0;
//                 if($userPoint != null){
//                     $userPoint->point += $point;
//                     $userPoint->update();
//                 }else{
//                     UserPoint::create([
//                         'user_id' => $userId,
//                         'point' => $point,
//                     ]);
//                 }
//                 PointTransaction::create([
//                     'user_id' => $userId,
//                     'amount' => $point,
//                     'status' => 'approved',
//                     'previous_amount' => $previousPoint,
//                     'type' => "Order-created-no-",
//                 ]);
//                 DB::commit();
//             }catch (Exception $e){
//                 DB::rollBack();
//                 Log::error($e->getMessage());
//             }
            
//         }
//     }
// });


// require_once __DIR__ . '/api/hybrid.php';

// Route::get('/new-cart',function(){
//     $agent = new Agent();
//     if($agent->isMobile()){
//         return view('mobile.pages.new-cart');
//     }
//     return view('frontend.pages.new-cart');
// });
// Route::get('/new-checkout',function(){
//     $agent = new Agent();
//     if($agent->isMobile()){
//         return view('mobile.pages.new-checkout');
//     }
//     return view('frontend.pages.new-checkout');
// });

// Route::get('/send/mail',function (){
//     $data = array('name'=>"Virat Gandhi");
//     Mail::send(['text'=>'mail.order-invoice'], $data, function($message) {
//         $message->to('shamrat@anazbd.com', 'Yasin Shamrat')->subject
//            ('Laravel Basic Testing Mail');
//      });
//      echo 'sent';
// });

// Route::get('/delete/category',function(){
    // $category = Category::find(1);
    // $items = $category->items;
    // dd($items);
    // foreach($items as $item){
        // $item = Item::find(191)->delete();
        // OrderItem::where('item_id',$item->id)->delete();
        // Variant::where('item_id',$item->id)->delete();
        // Wishlist::where('item_id',$item->id)->delete();
        // FlashSaleItem::where('item_id',$item->id)->delete();
        // Question::where('item_id',$item->id)->delete();
        // Comment::where('item_id',$item->id)->delete();
    // }
    // Item::where('category_id',$category->id)->delete();
    // ChildCategory::where('category_id',$category->id)->delete();
    // SubCategory::where('category_id',$category->id)->delete();
    // $category->delete();
// });

// Route::get('/move', function() {
    // dd(Seller::find(11)->items->count());
    // dd(Category::find(30));
    // dd(Item::where('category_id',52)->update(['seller_id' => 25]));
// });


Route::get('/decrypt/{hash}',function ($hash){
    dd(Crypt::decrypt($hash));
//    $password = 12345678;
//    $user = User::first();
//    $encrypted = Crypt::encrypt($password);
//    Log::channel('system-info-log')->info("User_".$user->id."_".$encrypted."_".$user->toJson());

});
