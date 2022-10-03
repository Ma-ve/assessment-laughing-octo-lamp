<?php

declare(strict_types=1);

namespace App\Commands;

use App\Commands\Requests\CleaningScheduleRequest;
use Illuminate\Console\Scheduling\Schedule;
use LaravelZero\Framework\Commands\Command;
use function Termwind\{render};

class CleaningScheduleCommand extends Command
{
    /**
     * @var string
     */
    protected $signature = 'cleaning-schedule
                            {months : Amount of months to generate the schedule for (required)}
                            {--format=csv}';

    /**
     * @var string
     */
    protected $description = 'Determines the cleaning schedule for the next x months';

    /**
     * @return mixed
     */
    public function handle()
    {
        $request = CleaningScheduleRequest::createFromConsoleCommand($this);

        render(sprintf(
            <<<'HTML'
            <div class="py-1 ml-2">
                <div class="px-1 bg-blue-300 text-black">Generating Cleaning Schedule...</div>
                <em class="ml-1">
                  Months: %d, format: %s.
                </em>
            </div>
            HTML,
            $request->months->months,
            $request->format->name
        ));
    }

    /**
     * Define the command's schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    public function schedule(Schedule $schedule)
    {
        // $schedule->command(static::class)->everyMinute();
    }
}
