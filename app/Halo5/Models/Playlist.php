<?php namespace App\Halo5\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use App\Halo5\Models\Season as SeasonModel;

/**
 * Class Playlist
 * @package App\Halo5\Models
 * @property integer $id
 * @property string $contentId
 * @property integer $season_id
 * @property string $name
 * @property string $slug
 * @property string $description
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property boolean $isRanked
 *
 * @property SeasonModel $season
 * @property Ranking[] $rankings
 */
class Playlist extends Model {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'h5_playlists';

    /**
     * The attributes that are not mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * Some playlists are in the API, but internal and set as active.
     * While some clearly social playlists are as well, we will track
     * those, but ignore internal playlists.
     * 
     * @var array
     */
    protected $playlistBlacklist = [
        'eef52f20-860c-4ec2-84df-dda8947668cb' // 2p Progression
    ];

    public static function boot()
    {
        parent::boot();

        static::creating(function ($playlist)
        {
            /** @var $playlist Playlist */
            $playlist->slug = str_slug($playlist->name);
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
        return $this->hasMany('App\Halo5\Models\Ranking')
            ->where('season_id', $this->season_id)
            ->orderBy('rank');
    }

    public function isVisible()
    {
        return ! in_array($this->contentId, $this->playlistBlacklist);
    }
}