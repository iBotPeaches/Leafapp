<?php

namespace App\Halo5\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Csr.
 * @property int $id
 * @property string $name
 * @property array $tiers
 */
class Csr extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'h5_csrs';

    /**
     * The attributes that are not mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * @var bool
     */
    public $incrementing = false;

    /**
     * @var bool
     */
    public $timestamps = false;

    public static function boot()
    {
        parent::boot();
    }

    //---------------------------------------------------------------------------------
    // Accessors & Mutators
    //---------------------------------------------------------------------------------

    public function setTiersAttribute($value)
    {
        $this->attributes['tiers'] = json_encode($value);
    }

    public function getTiersAttribute($value)
    {
        return json_decode($value, true);
    }

    //---------------------------------------------------------------------------------
    // Public Methods
    //---------------------------------------------------------------------------------
}
