<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use PhpMqtt\Client\Facades\MQTT;
use App\Models\Device;

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
        // $schedule->command('inspire')->hourly();
        $schedule->call(function () {
        $mqtt = MQTT::connection();
    
        $mqtt->subscribe('prueba', function ($topic, $message) {
        //printf("Received message on topic [%s]: %s\n", $topic, $message);
        $device= new Device;
        $device->name=$topic;
        $device->key=$message;
        $device->save();
        }, 0);
        $mqtt->loop(true, true);
            
        })->daily();
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
