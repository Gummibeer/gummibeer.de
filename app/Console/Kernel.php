<?php

namespace App\Console;

use App\Console\Commands\SchemaOrg;
use App\Console\Commands\StatsSteam;
use App\Console\Commands\StatsGithub;
use App\Console\Commands\StatsStrava;
use App\Console\Commands\StatsPackagist;
use Illuminate\Console\Scheduling\Schedule;
use Laravel\Lumen\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        StatsGithub::class,
        StatsSteam::class,
        StatsStrava::class,
        StatsPackagist::class,
        SchemaOrg::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('stats:steam')->hourly();
        $schedule->command('stats:strava')->hourly();
        $schedule->command('stats:github')->twiceDaily();
        $schedule->command('stats:packagist')->twiceDaily();
        $schedule->command('schema-org')->daily();
    }
}
