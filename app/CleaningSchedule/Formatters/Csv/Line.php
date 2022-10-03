<?php

declare(strict_types=1);

namespace App\CleaningSchedule\Formatters\Csv;

use DateInterval;
use DateTime;
use DateTimeInterface;

final class Line {

    public array $activities;

    public function __construct(
        public DateTimeInterface $date,
        string $activity,
        public DateInterval $timeNeededInDuration
    ) {
        $this->activities[] = $activity;
    }

    public function addActivity(string $activity): self {
        $this->activities[] = $activity;

        return $this;
    }

    public function addDuration(DateInterval $dateInterval): self {
        $this->timeNeededInDuration = $this->mergeDateIntervals($this->timeNeededInDuration, $dateInterval);

        return $this;
    }

    /**
     * @see https://stackoverflow.com/a/11556878/1255033
     */
    private function mergeDateIntervals(DateInterval $timeNeededInDuration, DateInterval $dateInterval): DateInterval {
        $dateTime = new DateTime('00:00');
        $b = clone $dateTime;
        $dateTime->add($timeNeededInDuration);
        $dateTime->add($dateInterval);

        return $b->diff($dateTime);
    }

    public function toArray(): array {
        return [
            $this->date->format('Y-m-d'),
            implode(',', $this->activities),
            $this->timeNeededInDuration->format('%H:%I')
        ];
    }
}
