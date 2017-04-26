<?php

$appointment_mapper = new AppointmentMapper();
$emrMapper = new EMRMapper();


if($this->current_person->getRoleFK()->getRole() == 'Patient'){
$records = $emrMapper->findAll(array('patient_fk' => $this->current_person->getID()));
}

$mylist = null;

//create an array from the fields we actually want to see
foreach ($records as $record) {
    if($record->getPhysicianSignature() != null){
        $id = $record->getAppointmentFK()->getID();
        $mylist[$id]['Appointment Date'] = date("m/d/Y", strtotime($record->getAppointmentFK()->getDate()));
        $mylist[$id]['Time'] = $record->getAppointmentFK()->getAppointmentTimeFK()->getTime();
        $mylist[$id]['Physician'] = $record->getAppointmentFK()->getPhysicianFK()->getFullName();
        $mylist[$id]['Reason For Visit'] = $record->getAppointmentFK()->getReasonForVisit();
    }
}

$this->ReturnView();
require($this->template);
