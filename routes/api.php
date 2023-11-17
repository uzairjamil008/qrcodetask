<?php

use App\Http\Controllers\Business\BusinessController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*

|--------------------------------------------------------------------------

| API Routes

|--------------------------------------------------------------------------

|

| Here is where you can register API routes for your application. These

| routes are loaded by the RouteServiceProvider within a group which

| is assigned the "api" middleware group. Enjoy building your API!

|

 */

Route::middleware('api')->get('/user', function (Request $request) {

    return $request->user();
});

Route::get('/businesses/{columnval}/{column}', [App\Http\Controllers\Api\BookingController::class, 'businesses']);

Route::get('/business_details/{id}', [App\Http\Controllers\Api\BookingController::class, 'business_details']);

Route::get('/products/{id}', [App\Http\Controllers\Api\BookingController::class, 'products']);
Route::get('/productdetail/{id}', [App\Http\Controllers\Api\BookingController::class, 'productdetail']);
Route::get('/singleproduct/{id}', [App\Http\Controllers\Api\BookingController::class, 'singleproduct']);
Route::post('discount', [App\Http\Controllers\Api\BookingController::class, 'discount']);
Route::post('search', [App\Http\Controllers\Api\BookingController::class, 'search']);

Route::get('/reservations/{id}/{type}/{business_type?}', [App\Http\Controllers\Api\BookingController::class, 'reservations']);

Route::get('/customer_dashbord/{id}', [App\Http\Controllers\Api\DashboardController::class, 'customer_dashbord']);

Route::post('/update_info', [App\Http\Controllers\Api\DashboardController::class, 'update_info']);

Route::post('/userlog', [App\Http\Controllers\Api\LoginController::class, 'userlog']);

Route::post('/customerregister', [App\Http\Controllers\Api\LoginController::class, 'customerregister']);
Route::get('/delete_account/{id}', [App\Http\Controllers\Api\LoginController::class, 'delete_account']);
Route::get('/users_list', [App\Http\Controllers\Api\LoginController::class, 'users_list']);
Route::post('/change_password', [App\Http\Controllers\Api\LoginController::class, 'change_password']);
Route::post('forgot_password', [App\Http\Controllers\Api\LoginController::class, 'forgot_password']);
Route::post('reset-password', [App\Http\Controllers\Api\LoginController::class, 'reset']);

Route::post('/save_reservation', [App\Http\Controllers\Api\BookingController::class, 'save_reservation']);

Route::post('/savecontact', [App\Http\Controllers\Api\ContactController::class, 'savecontact']);

Route::get('/mainslider', [App\Http\Controllers\Api\HomeController::class, 'mainslider']);
Route::get('/topproducts', [App\Http\Controllers\Api\HomeController::class, 'topproducts']);
Route::get('/topcountries', [App\Http\Controllers\Api\HomeController::class, 'topcountries']);
Route::get('/topbusiness', [App\Http\Controllers\Api\HomeController::class, 'topbusiness']);

Route::get('/types', [App\Http\Controllers\Api\HomeController::class, 'types']);
Route::get('/site_content', [App\Http\Controllers\Api\HomeController::class, 'site_content']);
Route::post('/payment_intent', [App\Http\Controllers\Api\BookingController::class, 'payment_intent']);


//Maxhype
