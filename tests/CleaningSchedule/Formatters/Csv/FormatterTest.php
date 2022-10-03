<?php

declare(strict_types=1);

namespace Tests\App\CleaningSchedule\Formatters\Csv;

use App\CleaningSchedule\Activities\PlannedActivity;
use App\CleaningSchedule\Activities\RefrigeratorCleaning;
use App\CleaningSchedule\Activities\Vacuuming;
use App\CleaningSchedule\Activities\WindowCleaning;
use App\CleaningSchedule\Formatters\Csv\Formatter;
use DateTime;
use Tests\TestCase;

class FormatterTest extends TestCase {

    public function setUp(): void {
        parent::setUp();
        $this->sut = new Formatter();
    }

    public function testFormat(): void {
        self::assertEquals(
            <<<TXT
"Date (Y-m-d)","Activities (comma-separated)","Time it takes (HH:MM)"
2022-01-01,"Vacuuming,Window cleaning,Refrigerator cleaning",01:46
2022-01-02,Vacuuming,00:21

TXT,
            $this->sut->format(collect([
                new PlannedActivity(new DateTime('2022-01-01'), new Vacuuming()),
                new PlannedActivity(new DateTime('2022-01-01'), new WindowCleaning()),
                new PlannedActivity(new DateTime('2022-01-01'), new RefrigeratorCleaning()),
                new PlannedActivity(new DateTime('2022-01-02'), new Vacuuming()),
            ]))
        );
    }
}
