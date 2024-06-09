<?php

namespace App\Http\Controllers;

use App\Mail\OTPEmail;
use Illuminate\Http\Request;
use App\Models\User;
use Exception;
use App\Helper\JWTToken;
use Illuminate\Contracts\View\View;
// use Mail;
use Illuminate\Support\Facades\Mail;
use Mockery\Expectation;

class UserController extends Controller
{
    // page routes
    function LoginPage():View{
        return view('pages.auth.login-page');
    }
    function DashboardPage():View{
        return view('layout.sidenav-layout');
    }
    function RegistrationPage():View{
    return view("pages.auth.registration-page");
    }
    function SendOTPPage():View
    {
        return view("pages.auth.send-otp-page");
    }
    function VerifyOTPPage():view{
        return View("pages.auth.verify-otp-page");
    }
    function Dashboard():view{
        return  View("pages.dashboard.profile-page");
    }
    function ResetPasswordPage():view
    {
        return view("pages.auth.reset-pass-page");
    }


    // API routes
    function UserRegistration(Request $request)
    {
        try {
            User::create([
                'firstName' => $request->input('firstName'),
                'lastName' => $request->input('lastName'),
                'email' => $request->input('email'),
                'password' => $request->input('password'),
                'mobile' => $request->input('mobile')
            ]);
            return response()->json([
                'status' => 'sucessful',
                'message' => 'User Registration Sucessful'
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'Faild',
                'message' => $e->getMessage()
            ]);
        }

    }
    function UserLogin(Request $request)
    {
        try{
            $userExist = User::Where('email', '=', $request->input('email'))
                ->Where('password', '=', $request->input('password'))
                ->first();
            if ($userExist !==null) {
                $token = JWTToken::CreateToken($request->input("email"),$userExist->id);
                return response()->json([
                    'status' => 'sucessful',
                    'message' => 'User Login Sucessful'
                ])->withCookie("token",$token,60*24*7);
            } else {
                return response()->json([
                    "status" => "Unathorized",
                    "message" => "Invalid Email or Password"
                ]);
            }
        }
        catch(Exception $e)
        {
            return response()->json([
                "status" => "Unathorized",
                "message" => $e
            ]);
        }
    }
    function SendOtp(Request $request)
    {
        $email = $request->input("email");
        $otp = rand(1000, 9999);
        $userCount = User::where("email", "=", $email)->count();
        if ($userCount == 1) {
            // Mail::to($email)->send(new OTPEmail($otp));
            User::where("email", "=", $email)->update(["otp" => $otp]);
            return response()->json([
                "status" => "sucessful",
                "message" => "sucessfully Email Sent"
            ]);
        } else {
            return response()->json([
                "status" => "faild",
                "message" => "User Not Found"
            ]);
        }
    }
    function VerifyOTP(Request $request)
    {
        $otp = $request->input("otp");
        $email = $request->input("email");
        $getUser = User::where("otp", "=", $otp)
        ->where("email", "=", $email)
        ->first();
        if ($getUser!==null) {

            $user = User::where("email", "=", $email)
                ->where("otp", "=", $otp)
                ->update(["otp" => "0"]);

            $token=JWTToken::CreateTokenForSetPassword($email,$getUser->id);
            return response()->json([
                "status" => "sucessful",
                "message"=>"User Password Reset in Sucessful",
            ])->withCookie('token',$token,60*24*7);


        } else {
            return response()->json(
                [
                    "status" => "Unathorized",
                    "message" => "User is not Unathorized"
                ],
                401
            );
        }

    }
    function ResetPassword(Request $request){
            try{
                $email=$request->header("email");
                $password=$request->input("password");
                User::where("email",$email)->update(["password"=>$password]);
                return response()->json([
                    "status" => "Athorized",
                    "message" => "User Athorized"
                ]);
            }
            catch(Exception $e)
            {
                return response()->json([
                    "status" => "Unathorized",
                    "message" => "User is Unathorized"
                ],401);
            }

    }
    function LogoutPage()
    {
        return redirect("login")->withCookie("token","",-1);
    }
    function UserProfile(Request $request){
        $email=$request->header("email");
        $user=USER::where("email","=",$email)->first();
        return response()->json([
            "status"=>"sucessful",
            "message"=>"Request Sucessful",
            "data"=>$user
        ]);
    }
    function UserProfileUpdate(Request $request){
     try{
        $email=$request->header("email");
        // $password=$request->input("password");
        $mobile=$request->input("mobile");
        $firstName=$request->input("firstName");
        $lastName=$request->input("lastName");
        User::where("email","=",$email)->update([
            "firstName"=>$firstName,
            "lastName"=>$lastName,
            "mobile"=>$mobile,
            // "password"=>$password,
        ]);
        return response()->json([
            "status"=>"sucessful",
            "message"=>"sucessful",
        ]);
     }catch(Exception $e)
     {
        return response()->json([
            "status"=>"Unsucessful",
            "message"=>$e,
        ],401);
    }
}
}
