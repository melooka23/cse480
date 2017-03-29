<?php

include "../../../lib/Loader.php";
spl_autoload_register(array("Loader", "MyLoader"));

$doctor_fk = filter_input(INPUT_GET, "doctor_fk", FILTER_SANITIZE_NUMBER_INT);

$mapper = new AppointmentMapper();

if($doctor_fk){
    $appointmentDates = $mapper->findAll(array('physician_fk' => $doctor_fk));
} else {
    $appointmentDates = $mapper->findAll();   
}

foreach ($appointmentDates as $key => $date){
    $appointmentDate = strtotime($date->getDate());
    $today = strtotime("today");
    if(($appointmentDate - $today) < 0){
        unset($appointmentDates[$key]);
    }
}

foreach ($appointmentDates as $date) {
    if($date->getPatientFK()->getID() == null){
        $items[date('l, F j, Y', strtotime($date->getDate()))] = htmlentities($date->getID());
    }
}

$response = isset($_GET['callback']) ? $_GET['callback'] . "(" . json_encode($items) . ")" : json_encode($items);
echo $response;