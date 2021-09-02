<?php

namespace App\Imports;

use App\Models\Invoice;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;

class InvoiceImport implements ToModel, WithBatchInserts
{

    use Importable;

    public $timestamps = false;
    /**
    * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new Invoice([
            'date'           => $row[0],
            'type'           => $row[1],
            'invoice_number' => $row[2],
            'contact'        => $row[3],
            'description'    => $row[4],
            'due_date'       => $row[5],
            'amount'         => $row[6],
            'last_modified'  => $row[7],
        ]);
    }

    public function batchSize(): int
    {
        return 500;
    }
}
