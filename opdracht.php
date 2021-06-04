<?php
// #1   21:00 - 03:00 per kwartier
// #2   21:00 - 00:00 3-9 komen binnen per kwartier
// #3   23:00 - 03:00 4-10 gaan weg per kwartier

$timeslots = [];

$openingsTijd = new DateTime();
$openingsTijd->setTime(21,0);

$sluitingsTijd = new DateTime();
$sluitingsTijd->setTime(3,0);
$sluitingsTijd->add(new DateInterval('P1D'));

$deurenDicht = new DateTime();
$deurenDicht->add(new DateInterval('P1D'));
$deurenDicht->setTime(0,0);

$mensenGaanWeg = new DateTime();
$mensenGaanWeg->setTime(23,0);

$variabele = createTimeslots($openingsTijd, $sluitingsTijd, $deurenDicht, $mensenGaanWeg);
//
//var_dump($variabele);


/**
 * @param $begin
 * @param $end
 *
 * #1
 */
function createTimeslots(DateTime $begin, DateTime $end, DateTime $doorsClosed, DateTime $peopleLeaving): array {
    $currentDate = clone $begin;
    $timeslots = [];

    $persons = 0;

    while ($currentDate <= $end) {
        $timeslots[] = [
            'date' => clone $currentDate,
            'persons' => 0
        ];

        $currentDate->add(new DateInterval('PT15M'));
    }

    foreach ($timeslots as $timeslot) {
        $date = $timeslot['date'];
        if ($date < $doorsClosed) {
            $persons += mt_rand(3, 9);
        }

        if ($date >= $peopleLeaving) {
            $persons -= mt_rand(4, 10);
        }

        if ($persons < 0) {
            $persons = 0;
        }

        echo $date->format('H:i') . ": " . $persons . " personen" . PHP_EOL;
    }

    return $timeslots;
}
