<?php namespace App\Halo5;

use App\Halo5\Models\Ranking;
use Illuminate\Support\Collection;

/**
 * Class HistoryCollection
 * @package App\Halo5
 */
class HistoryCollection extends Collection
{
    /**
     * HistoryCollection constructor.
     * @param $response Ranking[]
     */
    public function __construct($response)
    {
        $items = [];
        foreach ($response as $result)
        {
            $items[$result->season->id]['playlists'][] = $result;
            $items[$result->season->id]['season'] = $result->season;
        }

        usort($items, function ($a, $b)
        {
            return $a['season']['id'] - $b['season']['id'];
        });

        parent::__construct($items);
    }
}