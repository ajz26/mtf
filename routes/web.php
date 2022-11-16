<?php

use Spatie\Crypto\Rsa\KeyPair;
use Spatie\Crypto\Rsa\PublicKey;
use Spatie\Crypto\Rsa\PrivateKey;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return ['Laravel' => app()->version()];
});




Route::get('test',function(){

    [$privateKey, $publicKey] = (new KeyPair('OPENSSL_ALGO_SHA256'))->generate();


    $privateKey = PrivateKey::fromString($privateKey);
    $publicKey  = PublicKey::fromString($publicKey);

    
    $message = 'cacerola la ola';

    dump($message);


    $hashed = $privateKey->encrypt($message);

    dump($hashed);

    $decrypted =  $publicKey->decrypt($hashed);


    dump($decrypted);


});