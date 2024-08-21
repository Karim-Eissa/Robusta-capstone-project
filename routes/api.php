<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\OrderController;
use Illuminate\Http\Request;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Middleware\AdminMiddleware;
use App\Jobs\SendDailyOrdersReport;
use Illuminate\Support\Facades\Mail;
use App\Models\Order;
use App\Mail\OrderConfirmation;

Route::middleware(StartSession::class)->get('/send-confirmation-email/{order_id}', function ($order_id) {
    $order = Order::find($order_id); 
    if ($order) {
        Mail::to('karim.moeissa@gmail.com')->send(new OrderConfirmation($order));
        return response()->json(['message' => 'Order confirmation email sent successfully.']);
    }
    return response()->json(['error' => 'Order not found.'], 404);
})->middleware(AdminMiddleware::class);

Route::middleware(StartSession::class)->get('/admin/send-daily-orders-report', function () {
    dispatch(new SendDailyOrdersReport());
})->middleware(AdminMiddleware::class);

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
Route::get('/token', function () {
    return csrf_token(); 
});
Route::middleware(StartSession::class)->post('/admin/login', [AdminController::class, 'login'])->name('admin.login');
Route::middleware(StartSession::class)->post('/admin/add-category', [CategoryController::class, 'addCategory'])->middleware(AdminMiddleware::class);
Route::middleware(StartSession::class)->post('/admin/add-product', [ProductController::class, 'addProduct'])->middleware(AdminMiddleware::class);
Route::middleware(StartSession::class)->get('/admin/orders', [OrderController::class, 'index'])->middleware(AdminMiddleware::class);
