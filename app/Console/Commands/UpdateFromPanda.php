<?php

namespace App\Console\Commands;

use App\Halo5\Definitions\Season;
use App\Halo5\LeaderboardCollection;
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
            $seasonCollection = new SeasonCollection($client->request());

            $seasonCollection->each(function($season) use ($client)
            {
                /** @var $season Season */
                if ($season->contentId != "Nonseasonal")
                {
                    $this->info('Dispatching update for ' . $season->name);
                    $this->dispatch(new updateSeason($season));

                    foreach ($season->playlists as $playlist)
                    {
                        if ($playlist->isRanked)
                        {
                            $this->info('Dispatching update for playlist: ' . $playlist->name);
                            $this->dispatch(new updatePlaylist($playlist));

                            /** @var $mPlaylist PlaylistModel */
                            /** @var $mSeason SeasonModel */
                            $mPlaylist = PlaylistModel::where('contentId', $playlist->contentId)->first();
                            $mSeason = SeasonModel::where('contentId', $season->contentId)->first();

                            $this->insertPlaylistRelation($mPlaylist, $mSeason);

                            $ranks = Ranking::where('season_id', $mSeason->id)
                                ->where('playlist_id', $mPlaylist->id)
                                ->count();

                            if ($ranks == 0 || $mSeason->isUpdateNeeded())
                            {
                                $this->info('Downloading leaderboard for ' . $mSeason->name . " (" . $mPlaylist->name . ")");
                                $client->setPath("leaderboard/" . $mSeason->contentId . "/" . $mPlaylist->contentId);
                                $client->setCache(5);

                                $leaderboardCollection = new LeaderboardCollection($client->request());
                                $this->dispatch(new updateRanking($leaderboardCollection, $mSeason, $mPlaylist));
                            }
                            else
                            {
                                $this->info('Update skipped as not needed for ' . $mSeason->name . " (" . $mPlaylist->name . ")");
                            }
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
