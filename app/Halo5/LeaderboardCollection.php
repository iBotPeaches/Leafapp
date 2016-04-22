<?php namespace App\Halo5;

use App\Halo5\Definitions\Record;
use Illuminate\Support\Collection;

/**
 * Class SeasonCol
 * @package App\Halo5
 * @property $items Record[]
 */
class LeaderboardCollection extends Collection
{
    public function __construct($response)
    {
        $items = [];
        foreach ($response['leaderboard'] as $result)
        {
            $items[] = new Record($result);
        }

        parent::__construct($items);
    }
}