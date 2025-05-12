<?php

namespace App\Jobs;

use App\Dto\CoordinateItemDto;
use App\Services\Features\Interfaces\CurrentTempInterface;
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
        private CurrentTempInterface $featureService,
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
