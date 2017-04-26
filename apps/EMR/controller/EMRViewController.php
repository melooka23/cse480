<?php
//GET VARIABLES
$appointment_id = filter_input(INPUT_GET, 'appointment_id');


//ARRAYS
$hpi_fields = filter_input(INPUT_POST, "hpi", FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
$ros_fields = filter_input(INPUT_POST, 'ros', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
$emr_fields = filter_input(INPUT_POST, 'emr', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);

//VARIABLES
$chief_complaint = filter_input(INPUT_POST, "chief_complaint", FILTER_DEFAULT);
$hpi_onset_number = filter_input(INPUT_POST, "hpi_onset_number", FILTER_DEFAULT);
$hpi_onset = filter_input(INPUT_POST, "hpi_onset", FILTER_DEFAULT);
$degree = filter_input(INPUT_POST, "degree", FILTER_DEFAULT);
$degreePresent = filter_input(INPUT_POST, "degreePresent", FILTER_DEFAULT);
$other_hpi_notes = filter_input(INPUT_POST, "other_hpi_notes", FILTER_DEFAULT);
$other_ros_notes = filter_input(INPUT_POST, 'ros_notes', FILTER_DEFAULT);

//BUTTONS
$submitEMR = filter_input(INPUT_POST, "submitEMR");

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

//REDIRECT IF EXIST, OTHERWISE, CONTINUE
if($existingEMR != null){
    Utils::redirect('EMR', 'EMRDisplay', array('appointment_id' => $appointment_id));
}

//PATIENT INFO
$patient = $patientMapper->findBy(array('person_fk' => $appointment_for_record->getPatientFK()->getID()));

if(isset($submitEMR)){
    
    //HPI
    
    $hpi_string = "This is a patient who presents to the office complaining of " . $chief_complaint . ". ";
    
    if(isset($hpi_onset)){
        if(($hpi_onset == "chronic") || ($hpi_onset == "unknown")){
            $hpi_string .= "The onset is " . $hpi_onset . ". ";
        } else {
            $hpi_string .= "The onset was " . $hpi_onset_number . " " . $hpi_onset . ". ";
        }
    }
    
    if(isset($degree)){
        $hpi_string .= "The degree at onset was " . $degree . ". ";
    }
    
    if(isset($degreePresent)){
        $hpi_string .= "The degree at present is " . $degreePresent . ". ";
    }
    
    foreach($hpi_fields as $category => $attributes){
        
        if(in_array("Yes", $attributes) || in_array("No", $attributes)){
        
        if($category == 'duration'){
            $hpi_string .= "The duration is ";
        } elseif ($category == 'location') {
            $hpi_string .= "The location is ";
        } elseif ($category == 'character') {
            $hpi_string .= "The character is ";
        } elseif ($category == 'risk factors') {
            $hpi_string .= "Risk factors for the patient include ";
        } elseif ($category == 'therapy today') {
            $hpi_string .= "The patient has had the following therapy today: ";
        } elseif ($category == 'associated symptoms') {
            $hpi_string .= "The relevant pertinent positive and negative symptoms are ";
        }
        
        
        
        foreach($attributes as $attribute => $yesorno){
            if($yesorno == "Yes"){
                $hpi_string .= $attribute . ", ";
            } elseif ($yesorno == "No"){
                $hpi_string .= "no " . $attribute . ", ";
            }
        }
        
        
        
        if(substr($hpi_string, -2) == ", "){
            $hpi_string = substr($hpi_string, 0, -2) . ". ";
        } else {
            $hpi_string .= ". ";
        }
        
        }
        
    }
    
    if(isset($other_hpi_notes)){
        $hpi_string .= $other_hpi_notes . PHP_EOL;
    }
    
    
    
    //ROS
    
    $ros_string = "";
    
    foreach($ros_fields as $category => $attributes){
        
        $ros_string .= $category . " - ";
        
        foreach($attributes as $attribute => $yesorno){
            if($yesorno == "Yes"){
                $ros_string .= $attribute . ", ";
            } elseif ($yesorno == "No"){
                $ros_string .= "no " . $attribute . ", ";
            }
        }
        
        if(substr($ros_string, -2) == ", "){
            $ros_string = substr($ros_string, 0, -2) . PHP_EOL;
        } else {
            $ros_string .= PHP_EOL;
        }
        
        
    }
    
    // print_r($hpi_string);
    // print_r($ros_string);
    
    $newEMR = new EMR($emr_fields);
    $newEMR->setPatientFK($appointment_for_record->getPatientFK()->getID());
    $newEMR->setPhysicianFK($appointment_for_record->getPhysicianFK()->getID());
    $newEMR->setHpi($hpi_string);
    $newEMR->setRos($ros_string);
    $newEMR->setAppointmentFK($appointment_for_record->getID());
    $emrMapper->insert($newEMR);
    
}

//AFTER UPDATE, GET EMR AGAIN
//FIND EMR FOR THIS APPOINTMENT
$existingEMR = $emrMapper->findBy(array('appointment_fk' => $appointment_id));

//REDIRECT IF EXIST, OTHERWISE, CONTINUE
if($existingEMR != null){
    Utils::redirect('EMR', 'EMRDisplay', array('appointment_id' => $appointment_id));
}





    $this->ReturnView();
    require($this->template);