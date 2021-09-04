<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use QuickBooksOnline\API\DataService\DataService;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class ConnectionController extends Controller
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
}
