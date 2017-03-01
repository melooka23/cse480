<?php

//ARRAYS
$profile = filter_input(INPUT_POST, "profile", FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
$medications = filter_input(INPUT_POST, "medication", FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
$medicationIDs = filter_input(INPUT_POST, "medicationIDs", FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
$dosages = filter_input(INPUT_POST, "dosage", FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
$frequencys = filter_input(INPUT_POST, "frequency", FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
$prescribed_bys = filter_input(INPUT_POST, "prescribed_by", FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);

//VARIABLES
$location = filter_input(INPUT_POST, "location");

//BUTTONS
$save = filter_input(INPUT_POST, "save");

//MAPPERS
$patientProfileMapper = new PatientMapper();
$personMapper = new PersonMapper();
$patientMedicationMapper = new PatientMedicationMapper();

$dbProfile = $patientProfileMapper->FindBy(array('person_fk' => $this->current_person->getID()));

if (isset($profile)) {//second pass
    $this->thisprofile = new Patient($profile);
} else if ($dbProfile != null) { //first pass - edit Profile
    $this->thisprofile = $dbProfile;
} else { //first pass - new Profile - Does not exist in database
    $this->thisprofile = new Patient();
    $this->thisprofile->setPersonFK($this->current_person->getID());
    $patientProfileMapper->insert($this->thisprofile);
}


if(isset($save)){
    if(isset($location)){
        $this->current_person->setLocation($location);
        $personMapper->update($this->current_person);
    }
    $patientProfileMapper->update($this->thisprofile);
        
    
    if ($medications) {
    $old_meds = $patientMedicationMapper->findAll(['patient_fk' => $this->thisprofile->getID()]);
    $num_medications = count($medications);
    for ($i = 0; $i < $num_medications; $i++) {
        $medication = $medications[$i];
        $medication_id = $medicationIDs[$i];
        $dosage = $dosages[$i];
        $frequency = $frequencys[$i];
        $prescribed_by = $prescribed_bys[$i];

        if (strlen($medication) > 1) {
            $saveMed = new PatientMedication();
            $saveMed->setMedicationName($medication);
            $saveMed->setDosage($dosage);
            $saveMed->setFrequency($frequency);
            $saveMed->setPrescribedBy($prescribed_by);
            $saveMed->setPatientFK($this->thisprofile->getID());

            if ($medication_id == null) {
                $patientMedicationMapper->Insert($saveMed);
                //print_r($saveMed);
            } else {
                $update_medication = $patientMedicationMapper->findBy(['id' => $medication_id]);
                if ($old_meds != null) {
                    foreach ($old_meds as $arrkey => $old_med) {
                        if ($old_med->getId() == $update_medication->getId()) {
                            unset($old_meds[$arrkey]);
                        }
                    }
                }
                
                if (($update_medication->getMedicationName() != $saveMed->getMedicationName()) ||
                ($update_medication->getDosage() != $saveMed->getDosage()) ||
                ($update_medication->getFrequency() != $saveMed->getFrequency()) ||
                ($update_medication->getPrescribedBy() != $saveMed->getPrescribedBy()) ) {
                    
                    $update_medication->setMedicationName($saveMed->getMedicationName());
                    $update_medication->setDosage($saveMed->getDosage());
                    $update_medication->setFrequency($saveMed->getFrequency());
                    $update_medication->setPrescribedBy($saveMed->getPrescribedBy());

                    $patientMedicationMapper->Update($update_medication);
                }
            }
        }
    }

//DELETE any old files that are not on the new list.
    if ($old_meds != null) {
        foreach ($old_meds as $old_med) {
            $result = $patientMedicationMapper->delete($old_med);
            $file_updates = 1;
        }
    }
}

}
    
    
    
        $medication_list = $patientMedicationMapper->FindAll(['patient_fk' => $this->thisprofile->getID()]);
        $this->ReturnView();
        require($this->template);