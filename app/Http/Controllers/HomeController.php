<?php namespace App\Http\Controllers;

use App\Library\HaloClient;
use App\Http\Requests;
use App\Library\HaloHelper;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Input;

class HomeController extends Controller
{
    public function getIndex()
    {
        $client = new HaloClient('seasons', 1200);

        return view('index', [
            'seasons' => $client->request()['seasons']
        ]);
    }

    public function getAbout()
    {
        return view('about');    
    }
    
    public function getPlaylist($seasonId, $playlistId = null)
    {
        $client = new HaloClient('seasons', 1200);
        $cache = 14440;
        $season = HaloHelper::getSeason($client->request()['seasons'], $seasonId);

        // If Season isn't over. 10 minute cache
        if ($season['isActive'])
        {
            $cache = 10;
        }

        $client->setCache($cache);
        
        // If no playlist passed, default to first one in season
        if ($playlistId == null)
        {
            $playlist = HaloHelper::firstPlaylist($season);
            $playlistId = $playlist['contentId'];
        }
        else
        {
            $playlist = HaloHelper::getPlaylist($season, $playlistId);
        }

        $client->setPath("leaderboard/" . $seasonId . "/" . $playlistId);
        $results = $client->request()['leaderboard'];

        $results = collect($results);
        $page = Input::get('page', 1);
        $perPage = 20;

        $paginator = new LengthAwarePaginator(
            $results->forPage($page, $perPage), $results->count(), $perPage, $page
        );

        $paginator->setPath("/playlist/" . $seasonId . "/" . $playlistId);

        return view('leaderboard', [
            'season' => $season,
            'paginator' => $paginator,
            'playlistId' => $playlistId,
            'title' => $season['name'] . ": " . $playlist['name'],
            'description' => "Leaderobard of " . $season['name'] . ": " . $playlist['name']
        ]);
    }
}
