<?php

declare(strict_types=1);

namespace App\CleaningSchedule\Activities;

use DateInterval;
use RRule\RRule;

class Vacuuming extends BaseActivity {

    public function getName(): string {
        return 'Vacuuming';
    }

    public function getSchedule(): RRule {
        return new RRule([
            'FREQ'     => 'WEEKLY',
            'INTERVAL' => 1,
            'BYDAY'    => 'TU,TH',
        ]);
    }

    public function dependsOn(): array {
        return [];
    }

    public function getTimeItTakes(): DateInterval {
        return new DateInterval('PT21M');
    }
}
