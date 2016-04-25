<?php namespace App\Http\Controllers;

use App\Halo5\Models\Season;
use App\Http\Requests;

class HomeController extends Controller
{
    public function getIndex()
    {
        $seasons = Season::orderBy('startDate' , 'DESC')->get();
        
        return view('index', [
            'description' => 'Leaf has Halo 5 Leaderboards for all seasons past and present.',
            'seasons' => $seasons
        ]);
    }

    public function getAbout()
    {
        return view('about');    
    }
}
