<?php

declare(strict_types=1);

namespace App\CleaningSchedule\Activities;

use DateInterval;
use RRule\RRule;

abstract class BaseActivity {

    abstract public function getName(): string;

    abstract public function getSchedule(): RRule;

    abstract public function getTimeItTakes(): DateInterval;

}
