<?php

namespace App\Http\Controllers;

use App\Mail\OTPEmail;
use Illuminate\Http\Request;
use App\Models\User;
use Exception;
use App\Helper\JWTToken;
// use Mail;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller
{
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
        $userExist = User::Where('email', '=', $request->input('email'))
            ->Where('password', '=', $request->input('password'))
            ->count();
        if ($userExist == 1) {
            $token = JWTToken::CreateToken($request->input("email"));
            return response()->json([
                'status' => 'sucessful',
                'message' => 'User Login Sucessful',
                'token' => $token
            ])->cookie("token"->$token,);
        } else {
            return response()->json([
                "status" => "Unathorized",
                "message" => "Invalid Email or Password"
            ]);
        }
    }
    function SendOtp(Request $request)
    {
        $email = $request->input("email");
        $otp = rand(1000, 9999);
        $userCount = User::where("email", "=", $email)->count();
        if ($userCount == 1) {
            Mail::to($email)->send(new OTPEmail($otp));
            User::where("email", "=", $email)->update(["otp" => $otp]);
            return response()->json([
                "status" => "sucessful",
                "message" => "OTP Sent Successfully"
            ]);
        } else {

        }
    }
    function VerifyOTP(Request $request)
    {
        $otp = $request->input("otp");
        $email = $request->input("email");
        $getUser = User::where("otp", "=", $otp)->where("email", "=", $email)->count();
        if ($getUser == 1) {

            $user = User::where("email", "=", $email)
                ->where("otp", "=", $otp)
                ->update(["otp" => "0"]);

            $token=JWTToken::CreateTokenForSetPassword($email);
            return response()->json([
                "status" => "sucessful",
                "message"=>"User Password Reset in Sucessful",
                "token"=>$token

            ]);


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
}
