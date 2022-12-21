<?php

declare(strict_types=1);

namespace App\CleaningSchedule;

use App\CleaningSchedule\Activities;
use App\Commands\Requests\CleaningSchedule\Months;
use DateTime;
use DateTimeImmutable;
use Illuminate\Support\Collection;

class Generator {

    public function __construct(
        private readonly DateTimeImmutable $dateTime
    ) {
    }

    public function generateSchedule(Months $months) {
        return $this->getOccurrencesForActivities($months->months);
    }

    /**
     * @return Activities\BaseActivity[]
     */
    private function getActivities(): array {
        return [
            new Activities\Vacuuming(),
            new Activities\WindowCleaning(),
            new Activities\RefrigeratorCleaning(),
        ];
    }

    private function getDateTimeForMonths(int $months): DateTime {
        return DateTime::createFromInterface($this->dateTime)
            ->modify(sprintf('+%d months', $months));
    }

    /**
     * @return Collection<Activities\PlannedActivity>
     */
    private function getOccurrencesForActivities(int $months): Collection {
        $occurrences = [];
        foreach($this->getActivities() as $activity) {
            $occurrencesInActivity = $activity->getSchedule()->getOccurrencesBetween(
                DateTime::createFromInterface($this->dateTime),
                $this->getDateTimeForMonths($months)
            );
            var_dump(
                $activity->getSchedule()->getOccurrencesBetween(
                DateTime::createFromInterface($this->dateTime),
                $this->getDateTimeForMonths($months)
            ),
                $this->dateTime
            );
            exit;

            $occurrences = array_merge($occurrences, array_map(function(DateTime $dateTime) use ($activity) {
                return new Activities\PlannedActivity($dateTime, $activity);
            }, $occurrencesInActivity));
        }

        return collect($occurrences)
            ->sort(function(Activities\PlannedActivity $a, Activities\PlannedActivity $b) {
                return $a->dateTime <=> $b->dateTime;
            })
            ->values();
    }
}
