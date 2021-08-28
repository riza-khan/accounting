<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use QuickBooksOnline\API\Core\Http\Serialization\XmlObjectSerializer;
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
        $allInvoices = $dataService->Query("SELECT * FROM Invoice");

        return response([
            'company'  => $companyData,
            'invoices' => $allInvoices
        ], 200);
    }
}
