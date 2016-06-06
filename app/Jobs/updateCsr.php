<?php

namespace App\Jobs;

use App\Halo5\Models\Csr;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class updateCsr extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    /**
     * @var array
     */
    protected $csr;

    /**
     * updateRanking constructor.
     * @param array $csr
     */
    public function __construct(array $csr)
    {
        $this->csr = $csr;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $record = Csr::where('id', $this->csr['designationId'])->first();

        if ($record == null) {
            $csr = new Csr();
            $csr->id = $this->csr['designationId'];
            $csr->name = $this->csr['name'];
            $csr->tiers = $this->csr['tiers'];
            $csr->save();
        }
    }
}
