<?php

use Carbon\Carbon;

function getAllDaysInMonth($dateTime)
{

    // Create a DateTime object from the input string
    $date_object = new DateTime($dateTime);

    // Extract year and month from the DateTime object
    $year = $date_object->format('Y');
    $month = $date_object->format('m');

    $start_date = new DateTime("$year-$month-01");
    $end_date = (clone $start_date)->modify('last day of this month');

    $interval = new DateInterval('P1D');
    $date_period = new DatePeriod($start_date, $interval, $end_date->modify('+1 day'));

    $days = [];
    foreach ($date_period as $date) {

        $days[] = [
            'day_of_week' => $date->format('D'), // e.g., 'Sun'
            'day_of_month' => $date->format('j'),
            'year' => $date->format('Y'), // e.g., '1'
            'checkin' => $date->format('h:ia')

        ];
    }

    return $days;
}


function getmonth($date)
{
    // Convert to a DateTime object
    $date_object = new DateTime($date);
    return $date_object->format('F');
}


function getDay($date)
{
    // Convert to a DateTime object
    $date_object = new DateTime($date);
    return $date_object->format('j');
}


function getTime($date)
{
    // Convert to a DateTime object
    $date_object = new DateTime($date);
    return $date_object->format('h:ia');
}


function checkinStatus($date)
{
    $deadline = '8:30:59am';
    $date_object = new DateTime($date);
    $deadline_object = new DateTime($date_object->format('Y-m-d') . ' ' . $deadline);

    return $date_object <= $deadline_object ? 'intime' : 'late';
}

function earlyBird($date)
{
    $deadline = '8:20:00am';
    $date_object = new DateTime($date);
    $deadline_object = new DateTime($date_object->format('Y-m-d') . ' ' . $deadline);

    return $date_object <= $deadline_object ? 'early' : 'late';
}
