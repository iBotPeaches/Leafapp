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
 *
 * @property SeasonModel $season
 * @property Ranking $ranking
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
}