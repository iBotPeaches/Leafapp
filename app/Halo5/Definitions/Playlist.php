<?php

namespace App\Halo5\Definitions;

/**
 * Class Playlist.
 * @property int $id
 * @property string $contentId
 * @property string $name
 * @property string $description
 * @property bool $isRanked
 * @property string $imageUrl
 * @property bool $isActive
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
