<?php

declare(strict_types=1);

namespace App\CleaningSchedule\Formatters\Exceptions;

use Exception;

class CannotFormat extends Exception {

    public static function becauseInternalErrorOccurred(string $originalMessage): self {
        return new self(sprintf('An internal error occurred: %s', $originalMessage));
    }
}
