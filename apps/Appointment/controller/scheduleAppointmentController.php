<?php

//ARRAYS

//VARIABLES
$time = filter_input(INPUT_POST, "time");
$problem = filter_input(INPUT_POST, "problem");
$message = filter_input(INPUT_POST, "message");


//BUTTONS
$book = filter_input(INPUT_POST, "book");

//MAPPERS
$patientProfileMapper = new PatientMapper();
$appointmentMapper = new AppointmentMapper();

$dbAppointment = $appointmentMapper->FindBy(array('id' => $time));

if (isset($time)) {//second pass
    $this->thisappointment = $dbAppointment;
} else { //first pass - new Profile - Does not exist in database
    $this->thisappointment = new Appointment();
}


if(isset($book)){
    $this->thisappointment->setPatientFK($this->current_person->getID());
    $this->thisappointment->setReasonForVisit($problem);
    $this->thisappointment->setExplanation($message);
    
    $appointmentMapper->update($this->thisappointment);
    
}
    
     $patientProfile = $patientProfileMapper->findBy(array('person_fk' => $this->current_person->getID()));

    $this->ReturnView();
    require($this->template);