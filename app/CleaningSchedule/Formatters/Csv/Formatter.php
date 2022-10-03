<?php

declare(strict_types=1);

namespace App\CleaningSchedule\Formatters\Csv;

use App\CleaningSchedule\Activities\PlannedActivity;
use App\CleaningSchedule\Formatters\Exceptions\CannotFormat;
use Illuminate\Support\Collection;
use League\Csv\CannotInsertRecord;
use League\Csv\Exception;
use League\Csv\Writer;
use Webmozart\Assert\Assert;

final class Formatter {

    /**
     * @param Collection<PlannedActivity> $collection
     * @return string
     * @throws CannotFormat
     */
    public function format(Collection $collection): string {
        Assert::allIsInstanceOf($collection, PlannedActivity::class);

        $consolidatedDates = $this->consolidateActivitiesByDay($collection);

        $header = [
            'Date (Y-m-d)',
            'Activities (comma-separated)',
            'Time it takes (HH:MM)'
        ];

        $csv = Writer::createFromString();
        try {
            $csv->insertOne($header);
        } catch(CannotInsertRecord $exception) {
            throw CannotFormat::becauseInternalErrorOccurred($exception->getMessage());
        }
        $csv->insertAll($consolidatedDates);

        try {
            return $csv->toString();
        } catch(Exception $exception) {
            throw CannotFormat::becauseInternalErrorOccurred(sprintf('Failed calling Writer::toString: %s', $exception->getMessage()));
        }
    }

    /**
     * @param Collection<PlannedActivity> $collection
     * @return scalar[][]
     */
    private function consolidateActivitiesByDay(Collection $collection): array {
        /** @var Line[] $return */
        $return = [];
        foreach($collection as $plannedActivity) {
            $formattedDate = $plannedActivity->dateTime->format('Y-m-d');
            if(isset($return[$formattedDate])) {
                $return[$formattedDate]
                    ->addActivity($plannedActivity->activity->getName())
                    ->addDuration($plannedActivity->activity->getTimeItTakes());

                continue;
            }

            $return[$formattedDate] = new Line(
                $plannedActivity->dateTime,
                $plannedActivity->activity->getName(),
                $plannedActivity->activity->getTimeItTakes()
            );
        }

        return array_values(array_map(function(Line $line) {
            return $line->toArray();
        }, $return));
    }
}
