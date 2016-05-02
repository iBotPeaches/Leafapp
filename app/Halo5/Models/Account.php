<?php namespace App\Halo5\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Account
 * @package App\Halo5\Models
 * @property integer $id
 * @property string $slug
 * @property string $gamertag
 */
class Account extends Model {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'accounts';

    /**
     * The attributes that are not mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];
    
    /**
     * @var bool
     */
    public $timestamps = false;

    public static function boot()
    {
        parent::boot();
        
        static::creating(function ($account)
        {
            $account->slug = str_slug($account->gamertag);
        });
    }

    //---------------------------------------------------------------------------------
    // Accessors & Mutators
    //---------------------------------------------------------------------------------

    //---------------------------------------------------------------------------------
    // Public Methods
    //---------------------------------------------------------------------------------

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function rankings()
    {
        return $this->hasMany('App\Halo5\Models\Ranking', 'account_id', 'id')->orderBy('created_at');
    }
}