<?php namespace App\Halo5\Definitions;

/**
 * Class Playlist
 * @package App\Halo5\Definitions
 * @property integer $id
 * @property string $contentId
 * @property string $name
 * @property string $description
 * @property boolean $isRanked
 * @property string $imageUrl
 * @property boolean $isActive
 * @property string $gameMode
 * @property array $pivot
 */
class Playlist extends Model
{
    /**
     * @param $value
     * @return mixed
     */
    public function sIsActive($value)
    {
        return boolval($value);
    }

    /**
     * @param $value
     * @return mixed
     */
    public function sIsRanked($value)
    {
        return boolval($value);
    }
}