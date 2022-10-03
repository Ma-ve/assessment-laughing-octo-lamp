<?php

declare(strict_types=1);

namespace App\Commands\Requests;

use App\Commands\Requests\CleaningSchedule;
use Illuminate\Console;

class CleaningScheduleRequest {

    public function __construct(
        public readonly CleaningSchedule\Months             $months,
        public readonly CleaningSchedule\Enums\ExportFormat $format
    ) {
    }

    public static function createFromConsoleCommand(Console\Command $command): self {
        return new self(
            new CleaningSchedule\Months((int)$command->argument('months')),
            self::createExportFormatEnum($command->option('format'))
        );
    }

    private static function createExportFormatEnum(bool|array|string|null $argument): CleaningSchedule\Enums\ExportFormat {
        return match ($argument) {
            'text-calendar' => CleaningSchedule\Enums\ExportFormat::TextCalendar,
            default         => CleaningSchedule\Enums\ExportFormat::Csv,
        };
    }


}
