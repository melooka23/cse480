<?php

$appointment_mapper = new AppointmentMapper();
if($this->current_person->getRoleFK()->getRole() == 'Patient'){
$my_upcoming_appointments = $appointment_mapper->findAll(array('patient_fk' => $this->current_person->getID()));
} else {
$my_upcoming_appointments = $appointment_mapper->findAll(array('physician_fk' => $this->current_person->getID()));
}

$mylist = null;

//create an array from the fields we actually want to see
foreach ($my_upcoming_appointments as $appointment) {
    if($appointment->getPatientFK()->getID() != null){
    $id = $appointment->getID();
    $mylist[$id]['Appointment Date'] = date("m/d/Y", strtotime($appointment->getDate()));
    $mylist[$id]['Time'] = $appointment->getAppointmentTimeFK()->getTime();
    if($this->current_person->getRoleFK()->getRole() == 'Patient'){
        $mylist[$id]['Physician'] = $appointment->getPhysicianFK()->getFullName();
    } else {
        $mylist[$id]['Patient'] = $appointment->getPatientFK()->getFullName();
    }
    $mylist[$id]['Reason For Visit'] = $appointment->getReasonForVisit();
    $mylist[$id]['Message From Patient'] = (($appointment->getExplanation()) ? ($appointment->getExplanation()) : "-");

    }
}

$this->ReturnView();
require($this->template);
