<?php

$search = filter_input(INPUT_POST, "search", FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
$searchButton = filter_input(INPUT_POST, "searchButton");

$emrMapper = new EMRMapper();

if ($search) {
    foreach ($search as $key => $val) {
        if (is_string($val)) {
            if (trim($val) == "") {
                unset($search[$key]);
            }
        }
    }
}
if (!$search) {
    $search = [];
}

//VARIABLES
$mylist = null;

if ($searchButton) {
    $results = $emrMapper->searchRecords($search);
    
    foreach ($results as $record) {
        $id = $record->getAppointmentFK()->getID();
        $mylist[$id]['Appointment Date'] = date("m/d/Y", strtotime($record->getAppointmentFK()->getDate()));
        $mylist[$id]['Time'] = $record->getAppointmentFK()->getAppointmentTimeFK()->getTime();
        $mylist[$id]['Patient'] = $record->getAppointmentFK()->getPatientFK()->getFullName();
        $mylist[$id]['Reason For Visit'] = $record->getAppointmentFK()->getReasonForVisit();
    }
}


$this->ReturnView();
require($this->template);
