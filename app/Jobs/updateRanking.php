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
        $placements = $this->recordPreviousPlacements();
        $this->deletePreviousRecords();

        /** @var $leaderboard Record */
        foreach ($this->leaderboard as $leaderboard) {
            /** @var Account $account */
            $account = Account::firstOrCreate(['gamertag' => $leaderboard->gamertag]);

            $record = new Ranking();
            $record->playlist_id = $this->playlist->id;
            $record->season_id = $this->season->id;
            $record->account_id = $account->id;
            $record->csr_id = $leaderboard->csr->designationId;
            $record->rank = $leaderboard->rank;
            $record->tier = $leaderboard->csr->tier;
            $record->csr = $leaderboard->csr->csr;

            if (isset($placements[$account->id])) {
                $record->lastCsr = $placements[$account->id]['csr'];
                $record->lastRank = $placements[$account->id]['rank'];
            }

            $record->save();
        }
    }

    /**
     * @return array
     */
    public function recordPreviousPlacements()
    {
        $return = [];

        /** @var Ranking[] $records */
        $records = Ranking::where('playlist_id', $this->playlist->id)
            ->where('season_id', $this->season->id)
            ->get();

        // Now with all records, we are going to dump them into account_id -> place array
        // then when we insert the new leaderboard, we can reference this array for
        // the previous place they got.
        foreach ($records as $record) {
            $return[$record->account_id] = [
                'csr' => $record->csr,
                'rank' => $record->rank,
            ];
        }

        return $return;
    }

    /**
     * @return mixed
     */
    public function deletePreviousRecords()
    {
        return Ranking::where('playlist_id', $this->playlist->id)
            ->where('season_id', $this->season->id)
            ->delete();
    }
}
