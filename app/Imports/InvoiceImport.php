<?php

namespace App\Imports;

use QuickBooksOnline\API\Facades\Invoice;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Illuminate\Support\Collection;

class InvoiceImport extends Import implements WithBatchInserts, WithChunkReading, ToCollection
{
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            $this->qb->dataService();

            $batch = $this->qb->dataService()->CreateNewBatch();
            $newBill = Invoice::create([
                "Line" => [
                    [
                        "Amount"              => $row[6],
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

            $batch->AddEntity($newBill, $row[2], "create");
            $batch->Execute();
        }

        /* return new Invoice([ */
        /*     'date'           => $row[0], */
        /*     'type'           => $row[1], */
        /*     'invoice_number' => $row[2], */
        /*     'contact'        => $row[3], */
        /*     'description'    => $row[4], */
        /*     'due_date'       => $row[5], */
        /*     'amount'         => $row[6], */
        /*     'last_modified'  => $row[7], */
        /* ]); */
    }
}
