<?php

namespace App\Console\Commands;

use App\Halo5\Definitions\Season;
use App\Halo5\LeaderboardCollection;
use App\Halo5\LeaderboardNotFoundException;
use App\Halo5\Models\Ranking;
use App\Halo5\Models\SeasonPlaylist;
use App\Halo5\SeasonCollection;
use App\Jobs\updateCsr;
use App\Jobs\updatePlaylist;
use App\Jobs\updateRanking;
use App\Jobs\updateSeason;
use App\Library\HaloClient;
use Illuminate\Console\Command;
use Illuminate\Foundation\Bus\DispatchesJobs;
use App\Halo5\Models\Playlist as PlaylistModel;
use App\Halo5\Models\Season as SeasonModel;

class UpdateFromPanda extends Command
{
    use DispatchesJobs;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'panda:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Pulls date from Panda (PandaLove) and updates playlists';

    /**
     * UpdateFromPanda constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        \DB::transaction(function() 
        {
            $client = new HaloClient('csrs', 5);
            $csrs = $client->request()['csrs'];

            foreach ($csrs as $csr)
            {
                $this->dispatch(new updateCsr($csr));
            }

            $client->setPath('seasons');
            $client->setCache(0);
            $seasonCollection = new SeasonCollection($client->request());

            $seasonCollection->each(function($season) use ($client)
            {
                /** @var $season Season */
                if ($season->contentId != "Nonseasonal")
                {
                    $this->info('Dispatching update for ' . $season->name);
                    
                    /** @var $mSeason SeasonModel */
                    $mSeason = SeasonModel::where('contentId', $season->contentId)->first();
                    if ($mSeason != null)
                    {
                        $old_future = $mSeason->endDate;
                    }
                    
                    // Now trigger a playlist update, then re-load the model with a query call.
                    // Hacky - rewrite
                    $this->dispatch(new updateSeason($season));
                    $mSeason = SeasonModel::where('contentId', $season->contentId)->first();
                    
                    if (isset($old_future) && $mSeason->endDate != $old_future)
                    {
                        $this->info('This endDate has changed so forcing an update of this Seasons playlists');
                        $mSeason->forceUpdate = true;
                    }

                    foreach ($season->playlists as $playlist)
                    {

                        $this->info('Dispatching update for playlist: ' . $playlist->name);
                        $this->dispatch(new updatePlaylist($playlist));

                        /** @var $mPlaylist PlaylistModel */
                        $mPlaylist = PlaylistModel::where('contentId', $playlist->contentId)->first();
                        $this->insertPlaylistRelation($mPlaylist, $mSeason);

                        $ranks = Ranking::where('season_id', $mSeason->id)
                            ->where('playlist_id', $mPlaylist->id)
                            ->count();

                        $this->info('Found ' . $ranks . ' records for the playlist.');

                        if ($ranks == 0 || $mSeason->isUpdateNeeded())
                        {
                            $this->info('Downloading leaderboard for ' . $mSeason->name . " (" . $mPlaylist->name . ")");
                            $client->setPath("leaderboard/" . $mSeason->contentId . "/" . $mPlaylist->contentId);
                            $client->setCache(1);

                            try
                            {
                                $leaderboardCollection = new LeaderboardCollection($client->request());
                                $this->dispatch(new updateRanking($leaderboardCollection, $mSeason, $mPlaylist));
                            }
                            catch (LeaderboardNotFoundException $e)
                            {
                                $this->error($e->getMessage());
                                $this->error($mSeason->name . " (" . $mPlaylist->name . ") was skipped due to not having records.");
                            }
                        }
                        else
                        {
                            $this->info('Update skipped as not needed for ' . $mSeason->name . " (" . $mPlaylist->name . ")");
                        }

                    }
                }
            });
            
            return true;
        });
    }

    /**
     * @param PlaylistModel $playlist
     * @param SeasonModel $season
     */
    private function insertPlaylistRelation(PlaylistModel $playlist, SeasonModel $season)
    {
        $record = SeasonPlaylist::where('playlist_id', $playlist->id)
            ->where('season_id', $season->id)
            ->first();
        
        if ($record == null)
        {
            $record = new SeasonPlaylist();
            $record->playlist_id = $playlist->id;
            $record->season_id = $season->id;
            $record->save();
        }
    }
}
