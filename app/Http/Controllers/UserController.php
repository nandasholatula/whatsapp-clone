<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function status()
    {
        $client = new Client();
        $result = $client->request('GET', env('WA_URL') . 'status' . env('WA_TOKEN'))->getBody()->getContents();
        return $result;
    }

    public function qrCode()
    {
        $client = new Client();
        $result = $client->request('GET', env('WA_URL') . 'qr_code' . env('WA_TOKEN'))->getBody()->getContents();
        return $result;
    }

    public function me()
    {
        $client = new Client();
        $result = $client->request('GET', env('WA_URL') . 'me' . env('WA_TOKEN'))->getBody()->getContents();
        return $result;
    }

    public function getMe()
    {
        $user = auth()->user();
        $user->role = $user->getRoleNames();
        return $user;
    }
}
