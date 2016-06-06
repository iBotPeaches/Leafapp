<?php

namespace App\Halo5;

use App\Halo5\Definitions\Season;
use Illuminate\Support\Collection;

/**
 * Class SeasonCol.
 * @property $items Season[]
 */
class SeasonCollection extends Collection
{
    public function __construct($response)
    {
        $items = [];
        foreach ($response['seasons'] as $season) {
            $items[] = new Season($season);
        }

        parent::__construct($items);
    }
}
