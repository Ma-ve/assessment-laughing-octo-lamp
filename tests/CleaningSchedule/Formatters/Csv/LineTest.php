<?php

declare(strict_types=1);

namespace Tests\App\CleaningSchedule\Formatters\Csv;

use App\CleaningSchedule\Activities\PlannedActivity;
use App\CleaningSchedule\Activities\RefrigeratorCleaning;
use App\CleaningSchedule\Activities\Vacuuming;
use App\CleaningSchedule\Activities\WindowCleaning;
use App\CleaningSchedule\Formatters\Csv\Formatter;
use App\CleaningSchedule\Formatters\Csv\Line;
use DateInterval;
use DateTime;
use Tests\TestCase;

class LineTest extends TestCase {

    public function testIt_contains_one_activity(): void {
        $sut = new Line(new DateTime('2022-01-01'), 'Vacuuming', new DateInterval('PT1H'));
        self::assertEquals(['Vacuuming'], $sut->activities);
    }

    public function testIt_contains_two_activities(): void {
        $sut = new Line(new DateTime('2022-01-01'), 'Vacuuming', new DateInterval('PT1H'));
        $sut->addActivity('Window cleaning');
        self::assertEquals(['Vacuuming', 'Window cleaning'], $sut->activities);
    }

    public function testIt_has_one_duration(): void {
        $sut = new Line(new DateTime('2022-01-01'), 'Vacuuming', new DateInterval('PT35M'));
        self::assertEquals('00:35', $sut->timeNeededInDuration->format('%H:%I'));
    }

    public function testIt_has_merged_two_durations(): void {
        $sut = new Line(new DateTime('2022-01-01'), 'Vacuuming', new DateInterval('PT35M'));
        $sut->addDuration(new DateInterval('PT27M'));
        self::assertEquals('01:02', $sut->timeNeededInDuration->format('%H:%I'));
    }

    public function testIt_has_merged_three_durations(): void {
        $sut = new Line(new DateTime('2022-01-01'), 'Vacuuming', new DateInterval('PT35M'));
        $sut->addDuration(new DateInterval('PT27M'));
        $sut->addDuration(new DateInterval('PT59M'));
        self::assertEquals('02:01', $sut->timeNeededInDuration->format('%H:%I'));
    }

    public function testIt_outputs_array_property(): void {
        $sut = new Line(new DateTime('2022-01-01'), 'Vacuuming', new DateInterval('PT35M'));
        $sut->addActivity('Window cleaning');
        $sut->addDuration(new DateInterval('PT27M'));
        self::assertEquals(
            [
                '2022-01-01',
                'Vacuuming,Window cleaning',
                '01:02'
            ],
            $sut->toArray()
        );
    }
}
