<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class CurrentWeatherListCoordinateJob implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $transformer = app()->make(\App\Transformers\CoordinateItemTransformer::class);

        $services = [];
        foreach (config('api.endpoints') as $endpoint) {
            $services[] = app()->make($endpoint['features']['current_temp']);
        }

        foreach (\App\Models\Coordinate::cursor() as $model) {
            $dto = $transformer->fromModel($model);

            foreach ($services as $featureService) {
                CurrentWeatherJob::dispatch($dto, $featureService);
            }
        }
    }
}
