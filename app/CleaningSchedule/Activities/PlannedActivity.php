<?php

declare(strict_types=1);

namespace App\CleaningSchedule\Activities;

use DateTimeInterface;

final class PlannedActivity {

    public function __construct(
        public readonly DateTimeInterface $dateTime,
        public readonly BaseActivity $activity
    ) {
    }
}
