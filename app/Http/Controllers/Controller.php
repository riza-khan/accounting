<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use QuickBooksOnline\API\DataService\DataService;
use Illuminate\Support\Facades\Auth;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

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
}
