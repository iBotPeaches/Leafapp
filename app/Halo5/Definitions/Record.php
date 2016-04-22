<?php namespace App\Halo5\Definitions;

/**
 * Class Record
 * @package App\Halo5\Definitions
 * @property string $gamertag
 * @property integer $rank
 * @property Csr $csr
 */
class Record extends Model
{
    /**
     * Record constructor.
     * @param array $properties
     */
    public function __construct(array $properties)
    {
        $properties['csr'] = new Csr($properties['csr']);
        parent::__construct($properties);
    }

    /**
     * @param $value
     * @return string
     */
    public function gRank($value)
    {
        switch ($value)
        {
            case 1:
                return '1st';

            case 2:
                return '2nd';

            case 3:
                return '3rd';

            default:
                return $value . "th";
        }
    }
}