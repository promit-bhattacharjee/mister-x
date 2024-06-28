<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Spatie\LaravelIgnition\Recorders\DumpRecorder\Dump;

class ReportController extends Controller
{
    public function ReportPage()
    {
        return view("pages.dashboard.report-page");
    }

    public function SaleReport(Request $request)
    {
        $user_id = $request->header("id");
        $to = date("Y-m-d", strtotime($request->input('from')));
        $from = date("Y-m-d", strtotime($request->input('to')));

        $total = Invoice::where("user_id", $user_id)
                        ->whereDate("created_at", ">=", $from)
                        ->whereDate("created_at", "<=", $to)
                        ->sum("total");

        $vat = Invoice::where("user_id", $user_id)
                      ->whereDate("created_at", ">=", $from)
                      ->whereDate("created_at", "<=", $to)
                      ->sum("vat");

        $payable = Invoice::where("user_id", $user_id)
                          ->whereDate("created_at", ">=", $from)
                          ->whereDate("created_at", "<=", $to)
                          ->sum("payable");

        $discount = Invoice::where("user_id", $user_id)
                           ->whereDate("created_at", ">=", $from)
                           ->whereDate("created_at", "<=", $to)
                           ->sum("discount");

        $list = Invoice::where("user_id", $user_id)
                       ->whereDate("created_at", ">=", $from)
                       ->whereDate("created_at", "<=", $to)
                       ->with("customer")
                       ->get();

        $data = [
            'payable' => $payable,
            'discount' => $discount,
            'total' => $total,
            'vat' => $vat,
            'list' => $list,
            'from' => $from,
            'to' => $to
        ];

        // Generate PDF using the SaleReport view and data
        $pdf = Pdf::loadView("report.SaleReport");

        // Optionally, set PDF properties like paper size, orientation, etc.
        // $pdf->setPaper('A4', 'landscape');

        // Return the PDF as a response to download or view
        return $pdf->download('sale_report.pdf');
    }
}
