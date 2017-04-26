<?php

//GET VARIABLES
$appointment_id = filter_input(INPUT_GET, 'appointment_id');

//BUTTONS
$submitEMR = filter_input(INPUT_POST, "submitEMR");

//ARRAYS
$emr_fields = filter_input(INPUT_POST, 'emr', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);

//MAPPERS
$emrMapper = new EMRMapper();
$appointmentMapper = new AppointmentMapper();
$patientMapper = new PatientMapper();

//FIND APPOINTMENT
if(isset($appointment_id)){
    $appointment_for_record = $appointmentMapper->findBy(array('id' => $appointment_id));
} else{
    Utils::redirect('Main', 'list');
}

//FIND EMR FOR THIS APPOINTMENT
$existingEMR = $emrMapper->findBy(array('appointment_fk' => $appointment_id));

//REDIRECT IF NOT EXIST, OTHERWISE, CONTINUE
if($existingEMR == null){
    Utils::redirect('EMR', 'EMRDisplay', array('appointment_id' => $appointment_id));
}

//PATIENT INFO
$patient = $patientMapper->findBy(array('person_fk' => $appointment_for_record->getPatientFK()->getID()));

if(isset($submitEMR)){
    $updateEMR = new EMR($emr_fields);
    $updateEMR->setID($existingEMR->getID());
    $emrMapper->update($updateEMR);
}

//AFTER UPDATE, GET EMR AGAIN
//FIND EMR FOR THIS APPOINTMENT
$existingEMR = $emrMapper->findBy(array('appointment_fk' => $appointment_id));

    $this->ReturnView();
    require($this->template);