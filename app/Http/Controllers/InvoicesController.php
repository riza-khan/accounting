<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use QuickBooksOnline\API\Facades\Invoice;

class InvoicesController extends Controller
{
    public function batchInvoices()
    {
        $invoices = \App\Models\Invoice::get();
        $chunks = array_chunk($invoices, 30);

        foreach ($chunks as $key => $value) {

            $batch[$key] = $this->dataService()->CreateNewBatch();
            foreach ($value as $invoice) {
                $newInvoice = Invoice::create([
                    "Line" => [
                        [
                            "Amount"              => $invoice->amount,
                            "DetailType"          => "SalesItemLineDetail",
                            "SalesItemLineDetail" => [
                                "ItemRef" => [
                                    "value" => 1,
                                    "name"  => "Services"
                                ]
                            ]
                        ]
                    ],
                    "CustomerRef" => [
                        "value" => 1
                    ]
                ]);
                $batch[$key]->AddEntity($newInvoice, $invoice->invoice_number, "Create");
            }
            $batch[$key]->Execute();
        }
    }
}
