<?php

declare(strict_types=1);

namespace App\Commands\Requests\CleaningSchedule;

final class Months {

    public function __construct(
        public readonly int $months
    ) {
        if ($months < 1) {
            throw new \InvalidArgumentException('Must be at least 1 month');
        }

        if ($months > 36) {
            throw new \InvalidArgumentException('Must not be more than 36 months');
        }
    }

}
