<?php namespace App\Library;

use App\Halo5\Definitions\Playlist;
use App\Halo5\Definitions\Season;
use App\Halo5\SeasonCollection;

class HaloHelper
{
    /**
     * @param $seasons Season[]|SeasonCollection
     * @param $seasonId string
     * @return Season
     * @throws \Exception
     */
    public static function getSeason($seasons, $seasonId)
    {
        foreach ($seasons as $season)
        {
            if ($season->contentId == $seasonId)
            {
                return $season;
            }
        }
        
        throw new \Exception('Season Not Found');
    }

    /**
     * @param $season Season
     * @return Playlist
     * @throws \Exception
     */
    public static function firstPlaylist($season)
    {
        if (is_array($season->playlists))
        {
            return $season->playlists[0];
        }
        
        throw new \Exception('Playlist not found');
    }

    /**
     * @param $season Season
     * @param $playlistId
     * @return Playlist
     * @throws \Exception
     */
    public static function getPlaylist($season, $playlistId)
    {
        foreach ($season->playlists as $playlist)
        {
            if ($playlist->contentId == $playlistId)
            {
                return $playlist;
            }
        }
        
        throw new \Exception('Playlist not found.');
    }
}