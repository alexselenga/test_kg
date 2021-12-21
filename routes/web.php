<?php

use App\Mail\SendToAccount;
use App\Models\Account;
use Illuminate\Support\Facades\Mail;
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

Route::get('/', function (string $name) {
    $account = Account::query()->where('name', $name)->firstOrFail(); /** @var Account $account */

    foreach ($account->simCards as $simCard) {
        if (!$simCard->is_active) continue;

        Mail::to($account)->queue(new SendToAccount($simCard));
    }
//    return view('welcome');
});
