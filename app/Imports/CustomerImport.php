<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Illuminate\Support\Collection;
use QuickBooksOnline\API\Facades\Customer;

class CustomerImport extends Import implements WithBatchInserts, WithChunkReading, ToCollection
{
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            $this->qb->dataService();

            $batch = $this->qb->dataService()->CreateNewBatch();
            $newCustomer = Customer::create([
                "FullyQualifiedName" => "King Groceries",
                "PrimaryEmailAddr" => [
                    "Address" => "jdrew@myemail.com"
                ],
                "DisplayName" => "King's Groceries",
                "Suffix" => "Jr",
                "Title" => "Mr",
                "MiddleName" => "B",
                "Notes" => "Here are other details.",
                "FamilyName" => "King",
                "PrimaryPhone" => [
                    "FreeFormNumber" => "(555) 555-5555"
                ],
                "CompanyName" => "King Groceries",
                "BillAddr" => [
                    "CountrySubDivisionCode" => "CA",
                    "City" => "Mountain View",
                    "PostalCode" => "94042",
                    "Line1" => "123 Main Street",
                    "Country" => "USA"
                ],
                "GivenName" => "James"
            ]);

            $batch->AddEntity($newCustomer, $row[2], "create");
            $batch->Execute();
        }
    }
}
