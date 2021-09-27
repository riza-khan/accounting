<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Illuminate\Support\Collection;
use QuickBooksOnline\API\Facades\Bill;

class BillImport extends Import implements WithBatchInserts, WithChunkReading, ToCollection
{
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            $this->qb->dataService();

            $batch = $this->qb->dataService()->CreateNewBatch();
            $newInvoice = Bill::create([
                "Line" => [
                    [
                        "DetailType" => "AccountBasedExpenseLineDetail",
                        "Amount" => $row[6],
                        "Id" => "1",
                        "AccountBasedExpenseLineDetail" => [
                            "AccountRef" => [
                                "value" => "7"
                            ]
                        ]
                    ]
                ],
                "VendorRef" => [
                    "value" => "56"
                ]
            ]);

            $batch->AddEntity($newInvoice, $row[2], "create");
            $batch->Execute();
        }
    }
}
