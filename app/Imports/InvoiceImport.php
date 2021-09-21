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
    }
}
