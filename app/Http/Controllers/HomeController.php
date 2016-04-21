<?php namespace App\Http\Controllers;

use App\Library\HaloClient;
use App\Http\Requests;
use App\Library\HaloHelper;

class HomeController extends Controller
{
    public function getIndex()
    {
        $client = new HaloClient('seasons', 1200);

        return view('index', [
            'seasons' => $client->request()['seasons']
        ]);
    }

    public function getSeason($seasonId, $playlistId = null, $page = 0)
    {
        $client = new HaloClient('seasons', 1200);
        $cache = 14440;
        $season = HaloHelper::getSeason($client->request()['seasons'], $seasonId);

        // If Season isn't over. 10 minute cache
        if ($season['isActive'])
        {
            $cache = 10;
        }
        
        // If no playlist passed, default to first one in season
        if ($playlistId == null)
        {
            $playlist = HaloHelper::firstPlaylist($season);
            $playlistId = $playlist['contentId'];
        }

        $client->setPath("leaderboard/" . $seasonId . "/" . $playlistId);
        $results = $client->request();

        dd($results);
    }
}
