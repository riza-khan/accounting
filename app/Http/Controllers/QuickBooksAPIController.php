<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use QuickBooksOnline\API\Facades\Invoice;
use QuickBooksOnline\API\DataService\DataService;

class QuickBooksAPIController extends Controller
{
    public function dataService()
    {
        return DataService::Configure(array(
            'auth_mode'       => 'oauth2',
            'ClientID'        => env('QUICKBOOKS_CLIENT_ID'),
            'ClientSecret'    => env('QUICKBOOKS_CLIENT_SECRET'),
            'accessTokenKey'  => Auth::user()->access_token_key,
            'refreshTokenKey' => Auth::user()->access_token_secret,
            'QBORealmID'      => Auth::user()->target_realm,
            'baseUrl'         => "Development"
        ));
    }

    public function getInfo()
    {
        $this->dataService()->setLogLocation("../../../storage/logs/quickbooks.log");
        $this->dataService()->throwExceptionOnError(true);

        $companyData = $this->dataService()->getCompanyInfo();

        return response([
            'company'  => $companyData,
        ], 200);
    }

    public function batchInvoices()
    {
        $batch = $this->CreateNewBatch();

        $invoices = \App\Models\Invoice::all()->take(30);

        foreach ($invoices as $invoice) {
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
            $batch->AddEntity($newInvoice, $invoice->invoice_number, "Create");
        }

        // Run a batch
        $batch->Execute();
        $error = $batch->getLastError();
        if ($error) {
            return response(['error' => $error], 500);
        }
    }

    public function getAllByCategory(Request $request, $category)
    {
        $this->dataService()->setLogLocation("../../../storage/logs/quickbooks.log");
        $this->dataService()->throwExceptionOnError(true);
        $allOfCategory   = $this->dataService()->Query("SELECT * FROM " . $category, $request->currentPage, $request->perPage);
        $countOfCategory = $this->dataService()->Query("SELECT COUNT(*) FROM " . $category);

        return response([
            $category => $allOfCategory,
            "count"   => $countOfCategory,
        ], 200);
    }

    public function batchDelete(Request $request, $category)
    {

        $chunks = array_chunk($request->data, 30);

        foreach ($chunks as $key => $value) {
            $batch[$key] = $this->dataService()->CreateNewBatch();

            foreach ($value as $id) {
                $item = $this->dataService()->FindById($category, $id);
                $batch[$key]->AddEntity($item, $id, "delete");
            }

            $batch[$key]->Execute();
        }

        return response()->json(['message' => 'Items Deleted'], 200);
    }
}
