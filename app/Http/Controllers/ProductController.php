<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Exception;
use Illuminate\Support\Facades\File;
use Illuminate\Contracts\View\View;

class ProductController extends Controller
{
    //web
    function ProductPage():view
    {
        return view("pages.dashboard.product-page");
    }
    //API
    function CreateProduct(Request $request)
    {
        try {
            $user_id = $request->header("id");
            $img = $request->file("img");
            $name = $request->input("name");
            $unit = $request->input("unit");
            $price = $request->input("price");
            $category_id = $request->input("category_id");

            $time = time();
            $file_name = $img->getClientOriginalName();
            $img_name = "{$user_id}-{$time}-{$file_name}";
            $img_url = "uploads/{$img_name}";


            Product::create([
                "name" => $name,
                "unit" => $unit,
                "price" => $price,
                "user_id" => $user_id,
                "category_id" => $category_id,
                "img_url" => $img_url,
            ]);
            $img->move(public_path("uploads"), $img_name);
            return response()->json([
                "status" => "sucessful",
                "message" => "Product Created Sucessfully"
            ]);
        } catch (Exception $e) {
            return response()->json([
                "status" => "faild",
                "message" => $e
            ]);
        }
    }
    function updateProduct(Request $request)
    {
        try {
            $user_id = $request->header("id");
            $id = $request->input("id");
            $img = $request->file("img");
            $privious_img = $request->input("privious_img");
            $name = $request->input("name");
            $unit = $request->input("unit");
            $price = $request->input("price");
            $category_id = $request->input("category_id");

            if ($request->hasFile("img")) {
                $time = time();
                $file_name = $img->getClientOriginalName();
                $img_name = "{$user_id}-{$time}-{$file_name}";
                $img_url = "uploads/{$img_name}";


                Product::where("user_id", "=", $user_id)
                    ->where("id", "=", $id)
                    ->update
                    ([
                            "name" => $name,
                            "unit" => $unit,
                            "price" => $price,
                            "user_id" => $user_id,
                            "category_id" => $category_id,
                            "img_url" => $img_url,
                        ]);
                File::delete($privious_img);
                $img->move(public_path("uploads"), $img_name);
                return response()->json([
                    "status" => "sucessful",
                    "message" => "Product With Image Updated Sucessfully"
                ]);
            } else { {
                    Product::where("user_id", "=", $user_id)
                        ->where("id", "=", $id)
                        ->update
                        ([
                                "name" => $name,
                                "unit" => $unit,
                                "price" => $price,
                                "user_id" => $user_id,
                                "category_id" => $category_id,
                            ]);
                    return response()->json([
                        "status" => "sucessful",
                        "message" => "Product Updated Sucessfully"
                    ]);
                }
            }
        } catch (Exception $e) {
            return response()->json([
                "status" => "faild",
                "message" => $e
            ]);
        }
    }
    function DeleteProduct(Request $request)
    {
        try {
            $user_id = $request->header("id");
            $img = $request->input("img");
            $id = $request->input("id");

            $res=Product::where("user_id", "=", $user_id)
                ->where("id", "=", $id);
            if($res!=null)
            {
                File::delete($img);
                $res->delete();
                return response()->json([
                    "status" => "sucessful",
                    "message" => "Product Deleted Sucessfully"
                ]);
            }
            else{
                return response()->json([
                    "status" => "faild",
                    "message" => "No Product Data"
                ]);
            }
        } catch (Exception $e) {
            return response()->json([
                "status" => "faild",
                "message" => $e->getMessage()
            ]);
        }
    }
    function GetProductByID(Request $request)
    {
        try {
            $user_id = $request->header("id");
            $id = $request->input("id");
            $res = Product::where("user_id", "=", $user_id)
                ->where("id", "=", $id)
                ->first();

            if ($res == null || $res=="") {
                return response()->json([
                    "status" => "failed",
                    "message" => "Product ID does not exist",
                ]);
            } else {
                return $res;

            }

        } catch (Exception $e) {
            return response()->json([
                "status" => "failed",
                "message" => $e->getMessage()
            ]);
        }
    }

    function GetProduct(Request $request)
    {
        try {
            $user_id = $request->header("id");
            $res = Product::where("user_id", "=", $user_id)->get();
            if (
                $res->isNotEmpty()

            ) {
                return response()->json([
                    "status" => "sucessful",
                    "message" => "Product Data Fetched Sucessfully",
                    "data" => $res
                ]);
            } else {
                return response()->json([
                    "status" => "faild",
                    "message" => "No Product To Show",
                ]);
            }

        } catch (Exception $e) {
            return response()->json([
                "status" => "faild",
                "message" => $e->getMessage()
            ]);
        }
    }

}
