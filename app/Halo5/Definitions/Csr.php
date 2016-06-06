<?php

namespace App\Halo5\Definitions;

use App\Library\HaloClient;

/**
 * Class Csr.
 * @property int $tier
 * @property int $designationId
 * @property int $csr
 */
class Csr extends Model
{
    /**
     * Csr constructor.
     * @param array $properties
     */
    public function __construct($properties)
    {
        // @todo remove this after the new DB thing is in place
        $client = new HaloClient('csrs', -1);
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
