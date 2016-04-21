<?php namespace App\Http\Controllers;

use App\Library\HaloClient;
use App\Http\Requests;

class HomeController extends Controller
{
    public function getIndex()
    {
        $client = new HaloClient('seasons', 1200);

        return view('index', [
            'seasons' => $client->request()['seasons']
        ]);
    }
}
