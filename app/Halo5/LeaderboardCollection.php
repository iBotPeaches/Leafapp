<?php

namespace App\Halo5;

use App\Halo5\Definitions\Record;
use Illuminate\Support\Collection;

/**
 * Class SeasonCol.
 * @property $items Record[]
 */
class LeaderboardCollection extends Collection
{
    public function __construct($response)
    {
        if (! isset($response['leaderboard'])) {
            throw new LeaderboardNotFoundException($response['message']);
        }

        $items = [];
        foreach ($response['leaderboard'] as $result) {
            $items[] = new Record($result);
        }

        parent::__construct($items);
    }
}

class LeaderboardNotFoundException extends \Exception
{
}
