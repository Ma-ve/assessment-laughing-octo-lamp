# Leviy Backend Assessment

## Setup

- Clone this repository
- Run `composer install`
- Run `php assessment-leviy schedule:create`

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
