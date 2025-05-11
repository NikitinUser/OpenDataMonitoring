<?php

namespace App\Jobs;

use App\Dto\CoordinateItemDto;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class CurrentWeatherJob implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public readonly CoordinateItemDto $dto,
        private $featureService,
    ) {
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $this->featureService->handle($this->dto);
    }
}
