<?php namespace App\Http\Controllers;

use App\Halo5\LeaderboardCollection;
use App\Halo5\SeasonCollection;
use App\Library\HaloClient;
use App\Http\Requests;
use App\Library\HaloHelper;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Input;

class HomeController extends Controller
{
    public function getIndex()
    {
        $seasons = $this->_getSeasons();
        
        return view('index', [
            'seasons' => $seasons
        ]);
    }

    public function getAbout()
    {
        return view('about');    
    }
    
    public function getPlaylist($seasonId, $playlistId = null)
    {
        $seasons = $this->_getSeasons();
        $season = HaloHelper::getSeason($seasons, $seasonId);
        $cache = 14440;
        
        // If Season isn't over. 10 minute cache
        if ($season->isActive)
        {
            $cache = 10;
        }

        // If no playlist passed, default to first one in season
        if ($playlistId == null)
        {
            $playlist = HaloHelper::firstPlaylist($season);
            $playlistId = $playlist->contentId;
        }
        else
        {
            $playlist = HaloHelper::getPlaylist($season, $playlistId);
        }

        $results = $this->_getLeaderboard("leaderboard/" . $seasonId . "/" . $playlistId, $cache);
        $paginator = $this->_buildPaginator($results, $seasonId, $playlistId);

        return view('leaderboard', [
            'season' => $season,
            'paginator' => $paginator,
            'playlistId' => $playlistId,
            'title' => $season->name . ": " . $playlist->name,
            'description' => "Leaderboard of " . $season->name . ": " . $playlist->name
        ]);
    }

    /**
     * @return SeasonCollection
     * @throws \Exception
     */
    private function _getSeasons()
    {
        $client = new HaloClient('seasons', 1200);
        return new SeasonCollection($client->request());
    }

    /**
     * @param $path
     * @param $cache
     * @return LeaderboardCollection
     * @throws \Exception
     */
    private function _getLeaderboard($path, $cache)
    {
        $client = new HaloClient($path, $cache);
        return new LeaderboardCollection($client->request());
    }

    /**
     * @param $results LeaderboardCollection
     * @param $seasonId string
     * @param $playlistId string
     * @return LengthAwarePaginator
     */
    private function _buildPaginator($results, $seasonId, $playlistId)
    {
        $results = collect($results);
        $page = Input::get('page', 1);
        $perPage = 40;

        $paginator = new LengthAwarePaginator(
            $results->forPage($page, $perPage), $results->count(), $perPage, $page
        );

        $paginator->setPath("/playlist/" . $seasonId . "/" . $playlistId);

        return $paginator;
    }
}
