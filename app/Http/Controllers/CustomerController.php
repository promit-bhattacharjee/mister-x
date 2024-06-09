<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use Exception;
use Illuminate\Support\Facades\View;
use Illuminate\View\View as ViewView;

class CustomerController extends Controller
{
    //WEB
    function CustomerPage()
    {
        return view("pages.dashboard.customer-page");
    }


    //API
    function CreateCustomer(Request $request)
    {
        try {
            $user_id = $request->header("id");
            $name = $request->input("name");
            $email = $request->input("email");
            $mobile = $request->input("mobile");
            Customer::insert([
                "name" => $name,
                "user_id" => $user_id,
                "email" => $email,
                "mobile" => $mobile

            ]);
            return response()->json([
                "status" => "sucessful",
                "message" => "User Created Sucessfully"
            ]);
        } catch (Exception $e) {
            return response()->json([
                "status" => "faild",
                "message" => $e
            ]);
        }
    }
    function getCustomer(Request $request)
    {
        try {
            $user_id = $request->header("id");
            // $name=$request->input("name");
            // $email=$request->input("email");
            // $mobile=$request->input("mobile");
            $res = Customer::where("user_id", "=", $user_id)->get();
            if ($res->isNotEmpty()) {
                return response()->json([
                    "status" => "sucessful",
                    "message" => "Data successfully Fetched",
                    "data" => $res
                ]);
            } else {
                return response()->json([
                    "status" => "sucessful",
                    "message" => "No Customer in this User"
                ]);
            }
        } catch (Exception $e) {
            return response()->json([
                "status" => "faild",
                "message" => $e
            ]);
        }
    }
    function CustomerByID(Request $request)
    {
        try {
            $user_id = $request->header("id");
            $id = $request->input("id");
            $res = Customer::where("id", "=", $id)
                ->where("user_id", "=", $user_id)->first();
            if ($res!==null) {
                return response()->json([
                    "status" => "sucessful",
                    "message" => "Data successfully Fetched",
                    "data" => $res
                ]);
            } else {
                return response()->json([
                    "status" => "faild",
                    "message" => "No Customer Exist"
                ]);
            }
        } catch (Exception $e) {
            return response()->json([
                "status" => "faild",
                "message" => $e
            ]);
        }
    }
    function UpdateCustomer(Request $request)
    {
        try {
            $user_id = $request->header("id");
            $id = $request->input("id");
            $name=$request->input("name");
            $email=$request->input("email");
            $mobile=$request->input("mobile");
            $res = Customer::where("user_id", "=", $user_id)
                ->where("id", "=", $id);
            if ($res->first() !== null) {
                $res->update([
                    "name"=>$name,
                    "email"=>$email,
                    "mobile"=>$mobile,]);
                return response()->json([
                    "status" => "sucessful",
                    "message" => "Data successfully updated"
                ]);
            } else {
                return response()->json([
                    "status" => "faild",
                    "message" => "No Customer in this User"
                ]);
            }
        } catch (Exception $e) {
            return response()->json([
                "status" => "faild",
                "message" => $e
            ]);
        }
    }
    function DeleteCustomer(Request $request)
    {
        try {
            $user_id = $request->header("id");
            $id = $request->input("id");
            // $email=$request->input("email");
            // $mobile=$request->input("mobile");
            $res = Customer::where("user_id", "=", $user_id)
                ->where("id", "=", $id);
            if ($res->first() !== null) {
                $res->delete();
                return response()->json([
                    "status" => "sucessful",
                    "message" => "Data successfully Deleted"
                ]);
            } else {
                return response()->json([
                    "status" => "faild",
                    "message" => "No Customer in this User"
                ]);
            }
        } catch (Exception $e) {
            return response()->json([
                "status" => "faild",
                "message" => $e
            ]);
        }
    }
}
