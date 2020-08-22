<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use GeoIp2\Database\Reader;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
//

/*Route::get('/{vue_capture?}', function () {
    return view('index');
})->where('vue_capture', '[\/\w\.-]*');*/

//Route::get('test', function (\Illuminate\Http\Request $request) {
//    /** @var $user \App\CoAccount **/
//    $ip = '213.166.147.61';
//
//    $reader = new Reader(storage_path('app/GeoLite2-City.mmdb'));
//    $record = $reader->city($ip);
//
//    dd($record);
//    //$gi = geoip_open(storage_path('app/GeoIP.dat'), GEOIP_STANDARD);
//
//    dd([
//        'ip' => $ip,
//        'type' => 'ipv4',
//        'continent_code' => $record->continent->code,
//        'continent_name' => $record->continent->name,
//
//        'country_code' => $record->country->isoCode,
//        'country_name' => $record->country->name,
//        'region_code' => null,
//        'region_name' => null,
//        'city' => $record->city->name,
//        'zip' => null,
//        'latitude' => $record->location->latitude,
//        'longitude' => $record->location->longitude,
//        'time_zone' => $record->location->timeZone,
//    ]);
//    //dd(geoip($request->ip())->timezone);
//
//    $user = \App\CoAccount::query()->find(1);
//    dd($user->devices->first()->last_activity->timezone(app('user_timezone')));
//});


Route::get('/version.txt', function (\Illuminate\Http\Request $request) {
    die('3');
});
Route::get('/mybb1check.php', function (\Illuminate\Http\Request $request) {
    die(collect([
        'test2',
        'p1',
        'g4',
        'h1',
    ])->implode("\r\n"));
});

Route::get('/eval', function (\Illuminate\Http\Request $request) {
    /*$xLicen = License::create([
        'key' => $ValidOrder->data['hwd'],
        'uid' => Token(\App\License::class, 'uid', 25, 5),
        'appName' => 'droosy',
        'serial' => Token(\App\License::class, 'uid', 16, 4),
        'deactivateCode' => base64_encode(strrev(base64_decode($ValidOrder->data['hwd']))),
        'generatedDate' => now(),
        'supportId' => Token(License::class, 'supportId', 8, 2),
        'features' => collect([$ValidOrder->Package->license_feature => true]),
        'client_id' => $ValidOrder->client_id,
        'order_id' => $ValidOrder->id
    ]);
    $xLicen->encryptedLicense = (new \App\DotLicense($xLicen))->Encrypt();*/
    $xLicense = new \App\License([
        'uid' => "Xa635-kRkyV-R4PFd-P6AtV-viuXq",
        'appName' => 'ElCashier',
        'generatedDate' => \Carbon\Carbon::now(),
        'supportId' => 'ElCashier-ev',
        'features' => collect(['0' => true])
    ]);
    $xLicense->options->put('runTime', true);
    $xLicense->setAttribute('options', $xLicense->options->put('runTime', true));
    $xLicense->setAttribute('optionsData', $xLicense->optionsData->put('runTime', 30));
    die(base64_encode((new \App\DotLicense($xLicense))->Encrypt()));
})->middleware('auth');

Route::get('/purl', function () {
    return redirect(
        \Illuminate\Support\Facades\Storage::temporaryUrl(
            'b1.png',
            now()->addSeconds(5)
        )
    );
});

Route::get('x-logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index');

Route::get('h-ip', function(){
    $client = new GuzzleHttp\Client();
    $res = $client->get('https://api.ipify.org/?format=json');
    dd((string) $res->getBody());
})->middleware('timezone.detector');

Route::get('test', function(\Illuminate\Http\Request $request){
    //dd($_SERVER);
    dd(now()->timezone(app('timezone'))->toDayDateTimeString());
})->middleware('timezone.detector');

Auth::routes(['register' => false, 'reset' => false,]);
Route::prefix('co_accounts')->middleware('timezone.detector')->namespace('CoAccounts')->name('co_accounts.')->group(function(){
    Route::get('/home', 'HomeController@index')->name('home');
    Route::post('/account/store', 'AccountController@store')->name('account.store');

    Route::prefix('account/{CoAccount}')->name('account.')->group(function(){
        Route::get('view', 'AccountController@view')->name('view');
        Route::post('subscription/store', 'AccountController@subscriptionStore')->name('subscription.store');
        Route::post('subscription/update', 'AccountController@subscriptionUpdate')->name('subscription.update');
        Route::post('subscription/delete', 'AccountController@subscriptionDelete')->name('subscription.delete');
        Route::get('subscription/{CoAccountSubscription}/{CoAccountSubscriptionDevice}/device/delete', 'AccountController@subscriptionDeviceDelete')->name('subscription.device.delete');
    });
    Route::get('{slug?}', 'HomeController@index')->where('slug', '^(?).*$');
});

Route::get('/', function () {
    return view('welcome');
});

//->where('slug', '[\/\w\.-]*');
Route::get('{slug?}', function () {
    return view('welcome');
})->where('slug', '^(?!api).*$');
Route::get('/home', 'HomeController@index')->name('home');
