<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use QuickBooksOnline\API\DataService\DataService;

class QuickBooksAPIController extends Controller
{
    public function index(): string
    {
        # Establish the connection to the quick books here
        $dataService = DataService::Configure(array(
            'auth_mode'         => env('QUICKBOOKS_AUTH_MODE'),
            'ClientID'          => env('QUICKBOOKS_CLIENT_ID'),
            'ClientSecret'      => env('QUICKBOOKS_CLIENT_SECRET'),
            'RedirectURI'       => env('QUICKBOOKS_REDIRECT_URI'),
            'scope'             => env('QUICKBOOKS_SCOPES'),
            'baseUrl'           => "development"
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
            'auth_mode'         => env('QUICKBOOKS_AUTH_MODE'),
            'ClientID'          => env('QUICKBOOKS_CLIENT_ID'),
            'ClientSecret'      => env('QUICKBOOKS_CLIENT_SECRET'),
            'RedirectURI'       => env('QUICKBOOKS_REDIRECT_URI'),
            'scope'             => env('QUICKBOOKS_SCOPES'),
            'QBORealmID'        => $realmId,
            'baseUrl'           => "development"
        ));

        $OAuth2LoginHelper = $dataService->getOAuth2LoginHelper();
        $accessToken = $OAuth2LoginHelper->exchangeAuthorizationCodeForToken($code, $realmId);

        if (!$accessToken) {
            return response(['Server Error'], 500);
        }

        return response(['Tokens saved to database'], 200);
    }
}
