<?php namespace App\Halo5\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Season
 * @package App\Halo5\Models
 * @property integer $id
 * @property string $contentId
 * @property string $name
 * @property string $slug
 * @property Carbon $startDate
 * @property Carbon $endDate
 * @property boolean $isActive
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property Playlist[] $playlists
 */
class Season extends Model {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'h5_seasons';

    /**
     * The attributes that are not mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * @var array
     */
    protected $dates = ['startDate', 'endDate'];

    /**
     * @var bool
     */
    public $forceUpdate = false;
    
    public static function boot()
    {
        parent::boot();

        static::creating(function ($season)
        {
            $season->slug = str_slug($season->name);
        });
    }

    //---------------------------------------------------------------------------------
    // Accessors & Mutators
    //---------------------------------------------------------------------------------

    public function setIsActiveAttribute($value)
    {
        $this->attributes['isActive'] = boolval($value);
    }

    //---------------------------------------------------------------------------------
    // Public Methods
    //---------------------------------------------------------------------------------

    public function getRouteKeyName()
    {
        return 'slug';
    }

    /**
     * @return Playlist[]
     */
    public function playlists()
    {
        return $this->belongsToMany('App\Halo5\Models\Playlist', 'h5_season_playlists')->orderBy('name');
    }

    /**
     * @param $slug
     * @return Playlist|null
     */
    public function getCorrectPlaylistViaSlug($slug)
    {
        foreach ($this->playlists as $playlist)
        {
            if ($slug == $playlist->slug)
            {
                return $playlist;
            }
        }
        
        return null;
    }

    /**
     * Boolean whether an update is needed on season.
     * @return bool
     */
    public function isUpdateNeeded()
    {
        $end = $this->endDate;
        $start = $this->startDate;
        $updated = $this->updated_at;
        
        if ((($end->isPast() && $updated->gt($end)) || $start->isFuture()) && ! $this->forceUpdate)
        {
            return false;
        }
        
        return true;
    }

    /**
     * @return bool
     */
    public function isFuture()
    {
        $date = $this->startDate;
        return $date->isFuture();
    }
}