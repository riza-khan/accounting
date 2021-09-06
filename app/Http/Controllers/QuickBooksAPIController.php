<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class QuickBooksAPIController extends Controller
{

    public function getInfo()
    {
        $this->dataService()->setLogLocation("../../../storage/logs/quickbooks.log");
        $this->dataService()->throwExceptionOnError(true);

        $companyData = $this->dataService()->getCompanyInfo();

        return response([
            'company'  => $companyData,
        ], 200);
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
