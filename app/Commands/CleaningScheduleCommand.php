<?php

declare(strict_types=1);

namespace App\Commands;

use App\CleaningSchedule\Formatters;
use App\CleaningSchedule\Generator;
use App\Commands\Requests\CleaningScheduleRequest;
use Illuminate\Console\Scheduling\Schedule;
use LaravelZero\Framework\Commands\Command;
use function Termwind\{render};

class CleaningScheduleCommand extends Command {
    /**
     * @var string
     */
    protected $signature = 'cleaning-schedule
                            {months : Amount of months to generate the schedule for (required)}
                            {--format=csv (allowed values: csv)}
                            {--date=now} (any datetime parsable string)';

    /**
     * @var string
     */
    protected $description = 'Determines the cleaning schedule for the next x months';

    public function handle(): void {
        $request = CleaningScheduleRequest::createFromConsoleCommand($this);

        $scheduleCollection = (new Generator($request->dateTime))
            ->generateSchedule($request->months);

        echo $this->getFormatter($request->format)
                  ->format($scheduleCollection);
    }

    private function getFormatter(Requests\CleaningSchedule\Enums\ExportFormat $format) {
        return new Formatters\Csv\Formatter();
    }
}
