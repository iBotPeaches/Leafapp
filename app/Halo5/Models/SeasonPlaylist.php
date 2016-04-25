<?php namespace App\Halo5\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class SeasonPlaylist
 * @package App\Halo5\Models
 * @property integer $id
 * @property integer $season_id
 * @property integer $playlist_id
 * 
 * @property Season $season
 * @property Playlist $playlist
 */
class SeasonPlaylist extends Model {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'h5_season_playlists';

    /**
     * @var bool
     */
    public $timestamps = false;

    //---------------------------------------------------------------------------------
    // Accessors & Mutators
    //---------------------------------------------------------------------------------
    
    //---------------------------------------------------------------------------------
    // Public Methods
    //---------------------------------------------------------------------------------
}
