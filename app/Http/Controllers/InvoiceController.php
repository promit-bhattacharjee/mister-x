<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Invoice;
use App\Models\InvoiceProduct;
use App\Models\Customer;

class InvoiceController extends Controller
{
    //view
    function salePage(){
        return view('pages.dashboard.sales-page');
    }

    function invoicePage(){
        return view('pages.dashboard.invoice-page');
    }

    function CreateInvoice(Request $request)
    {
        DB::beginTransaction();
        try {
            $user_id = $request->header('id');
            $total = $request->input('total');
            $discount = $request->input('discount');
            $vat = $request->input('vat');
            $payable = $request->input('payable');
            $customer_id = $request->input('customer_id');
            $invoice = Invoice::create([
                'user_id' => $user_id,
                'total' => $total,
                'discount' => $discount,
                'vat' => $vat,
                'payable' => $payable,
                'customer_id' => $customer_id,
            ]);
            $invoiceID = $invoice->id;
            $products = $request->input('products');
            foreach ($products as $eachProduct) {
                InvoiceProduct::create(
                    [
                        'invoice_id' => $invoiceID,
                        'user_id' => $user_id,
                        'product_id' => $eachProduct['product_id'],
                        'qty' => $eachProduct['qty'],
                        'sale_price' => $eachProduct['sale_price'],
                    ]
                );
            }
            DB::commit();
            return 1;
        } catch (Exception $e) {
            DB::rollBack();
            return 0;
        }
    }
    function getInvoice(Request $request)
    {
        $user_id=$request->header('id');
        return Invoice::where("user_id","=",$user_id)->with('customer')->get();
    }
    function DetailsInvoice(Request $request)
    {
        $user_id=$request->header('id');
        $customer_id=$request->input('customer_id');
        $invoice_id=$request->input('invoice_id');
        $customerDetails=Customer::where('user_id',"=",$user_id)->where("id","=",$customer_id)->first();
        $invoiceTotal=Invoice::where('user_id',"=",$user_id)->where('id','=',$invoice_id)->first();
        $invoiceProduct=InvoiceProduct::where('invoice_id',$invoice_id)->where('user_id',$user_id)->get();
        return array(
            "customer"=>$customerDetails,
            "invoice"=>$invoiceTotal,
            "product"=>$invoiceProduct
        );
    }
    function DeleteInvoice(Request $request)
    {
        $user_id=$request->header('id');
        $invoice_id=$request->input('invoice_id');
        DB::beginTransaction();
        try{
            InvoiceProduct::where("user_id","=",$user_id)->where("invoice_id","=",$invoice_id)->delete();
            Invoice::where("user_id","=",$user_id)->where("id","=",$invoice_id)->delete();
            DB::commit();
            return 1;
        }
        catch(Exception $e)
        {
            DB::rollBack();
            return 0;
        }
    }

}
