<?php

include "../../../lib/Loader.php";
spl_autoload_register(array("Loader", "MyLoader"));

$mapper = new PersonMapper();
$doctors = $mapper->findAll(array('role_fk' => 1));

$appointmentMapper = new AppointmentMapper();

foreach ($doctors as $doctor) {
    $appointments = $appointmentMapper->findAll((array('physician_fk' => $doctor->getID())));
    if($appointments != null){
        foreach($appointments as $appointment){
            if($appointment->getPatientFK()->getID() == null)
                $items[$doctor->getFullName()] = htmlentities($doctor->getID());
        }
        
    }
}
$response = isset($_GET['callback']) ? $_GET['callback'] . "(" . json_encode($items) . ")" : json_encode($items);
echo $response;