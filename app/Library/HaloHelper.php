<?php namespace App\Library;

class HaloHelper
{

    /**
     * @param $seasons
     * @param $seasonId
     * @return bool
     * @throws \Exception
     */
    public static function getSeason($seasons, $seasonId)
    {
        foreach ($seasons as $season)
        {
            if ($season['contentId'] == $seasonId)
            {
                return $season;
            }
        }
        
        throw new \Exception('Season Not Found');
    }

    /**
     * @param $season
     * @return mixed
     * @throws \Exception
     */
    public static function firstPlaylist($season)
    {
        if (is_array($season['playlists']))
        {
            return $season['playlists'][0];
        }
        
        throw new \Exception('Playlist not found');
    }

    /**
     * @param $season
     * @param $playlistId
     * @return mixed
     * @throws \Exception
     */
    public static function getPlaylist($season, $playlistId)
    {
        foreach ($season['playlists'] as $playlist)
        {
            if ($playlist['contentId'] == $playlistId)
            {
                return $playlist;
            }
        }
        
        throw new \Exception('Playlist not found.');
    }
}