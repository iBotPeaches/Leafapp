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
        return redirect()->route('leaderboard', [
            'season' => $season,
            'playlist' => $season->playlists()->first()
        ]);
    }

    /**
     * @param Season $season
     * @param Playlist $playlist
     * @return mixed
     */
    public function getLeaderboard(Season $season, Playlist $playlist)
    {
        $playlist->season_id = $season->id;
        $playlist->load('rankings');

        return view('leaderboard', [
            'season' => $season,
            'playlist' => $playlist,
            'rankings' => $playlist->rankings()->with('account', 'csrr')->paginate(40),
            'title' => $season->name . ": " . $playlist->name,
            'description' => "Leaderboard of Halo 5 - " . $season->name . ": " . $playlist->name
        ]);
    }
}
