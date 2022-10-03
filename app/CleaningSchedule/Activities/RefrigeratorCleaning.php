<?php

declare(strict_types=1);

namespace App\CleaningSchedule\Activities;

use DateInterval;
use RRule\RRule;

class RefrigeratorCleaning extends BaseActivity {

    public function getName(): string {
        return 'Refrigerator cleaning';
    }

    public function getSchedule(): RRule {
        return new RRule([
            'FREQ'     => 'MONTHLY',
            'INTERVAL' => 1,
            'BYDAY'    => 'TU,TH',
            'BYSETPOS' => 1,
        ]);
    }

    public function dependsOn(): array {
        return [];
    }

    public function getTimeItTakes(): DateInterval {
        return new DateInterval('PT50M');
    }
}
