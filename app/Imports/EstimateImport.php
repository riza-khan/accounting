<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Illuminate\Support\Collection;
use QuickBooksOnline\API\Facades\Estimate;

class EstimateImport extends Import implements WithBatchInserts, WithChunkReading, ToCollection
{
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            $this->qb->dataService();

            $batch = $this->qb->dataService()->CreateNewBatch();
            $newEstimate = Estimate::create([
                [
                    "TotalAmt" => 31.5,
                    "BillEmail" => [
                        "Address" => "Cool_Cars@intuit.com"
                    ],
                    "CustomerMemo" => [
                        "value" => "Thank you for your business and have a great day!"
                    ],
                    "ShipAddr" => [
                        "City" => "Half Moon Bay",
                        "Line1" => "65 Ocean Dr.",
                        "PostalCode" => "94213",
                        "Lat" => "37.4300318",
                        "Long" => "-122.4336537",
                        "CountrySubDivisionCode" => "CA",
                        "Id" => "4"
                    ],
                    "PrintStatus" => "NeedToPrint",
                    "EmailStatus" => "NotSet",
                    "BillAddr" => [
                        "City" => "Half Moon Bay",
                        "Line1" => "65 Ocean Dr.",
                        "PostalCode" => "94213",
                        "Lat" => "37.4300318",
                        "Long" => "-122.4336537",
                        "CountrySubDivisionCode" => "CA",
                        "Id" => "4"
                    ],
                    "Line" => [
                        [
                            "Description" => "Pest Control Services",
                            "DetailType" => "SalesItemLineDetail",
                            "SalesItemLineDetail" => [
                                "TaxCodeRef" => [
                                    "value" => "NON"
                                ],
                                "Qty" => 1,
                                "UnitPrice" => 35,
                                "ItemRef" => [
                                    "name" => "Pest Control",
                                    "value" => "10"
                                ]
                            ],
                            "LineNum" => 1,
                            "Amount" => 35.0,
                            "Id" => "1"
                        ],
                        [
                            "DetailType" => "SubTotalLineDetail",
                            "Amount" => 35.0,
                            "SubTotalLineDetail" => []
                        ],
                        [
                            "DetailType" => "DiscountLineDetail",
                            "Amount" => 3.5,
                            "DiscountLineDetail" => [
                                "DiscountAccountRef" => [
                                    "name" => "Discounts given",
                                    "value" => "86"
                                ],
                                "PercentBased" => true,
                                "DiscountPercent" => 10
                            ]
                        ]
                    ],
                    "CustomerRef" => [
                        "name" => "Cool Cars",
                        "value" => "3"
                    ],
                    "TxnTaxDetail" => [
                        "TotalTax" => 0
                    ],
                    "ApplyTaxAfterDiscount" => false
                ]
            ]);

            $batch->AddEntity($newEstimate, $row[2], "create");
            $batch->Execute();
        }
    }
}
