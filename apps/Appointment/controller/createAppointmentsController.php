<?php


//select a date, if no date is selected, or it is the inital view, display for todays date
//find all appointments for the selected date
//2 arrays, 1 will have possible appointments, the other will have selected appointments
//if possible appointmnet = selected appointment, check the box, if not then keep unchecked
//if possible appointment already has a patient scheduled, dont display on the page

//When user hits save at bottom of page, update accordingly


//ARRAYS
$checked_times = filter_input(INPUT_POST, "chk", FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);

//VARIABLES
$goto_date = filter_input(INPUT_POST, "appointment_date");
$selected_date = filter_input(INPUT_POST, "selected_date");

//BUTTONS
$goto = filter_input(INPUT_POST, "goto");
$create_appointments = filter_input(INPUT_POST, "createAppointment");

//MAPPERS
$appointmentMapper = new AppointmentMapper();
$appointmentTimeMapper = new AppointmentTimeMapper();

if (isset($selected_date)) {//second pass
    $appointment_date = date('Y-m-d', strtotime($selected_date));
} else{ //FIRST PASS
    $appointment_date = date('Y-m-d', strtotime("today"));
}

    if(isset($goto)){
        $appointment_date = date('Y-m-d', strtotime($goto_date));
    }

    if(isset($create_appointments)){
        
        $old_selected_appointments = $appointmentMapper->findAll(array('physician_fk' => $this->current_person->getID(), 'date' => $appointment_date));
        
        if($checked_times){
            foreach($checked_times as $time_id => $checked_time){
                $found = 0;
                foreach($old_selected_appointments as $old_key => $old_selected_appointment){
                    if($old_selected_appointment->getAppointmentTimeFK()->getID() == $time_id){
                        unset($old_selected_appointments[$old_key]);
                        $found = 1;
                    }
                }
                if($found == 0){
                    $new_appointment = new Appointment();
                    $new_appointment->setPhysicianFK($this->current_person->getID());
                    $new_appointment->setDate($selected_date);
                    $new_appointment->setAppointmentTimeFK($time_id);
                    $appointmentMapper->insert($new_appointment);
                }
            }
        }
        
        if($old_selected_appointments != null){
            foreach($old_selected_appointments as $old_selected_appointment){
                $result = $appointmentMapper->delete($old_selected_appointment);
            }
        }
        
    }

    $possible_times = $appointmentTimeMapper->FindAll();
    
    $selected_times = $appointmentMapper->findAll(array('physician_fk' => $this->current_person->getID(), 'date' => $appointment_date));
    
    $this->ReturnView();
    require($this->template);