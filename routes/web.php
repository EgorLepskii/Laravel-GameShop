<?php

use App\Http\Controllers\EmailAdditionController;
use App\Http\Controllers\SearchProductController;
use App\Http\Controllers\SocialAuthController;
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


use App\Http\Controllers\AdminCategoryController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminProductController;
use App\Http\Controllers\AdminRecipientController;
use App\Http\Controllers\AdminRecipientRoleController;
use App\Http\Controllers\BuyController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\RecipientController;
use App\Http\Controllers\RoleController;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;

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


App::setLocale('ru');
Auth::routes(['verify' => true]);

Route::get('/', function (){
   return redirect('/home');
});
Route::get('home/{page?}/{category?}', [HomeController::class, 'index'])->name('home.index');


Route::group(
    ['prefix' => 'buy', 'middleware' => 'auth'], function () {
    Route::post('/', [BuyController::class, 'store'])->name('buy.store');

}
);
Route::group(
    ['prefix' => 'admin', 'middleware' => 'admin'], function () {

    Route::get('show', [AdminController::class, 'index'])->name('admin.show');
}
);

Route::group(
    ['prefix' => 'adminProduct', 'middleware' => 'admin'], function () {

    Route::get('show', [AdminProductController::class, 'show'])->name('adminProduct.show');

}
);

Route::group(
    ['prefix' => 'adminRecipient', 'middleware' => 'admin'], function () {

    Route::get('show', [AdminRecipientController::class, 'show'])->name('adminRecipient.show');
}
);

Route::group(
    ['prefix' => 'adminRecipientRole', 'middleware' => 'admin'], function () {

    Route::get('show', [AdminRecipientRoleController::class, 'show'])->name('adminRecipientRole.show');
}
);

Route::group(
    ['prefix' => 'adminCategory', 'middleware' => 'admin'], function () {

    Route::get('show', [AdminCategoryController::class, 'show'])->name('adminCategory.show');
}
);

Route::group(
    ['prefix' => 'admin', 'middleware' => 'admin'], function () {

    Route::get('', [AdminController::class, 'index'])->name('admin.index');
}
);

Route::group(
    ['prefix' => 'category'], function () {
    Route::get('', [CategoryController::class, 'index'])->
    name('category.index')->middleware('admin');

    Route::get('/{category}/edit', [CategoryController::class, 'edit'])->
    name('category.edit')->middleware('admin');

    Route::post('/{category}', [CategoryController::class, 'update'])->
    name('category.update')->middleware('admin');


    Route::get('/', [CategoryController::class, 'create'])->
    name('category.create')->middleware('admin');

    Route::post('/{category}/destroy', [CategoryController::class, 'destroy'])->
    name('category.destroy')->middleware('admin');

    Route::post('/', [CategoryController::class, 'store'])->
    name('category.store')->middleware('admin');
}
);


Route::group(
    ['prefix' => 'product'], function () {

    Route::post('/store', [ProductController::class, 'store'])->name('product.store')
        ->middleware('admin');


    Route::get('/{product}/product', [ProductController::class, 'index'])->name('product.index')
        ->middleware('admin');

    Route::get('/{product}/edit', [ProductController::class, 'edit'])->name('product.edit')
        ->middleware('admin');

    Route::post('/{product}/destroy', [ProductController::class, 'destroy'])->name('product.destroy')
        ->middleware('admin');

    Route::get('/show/{product}', [ProductController::class, 'show'])->name('product.show');

    Route::post('/{product}', [ProductController::class, 'update'])->name('product.update')
        ->middleware('admin');
}
);

Route::group(
    ['prefix' => 'order', 'middleware' => ['auth', 'verified']], function () {

    Route::get('/{page?}', [OrderController::class, 'index'])->name('order.index');

    Route::post('/store/{product}', [OrderController::class, 'store'])->name('order.store');

    Route::get('/show/{order}', [OrderController::class, 'show'])->name('order.show');

    Route::post('/{order}/destroy', [OrderController::class, 'destroy'])->name('order.destroy');
}
);

Route::group(
    ['prefix' => 'recipient', 'middleware' => 'admin'], function () {

    Route::post('/store', [RecipientController::class, 'store'])->name('recipient.store');
}
);

Route::group(
    ['prefix' => 'role', 'middleware' => 'admin'], function () {

    Route::post('/store', [RoleController::class, 'store'])->name('role.store');
}
);

Route::group(['middleware' => 'guest'], function(){
    Route::get('/social',[SocialAuthController::class, 'index'])->name('socialAuth.index');
    Route::get('/auth/callback/vk',[SocialAuthController::class, 'callback']);
    Route::get('/auth/callback/google',[SocialAuthController::class, 'callback']);
});

Route::group(['prefix' => 'search'], function(){
    Route::get('/product',[SearchProductController::class, 'index'])->name('searchProduct.index');

});



require __DIR__.'/auth.php';
