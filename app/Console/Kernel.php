<?php

namespace App\Console;

use App\Models\Weather;
use App\Weather\WeatherClient;
use Exception;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->call(static function () {
            try {
                $weatherClient = new WeatherClient(WeatherClient::OPENWEATHERMAP);
                $response = $weatherClient->current(['city' => 'istanbul']);
                Weather::create($response);
            } catch (Exception $exception) {
                // TODO handle $expection
                dd($exception->getMessage());
            }
        })->hourly();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
