# Leviy Backend Assessment

## Setup

- Clone this repository
- Run `composer install`
- Run `php assessment-leviy cleaning-schedule 3` (optional: `--date=Y-m-d`)

## Directory layout
```
/
├─ app/
│  ├─ CleaningSchedule/
│  │  ├─ Activities/ # Contains all defined activities with their recurrence
│  │  ├─ Formatters/ # Output types (implemented: csv)
│  │  └─ Generator.php/ # Main class that takes care of aggregating activities, and parsing them
│  └─ Commands/
│  │  └─ Requests/ # Container class for console inputs
│ 
├─ tests/
│  └─ CleaningSchedule/ # Tests for business logic of the app/CleaningSchedule classes
```

## Usage
```
USAGE: assessment-leviy <command> [options] [arguments]

cleaning-schedule Determines the cleaning schedule for the next x months
test              Run the application tests

--

$ php assessment-leviy cleaning-schedule --help

Description:
  Determines the cleaning schedule for the next x months

Usage:
  cleaning-schedule [options] [--] <months>

Arguments:
  months                 Amount of months to generate the schedule for (required)

Options:
      --format[=FORMAT]   [default: "csv (allowed values: csv)"]
      --date[=DATE]       [default: "now"]

```

## Running tests && output

``` 
$ php assessment-leviy test

   PASS  Tests\App\CleaningSchedule\Formatters\Csv\FormatterTest
  ✓ format

   PASS  Tests\App\CleaningSchedule\Formatters\Csv\LineTest
  ✓ it contains one activity
  ✓ it contains two activities
  ✓ it has one duration
  ✓ it has merged two durations
  ✓ it has merged three durations
  ✓ it outputs array property

   PASS  Tests\CleaningSchedule\GeneratorTest
  ✓ it generates successfully with data set "single month, starting at the first working day of October 2022"
  ✓ it generates successfully with data set "single month, starting at the first day of October 2022"
  ✓ it generates successfully with data set "single month, starting at the last (working) day of September 2022"
```

---

**README** below copied from https://github.com/leviy/assessment-backend

---

## Introduction
As preparation for the interview we ask you to create a small
example application to gain an impression of your technical skills.

Use this assessment to showcase your knowledge of the language, framework,
best practices and principles. Do take into account, however, that we need
to be able to quickly find out how the solution works.

## Restrictions
This assessment is meant to demonstrate your knowledge and thus has no timing restriction.
You are free to use frameworks, libraries, databases etc.
Please state these in the documentation of your application.

## The assessment
Build a small command-line application for a fictional cleaning company that determines the cleaning
schedule of an office for the next three months.

The following rules apply:
- Vacuuming is done every Tuesday and Thursday
- The windows are cleaned on the last working day of the month
- The refrigerator is also cleaned on the first vacuuming day of every month

The following times have been set for the various activities:

| Activity              | Time       |
| --------------------- | ---------- |
| Vacuuming             | 21 minutes |
| Window cleaning       | 35 minutes |
| Refrigerator cleaning | 50 minutes |

The application must generate a CSV file containing the planning for the next three months.
The CSV file must contain a column with the date, a column with the activities to be performed,
and a column with the total time (in HH:MM format) required to perform the activities.
