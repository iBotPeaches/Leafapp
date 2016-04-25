<?php

namespace App\Jobs;

use App\Halo5\Definitions\Playlist;
use App\Halo5\Definitions\Record;
use App\Halo5\LeaderboardCollection;
use App\Halo5\Models\Account;
use App\Halo5\Models\Ranking;
use App\Halo5\Models\Season;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Halo5\Models\Playlist as PlaylistModel;
use App\Halo5\Models\Season as SeasonModel;

class updateRanking extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    /**
     * @var LeaderboardCollection
     */
    protected $leaderboard;

    /**
     * @var SeasonModel
     */
    protected $season;

    /**
     * @var PlaylistModel
     */
    protected $playlist;

    /**
     * updateRanking constructor.
     * @param LeaderboardCollection $leaderboardCollection
     * @param SeasonModel $season
     * @param PlaylistModel $playlist
     */
    public function __construct(LeaderboardCollection $leaderboardCollection, SeasonModel $season, PlaylistModel $playlist)
    {
        $this->leaderboard = $leaderboardCollection;
        $this->season = $season;
        $this->playlist = $playlist;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        /** @var $leaderboard Record */
        foreach ($this->leaderboard as $leaderboard)
        {
            $account = Account::firstOrCreate(['gamertag' => $leaderboard->gamertag]);
            
            /** @var Ranking $record */
            $record = Ranking::where('playlist_id', $this->playlist->id)
                ->where('season_id', $this->season->id)
                ->where('account_id', $account->id)
                ->first();

            if ($record === null)
            {
                $record = new Ranking();
                $record->playlist_id = $this->playlist->id;
                $record->season_id = $this->season->id;
                $record->account_id = $account->id;
                $record->csr_id = $leaderboard->csr->designationId;
                $record->rank = $leaderboard->rank;
                $record->tier = $leaderboard->csr->tier;
                $record->csr = $leaderboard->csr->csr;
                $record->save();
            }
            else
            {
                $record->rank = $leaderboard->rank;
                $record->csr_id = $leaderboard->csr->designationId;
                $record->csr = $leaderboard->csr->csr;
                $record->save();
            }
        }
    }
}
