<?php namespace App\Halo5\Definitions;

use App\Library\HaloClient;

/**
 * Class Csr
 * @package App\Halo5\Definitions
 * @property integer $tier
 * @property integer $designationId
 * @property integer $csr
 */
class Csr extends Model
{
    /**
     * Csr constructor.
     * @param array $properties
     */
    public function __construct($properties)
    {
        $client = new HaloClient("csrs", -1);
        $csr = $client->request();

        parent::__construct($properties, $csr['csrs'][$properties['designationId']]);
    }

    /**
     * @return mixed
     */
    public function gImage()
    {
        return $this->appends['tiers'][$this->tier];
    }

    public function gTitle()
    {
        return $this->appends['name'];
    }
}