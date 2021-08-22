<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use QuickBooksOnline\API\DataService\DataService;

class QuickBooksAPIController extends Controller
{
    /**
     * undocumented function
     *
     * @return void
     */
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

        // Get the Authorization URL from the SDK
        $authUrl = $OAuth2LoginHelper->getAuthorizationCodeURL();

        return $authUrl;
    }

    public function processCode()
    {
        $dataService = DataService::Configure(array(
            'auth_mode'         => 'oauth2',
            'ClientID'          => 'ABqpzCnBU2Tqefa5kIywpSncjP7tR5G1h1tsbt1EHtNZQnN2wD',
            'ClientSecret'      => '1qArFLV72ug37skhciuRBD3TazW0lVJ9Nco1E9So',
            'RedirectURI'       => 'https://developer.intuit.com/v2/OAuth2Playground/RedirectUrl',
            'scope'             => 'com.intuit.quickbooks.accounting openid profile email phone address',
            'baseUrl'           => "development"
        ));

        $OAuth2LoginHelper  = $dataService->getOAuth2LoginHelper();
        $parseUrl           = $this->parseAuthRedirectUrl($_SERVER['QUERY_STRING']);

        /*
     * Update the OAuth2Token
     */
        $accessToken = $OAuth2LoginHelper->exchangeAuthorizationCodeForToken($parseUrl['code'], $parseUrl['realmId']);
        $dataService->updateOAuth2Token($accessToken);

        /*
     * Setting the accessToken for session variable
     */
        $_SESSION['sessionAccessToken'] = $accessToken;

        $this->index();
    }

    private function parseAuthRedirectUrl($url)
    {
        parse_str($url, $qsArray);
        return array(
            'code'      => $qsArray['code'],
            'realmId'   => $qsArray['realmId']
        );
    }
}
