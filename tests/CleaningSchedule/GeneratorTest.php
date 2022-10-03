<?php

declare(strict_types=1);

namespace Tests\CleaningSchedule;

use App\CleaningSchedule\Activities\PlannedActivity;
use App\CleaningSchedule\Generator;
use App\Commands\Requests\CleaningSchedule\Months;
use DateTimeImmutable;
use Illuminate\Support\Collection;
use Tests\TestCase;

class GeneratorTest extends TestCase {


    /**
     * @dataProvider providesDataFor_test_it_generates_successfully
     */
    public function test_it_generates_successfully(
        string $dateTime,
        int    $months,
        array  $expectedData
    ) {
        $formattedPlannedActivities = $this->getFormattedPlannedActivities(
            $this->getPlannedActivitiesForData($dateTime, $months)
        );

        self::assertEquals($expectedData, $formattedPlannedActivities);
    }

    public function providesDataFor_test_it_generates_successfully(): array {
        return [
            'single month, starting at the first working day of October 2022'    => [
                '2022-10-03',
                1,
                [
                    '2022-10-04 - Vacuuming',
                    '2022-10-04 - Refrigerator cleaning',
                    '2022-10-06 - Vacuuming',
                    '2022-10-11 - Vacuuming',
                    '2022-10-13 - Vacuuming',
                    '2022-10-18 - Vacuuming',
                    '2022-10-20 - Vacuuming',
                    '2022-10-25 - Vacuuming',
                    '2022-10-27 - Vacuuming',
                    '2022-10-31 - Window cleaning',
                    '2022-11-01 - Vacuuming',
                    '2022-11-01 - Refrigerator cleaning'
                ]
            ],
            'single month, starting at the first day of October 2022'            => [
                '2022-10-01',
                1,
                [
                    '2022-10-04 - Vacuuming',
                    '2022-10-04 - Refrigerator cleaning',
                    '2022-10-06 - Vacuuming',
                    '2022-10-11 - Vacuuming',
                    '2022-10-13 - Vacuuming',
                    '2022-10-18 - Vacuuming',
                    '2022-10-20 - Vacuuming',
                    '2022-10-25 - Vacuuming',
                    '2022-10-27 - Vacuuming',
                    '2022-10-31 - Window cleaning',
                ]
            ],
            'single month, starting at the last (working) day of September 2022' => [
                '2022-09-30',
                1,
                [
                    '2022-10-04 - Vacuuming',
                    '2022-10-04 - Refrigerator cleaning',
                    '2022-10-06 - Vacuuming',
                    '2022-10-11 - Vacuuming',
                    '2022-10-13 - Vacuuming',
                    '2022-10-18 - Vacuuming',
                    '2022-10-20 - Vacuuming',
                    '2022-10-25 - Vacuuming',
                    '2022-10-27 - Vacuuming',
                ]
            ],
        ];
    }

    private function getPlannedActivitiesForData(string $dateTime, int $months): Collection {
        return (new Generator(new DateTimeImmutable($dateTime)))
            ->generateSchedule(new Months($months));
    }

    private function getFormattedPlannedActivities(Collection $collection): array {
        return $collection->map(
            function(PlannedActivity $activity) {
                return sprintf(
                    '%s - %s',
                    $activity->dateTime->format('Y-m-d'),
                    $activity->activity->getName()
                );
            },
        )
                          ->all();
    }
}
