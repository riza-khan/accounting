<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Illuminate\Support\Collection;
use QuickBooksOnline\API\Facades\Employee;

class EmployeeImport extends Import implements WithBatchInserts, WithChunkReading, ToCollection
{
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            $this->qb->dataService();

            $batch = $this->qb->dataService()->CreateNewBatch();
            $newEmployee = Employee::create([
                [
                    "GivenName" => "John",
                    "SSN" => "444-55-6666",
                    "PrimaryAddr" => [
                        "CountrySubDivisionCode" => "CA",
                        "City" => "Middlefield",
                        "PostalCode" => "93242",
                        "Id" => "50",
                        "Line1" => "45 N. Elm Street"
                    ],
                    "PrimaryPhone" => [
                        "FreeFormNumber" => "408-525-1234"
                    ],
                    "FamilyName" => "Meuller"
                ]
            ]);

            $batch->AddEntity($newEmployee, $row[2], "create");
            $batch->Execute();
        }
    }
}
