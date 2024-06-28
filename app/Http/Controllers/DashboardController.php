<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Invoice;
use App\Models\Customer;
use App\Models\Product;
use App\Models\Category;
class DashboardController extends Controller
{
    function  GetSummary(Request $request)
    {
        $user_id=$request->header('id');
        $product=Product::where("user_id",$user_id)->count();
        $categoty=Category::where("user_id",$user_id)->count();
        $invoice=Invoice::where("user_id",$user_id)->count();
        $customer=Customer::where("user_id",$user_id)->count();

        $total=Invoice::where("user_id",$user_id)->sum("total");
        $discount=Invoice::where("user_id",$user_id)->sum("discount");
        $payable=Invoice::where("user_id",$user_id)->sum("payable");
        $vat=Invoice::where("user_id",$user_id)->sum("vat");
        return [
            "product"=>$product,
            "category"=>$categoty,
            "invoice"=>$invoice,
            "customer"=>$customer,
            "total"=>$total,
            "payable"=>$payable,
            "vat"=>$vat,
            "discount"=>$discount,
        ];
    }
}
