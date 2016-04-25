<?php namespace App\Halo5\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Ranking
 * @package App\Halo5\Models
 * @property integer $id
 * @property integer $playlist_id
 * @property integer $season_id
 * @property integer $account_id
 * @property integer $csr_id
 * @property integer $rank
 * @property integer $lastRank
 * @property integer $tier
 * @property integer $csr
 * @property integer $lastCsr
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @property Playlist $playlist
 * @property Season $season
 * @property Account $account
 * @property Csr $csrr
 */
class Ranking extends Model {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'h5_rankings';

    /**
     * The attributes that are not mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    public static function boot()
    {
        parent::boot();

        static::updating(function ($record)
        {
            /** @var Ranking $record */
            $record->lastRank = $record->getOriginal('rank');
            $record->lastCsr = $record->getOriginal('csr');
        });
    }

    //---------------------------------------------------------------------------------
    // Accessors & Mutators
    //---------------------------------------------------------------------------------

    public function getRankAttribute($value)
    {
        return $this->_getPrettyRank($value);
    }

    public function getLastRankAttribute($value)
    {
        return $this->_getPrettyRank($value);
    }

    //---------------------------------------------------------------------------------
    // Public Methods
    //---------------------------------------------------------------------------------

    public function account()
    {
        return $this->hasOne('App\Halo5\Models\Account', 'id', 'account_id');
    }

    public function season()
    {
        return $this->hasOne('App\Halo5\Models\Season', 'id', 'season_id');
    }

    public function playlist()
    {
        return $this->hasOne('App\Halo5\Models\Playlist', 'id', 'playlist_id');
    }

    public function csrr()
    {
        return $this->hasOne('App\Halo5\Models\Csr', 'id', 'csr_id');
    }
    
    public function image()
    {
        return $this->csrr->tiers[$this->tier];
    }

    public function hasChanged()
    {
        return $this->color() != '';
    }
    
    public function arrow()
    {
        if (! $this->season->isActive)
        {
            return '';
        }

        if ($this->isHigher())
        {
            return 'long arrow up';
        }

        if ($this->isLower())
        {
            return 'long arrow down';
        }
        
        return '';
    }

    /**
     * @param bool $label
     * @return string
     */
    public function color($label = false)
    {
        if (! $this->season->isActive)
        {
            return '';
        }

        if ($this->isHigher())
        {
            return $label ? 'green' : 'positive';
        }

        if ($this->isLower())
        {
            return $label ? 'red' : 'negative';
        }

        return '';
    }

    public function buildMessage()
    {
        if ($this->isHigher())
        {
            return $this->account->gamertag . ' went up from ' . $this->lastRank . ' place to ' . $this->rank . ' place.';
        }

        if ($this->isLower())
        {
            return $this->account->gamertag . ' dropped from ' . $this->lastRank . ' place to ' . $this->rank . ' place.';
        }
    }

    /**
     * @return bool
     */
    private function isHigher()
    {
        return $this->getOriginal('rank') < $this->getOriginal('lastRank') && $this->getOriginal('lastRank') != null;
    }

    /**
     * @return bool
     */
    private function isLower()
    {
        return $this->getOriginal('rank') > $this->getOriginal('lastRank') && $this->getOriginal('lastRank') != null;
    }

    /**
     * @param $value
     * @return string
     */
    private function _getPrettyRank($value)
    {
        switch ($value)
        {
            case 1: return '1st';
            case 2: return '2nd';
            case 3: return '3rd';
            default: return $value . "th";
        }
    }
}