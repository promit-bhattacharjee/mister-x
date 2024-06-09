<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\User;
use Exception;
use Illuminate\Contracts\View\View;

class CategoryContoller extends Controller
{
    function CategoriesPage():View
    {
        return view("pages.dashboard.category-page");
    }
    function GetCategories(Request $request)
    {

        try {
            $id = $request->header("id");
            $categories = Category::where("user_id", "=", $id)->get();
            return response()->json([
                "status" => "sucessful",
                "message" => " Get Categories Sucessfully",
                "data" => $categories
            ]);
        } catch (Exception $e) {
            return response()->json([
                "status" => "Unsucessfull",
                "message" => $e
            ]);
        }
    }
    function AddCategories(Request $request)
    {

        try {
            $user_id = $request->header("id");
            $name = $request->input("name");
            Category::insert([
                "name" => $name,
                "user_id" => $user_id
            ]);
            return response()->json([
                "status" => "sucessful",
                "message" => "Added Sucessfully"
            ]);
        } catch (Exception $e) {
            return response()->json([
                "status" => "Unsucessfull",
                "message" => $e
            ]);
        }
    }
    function EditCategories(Request $request)
    {
        try {
            $user_id = $request->header("id");
            $name = $request->input("name");
            $id = $request->input("id");
            $product = Category::where("id", "=", $id)->where("user_id","=",$user_id);
            if ($product->first() !== null) {
                $product->update([
                    "name" => $name,
                    "user_id" => $user_id
                ]);
                return response()->json([
                    "status" => "sucessful",
                    "message" => "Edit Sucessfully"
                ]);
            } else {
                return response()->json([
                    "status" => "Unsucessful",
                    "message" => "No Data Exist"
                ]);
            }
        } catch (Exception $e) {
            return response()->json([
                "status" => "Unsucessfull",
                "message" => $e
            ]);
        }
    }
    function DeleteCategories(Request $request)
    {
        try {
            $user_id = $request->header("id");
            $id = $request->input("id");
            $product=Category::where("id", "=", $id)
                ->where("user_id", "=", $user_id);
                if($product->first()!==null)
                {
                    $product->delete();
                    return response()->json([
                        "status" => "sucessful",
                        "message" => "Delete Sucessfully"]);
                }
                else{

                    return response()->json([
                        "status" => "Unsucessful",
                        "message" => "No Data Exist"
                    ]);
                }
        } catch (Exception $e) {
            return response()->json([
                "status" => "Unsucessfull",
                "message" => $e
            ]);
        }
    }
    function CategoryByID(Request $request)
    {
        try {
            $user_id = $request->header("id");
            $id = $request->input("id");
            $product=Category::where("id", "=", $id)
                ->where("user_id", "=", $user_id);
                if($product->first()!==null)
                {
                    return response()->json([
                        "status" => "sucessful",
                        "message" => "Data Fetched Sucessfully",
                    "data"=>$product->first()]);
                }
                else{

                    return response()->json([
                        "status" => "Unsucessful",
                        "message" => "No Data Exist"
                    ]);
                }
        } catch (Exception $e) {
            return response()->json([
                "status" => "Unsucessfull",
                "message" => $e
            ]);
        }
    }

}
