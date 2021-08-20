<?php

namespace App\Imports;

use App\Models\Car;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;

class CarsImport implements ToModel, WithBatchInserts
{
    use Importable;
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Car([
            'make' => $row[0],
            'model' => $row[1],
            'year' => $row[2],
        ]);
    }

    public function batchSize(): int
    {
        return 500;
    }
}
