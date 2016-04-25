<?php namespace App\Jobs;

use App\Halo5\Definitions\Season;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Halo5\Models\Season as SeasonModel;

class updateSeason extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    /**
     * @var Season
     */
    protected $season;

    /**
     * Create a new job instance.
     *
     * @param Season $season
     */
    public function __construct(Season $season)
    {
        $this->season = $season;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try
        {
            $season = SeasonModel::where('contentId', $this->season->contentId)->firstOrFail();
            $season->endDate = $this->season->getRawProperty('end_date');
            $season->isActive = $this->season->isActive;
            $season->save();
        }
        catch (ModelNotFoundException $ex)
        {
            $season = new SeasonModel();
            $season->contentId = $this->season->contentId;
            $season->name = $this->season->name;
            $season->startDate = $this->season->getRawProperty('start_date');
            $season->endDate = $this->season->getRawProperty('end_date');
            $season->isActive = $this->season->isActive;
            $season->save();
        }
    }
}
