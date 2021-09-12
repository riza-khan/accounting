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
                // Bill structure from API goes here
            ]);

            $batch->AddEntity($newInvoice, $row[2], "create");
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
