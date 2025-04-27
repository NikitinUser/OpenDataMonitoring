<?php

namespace App\Console\Commands;

use App\Sdk\Weatherapi\WeatherapiSdk;
use App\Sdk\Meteomatics\MeteomaticsSdk;
use Illuminate\Console\Command;

class CheckCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'check:weather';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(WeatherapiSdk $WeatherapiSdk, MeteomaticsSdk $meteomaticsSdk): int
    {
        $dto =  $WeatherapiSdk->getCurrentTemperature(implode(',', config('geo.moscow')));

        $dto = $meteomaticsSdk->getTemperatureByDatetime(
            implode(',', config('geo.moscow')),
            now()->format('Y-m-d\TH:i:s\Z')
        );

        return 1;
    }
}
