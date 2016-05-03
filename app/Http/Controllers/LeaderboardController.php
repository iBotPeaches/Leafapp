<?php namespace App\Http\Controllers;

use App\Halo5\Models\Playlist;
use App\Halo5\Models\Season;
use Illuminate\Http\Request;

use App\Http\Requests;

class LeaderboardController extends Controller
{
    /**
     * @param Season $season
     * @return mixed
     */
    public function getLeaderboardRedirect(Season $season)
    {
        $playlist = $season->playlists->first(function ($key, $value)
        {
            return $value->isVisible();
        });

        return redirect()->route('leaderboard', [
            'season' => $season,
            'playlist' => $playlist
        ]);
    }

    /**
     * @param Season $season
     * @param Playlist $playlist
     * @return mixed
     */
    public function getLeaderboard(Season $season, Playlist $playlist)
    {
        $playlist = $season->getCorrectPlaylistViaSlug($playlist->slug);
        $playlist->season_id = $season->id;
        $playlist->load('rankings');

        return view('leaderboard', [
            'season' => $season,
            'playlist' => $playlist,
            'rankings' => $playlist->rankings()->with('season', 'account', 'csrr')->paginate(50),
            'title' => $season->name . ": " . $playlist->name,
            'description' => "Leaderboard of Halo 5 - " . $season->name . ": " . $playlist->name
        ]);
    }
}
