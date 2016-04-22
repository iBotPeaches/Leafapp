<?php namespace App\Halo5\Definitions;

use Carbon\Carbon;

/**
 * Class Season
 * @package App\Halo5\Definitions
 * @property integer $id
 * @property string $contentId
 * @property string $name
 * @property Carbon $start_date
 * @property Carbon $end_date
 * @property boolean $isActive
 * 
 * @property Playlist[] $playlists
 */
class Season extends Model
{
    /**
     * Season constructor.
     * @param array $properties
     */
    public function __construct(array $properties)
    {
        $playlists = [];
        foreach ($properties['playlists'] as $playlist)
        {
            $playlists[] = new Playlist($playlist);
        }

        $properties['playlists'] = $playlists;
        
        parent::__construct($properties);
    }

    /**
     * @param $value Carbon
     * @return mixed
     */
    public function gStartDate($value)
    {
        return $value->format('M j o');
    }

    /**
     * @param $value Carbon
     * @return mixed
     */
    public function gEndDate($value)
    {
        return $value->format('M j o');
    }
    
    /**
     * @param $value
     * @return Carbon
     */
    public function sStartDate($value)
    {
        return new Carbon($value);
    }

    /**
     * @param $value
     * @return Carbon
     */
    public function sEndDate($value)
    {
        return new Carbon($value);
    }

    /**
     * @param $value
     * @return mixed
     */
    public function sIsActive($value)
    {
        return boolval($value);
    }
}