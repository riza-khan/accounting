<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use QuickBooksOnline\API\Facades\Invoice;
use QuickBooksOnline\API\DataService\DataService;

class QuickBooksAPIController extends Controller
{
    public function index(): string
    {
        # Establish the connection to the quick books here
        $dataService = DataService::Configure(array(
            'auth_mode'    => env('QUICKBOOKS_AUTH_MODE'),
            'ClientID'     => env('QUICKBOOKS_CLIENT_ID'),
            'ClientSecret' => env('QUICKBOOKS_CLIENT_SECRET'),
            'RedirectURI'  => env('QUICKBOOKS_REDIRECT_URI'),
            'scope'        => env('QUICKBOOKS_SCOPES'),
            'baseUrl'      => "development"
        ));

        $OAuth2LoginHelper = $dataService->getOAuth2LoginHelper();
        $authUrl = $OAuth2LoginHelper->getAuthorizationCodeURL();

        return $authUrl;
    }

    public function getAuthorizationTokens(Request $request)
    {
        $code = $request->input('code');
        $realmId = $request->input('realmId');

        $dataService = DataService::Configure(array(
            'auth_mode'    => env('QUICKBOOKS_AUTH_MODE'),
            'ClientID'     => env('QUICKBOOKS_CLIENT_ID'),
            'ClientSecret' => env('QUICKBOOKS_CLIENT_SECRET'),
            'RedirectURI'  => env('QUICKBOOKS_REDIRECT_URI'),
            'scope'        => env('QUICKBOOKS_SCOPES'),
            'QBORealmID'   => $realmId,
            'baseUrl'      => "development"
        ));

        $OAuth2LoginHelper = $dataService->getOAuth2LoginHelper();
        $accessToken = $OAuth2LoginHelper->exchangeAuthorizationCodeForToken($code, $realmId);

        User::where('id', Auth::user()->id)->update([
            'access_token_key' => $accessToken->getAccessToken(),
            'access_token_secret' => $accessToken->getRefreshToken(),
            'target_realm' => $realmId,
        ]);

        if (!$accessToken) {
            return response(['Server Error'], 500);
        }

        return response(['user' => Auth::user()], 200);
    }

    public function getInfo()
    {
        $dataService = DataService::Configure(array(
            'auth_mode'       => 'oauth2',
            'ClientID'        => env('QUICKBOOKS_CLIENT_ID'),
            'ClientSecret'    => env('QUICKBOOKS_CLIENT_SECRET'),
            'accessTokenKey'  => Auth::user()->access_token_key,
            'refreshTokenKey' => Auth::user()->acces_token_secret,
            'QBORealmID'      => Auth::user()->target_realm,
            'baseUrl'         => "Development"
        ));

        $dataService->setLogLocation("../../../storage/logs/quickbooks.log");
        $dataService->throwExceptionOnError(true);

        $companyData = $dataService->getCompanyInfo();

        return response([
            'company'  => $companyData,
        ], 200);
    }

    public function batchInvoices()
    {
        $dataService = DataService::Configure(array(
            'auth_mode'       => 'oauth2',
            'ClientID'        => env('QUICKBOOKS_CLIENT_ID'),
            'ClientSecret'    => env('QUICKBOOKS_CLIENT_SECRET'),
            'accessTokenKey'  => Auth::user()->access_token_key,
            'refreshTokenKey' => Auth::user()->acces_token_secret,
            'QBORealmID'      => Auth::user()->target_realm,
            'baseUrl'         => "Development"
        ));

        $batch = $dataService->CreateNewBatch();

        $invoices = \App\Models\Invoice::all()->take(30);

        foreach ($invoices as $invoice) {
            $newInvoice = Invoice::create([
                "Line" => [
                    [
                        "Amount" => $invoice->amount,
                        "DetailType" => "SalesItemLineDetail",
                        "SalesItemLineDetail" => [
                            "ItemRef" => [
                                "value" => 1,
                                "name" => "Services"
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

    public function getAllByCategory($request)
    {
        $dataService = DataService::Configure(array(
            'auth_mode'       => 'oauth2',
            'ClientID'        => env('QUICKBOOKS_CLIENT_ID'),
            'ClientSecret'    => env('QUICKBOOKS_CLIENT_SECRET'),
            'accessTokenKey'  => Auth::user()->access_token_key,
            'refreshTokenKey' => Auth::user()->acces_token_secret,
            'QBORealmID'      => Auth::user()->target_realm,
            'baseUrl'         => "Development"
        ));

        $dataService->setLogLocation("../../../storage/logs/quickbooks.log");
        $dataService->throwExceptionOnError(true);
        $allOfCategory = $dataService->Query("SELECT * FROM " . $request->category);
        $countOfCategory = $dataService->Query("SELECT COUNT(*) FROM " . $request->category);

        return response([
            $request  => $allOfCategory,
            "count" => $countOfCategory,
        ], 200);

    }
}
