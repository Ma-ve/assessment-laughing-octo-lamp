<?php

declare(strict_types=1);

namespace App\CleaningSchedule\Activities;

use DateInterval;
use RRule\RRule;

class WindowCleaning extends BaseActivity {

    public function getName(): string {
        return 'Window cleaning';
    }

    public function getSchedule(): RRule {
        return new RRule([
            'FREQ'     => 'MONTHLY',
            'INTERVAL' => 1,
            'BYDAY'    => 'MO,TU,WE,TH,FR',
            'BYSETPOS' => -1,
        ]);
    }

    public function dependsOn(): array {
        return [];
    }

    public function getTimeItTakes(): DateInterval {
        return new DateInterval('PT35M');
    }
}
