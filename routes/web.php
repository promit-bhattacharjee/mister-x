<?php

use App\Http\Controllers\CategoryContoller;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Middleware\TokenVerificationMiddleware;
use App\Models\User;

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

// Route::get('/', function () {
//     return view('welcome');
// });
//web Router
Route::get('/login', [UserController::class, "LoginPage"]);
Route::get('/registration', [UserController::class, "RegistrationPage"]);
Route::get("/dashboard", [UserController::class, "DashboardPage"]);
Route::get("/sendotp", [UserController::class, "SendOTPPage"]);
Route::get("/verifyotp", [UserController::class, "VerifyOTPPage"]);
Route::get("/resetpassowrd", [UserController::class, "ResetPasswordPage"]);

// api Routes
Route::post('/user-registration', [UserController::class, "UserRegistration"]);
Route::post('/user-login', [UserController::class, 'UserLogin']);
Route::post('/send-otp', [UserController::class, "SendOtp"]);
Route::post("/verify-otp", [UserController::class, "VerifyOTP"]);
Route::post("/logout", [UserController::class, "LogoutPage"]);


Route::middleware(TokenVerificationMiddleware::class)->group(
    function () {
        Route::post("/reset-password", [UserController::class, "ResetPassword"]);
        Route::get("/dashboard", [UserController::class, "Dashboard"]);
        Route::post("/user-profile", [UserController::class, "UserProfile"]);
        Route::post("/update-profile", [UserController::class, "UserProfileUpdate"]);

        //Category
        //api
        Route::get("/categories", [CategoryContoller::class, "GetCategories"]);
        Route::post("/add-categories", [CategoryContoller::class, "AddCategories"]);
        Route::post("/edit-categories", [CategoryContoller::class, "EditCategories"]);
        Route::post("/delete-categories", [CategoryContoller::class, "DeleteCategories"]);
        Route::post("/category-by-id", [CategoryContoller::class, "CategoryByID"]);
        //web
        Route::get("/categoriespage", [CategoryContoller::class, "CategoriesPage"]);

        //Customer
        //API
        Route::get("/get-customer", [CustomerController::class, "getCustomer"]);
        Route::post("/customer-by-id", [CustomerController::class, "CustomerByID"]);
        Route::post("/create-customer", [CustomerController::class, "CreateCustomer"]);
        Route::post("/update-customer", [CustomerController::class, "UpdateCustomer"]);
        Route::post("/delete-customer", [CustomerController::class, "DeleteCustomer"]);
        //web
        Route::get("/customerpage", [CustomerController::class, "CustomerPage"]);
        //product
        //API
        Route::post("/create-product", [ProductController::class, "CreateProduct"]);
        Route::post("/delete-product", [ProductController::class, "DeleteProduct"]);
        Route::post("/product-by-id", [ProductController::class, "GetProductByID"]);
        Route::get("/get-product", [ProductController::class, "GetProduct"]);
        Route::post("/update-product", [ProductController::class, "UpdateProduct"]);
        //web
        Route::get("/productpage", [ProductController::class, "ProductPage"]);

    }
);
