<?php

declare(strict_types=1);

namespace App\Commands\Requests\CleaningSchedule\Enums;

enum ExportFormat {

    case Csv;
    case TextCalendar;

}
