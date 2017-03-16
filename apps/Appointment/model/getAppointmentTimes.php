<?php

include "../../../lib/Loader.php";
spl_autoload_register(array("Loader", "MyLoader"));

$appointment_fk = filter_input(INPUT_GET, "appointment_fk", FILTER_SANITIZE_NUMBER_INT);

$mapper = new AppointmentMapper();

$informationFromAppointment = $mapper->findBy(array('id' => $appointment_fk));

if($informationFromAppointment){
    $appointments = $mapper->findAll(array('date' => $informationFromAppointment->getDate(), 'physician_fk' => $informationFromAppointment->getPhysicianFK()->getID()));
} else {
    $appointments = $mapper->findAll();   
}

foreach ($appointments as $appointment) {
  $items[$appointment->getAppointmentTimeFK()->getTime()] = htmlentities($appointment->getID());
}

$response = isset($_GET['callback']) ? $_GET['callback'] . "(" . json_encode($items) . ")" : json_encode($items);
echo $response;