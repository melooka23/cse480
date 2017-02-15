<?php

$patientProfileMapper = new PatientMapper();
$dbProfile = $patientProfileMapper->FindBy(array('person_fk' => $this->current_person->getID()));

if (isset($_POST['profile'])) {//second pass
    $this->thisprofile = new Patient($_POST['profile']);
} else if ($dbProfile != null) { //first pass - edit Profile
    $this->thisprofile = $dbProfile;
} else { //first pass - new Profile - Does not exist in database
    $this->thisprofile = new Patient();
    $this->thisprofile->setPersonFK($this->current_person->getID());
    $patientProfileMapper->insert($this->thisprofile);
}


if(isset($_POST['save'])){
        if(isset($_POST['location'])){
                $this->current_person->setLocation($_POST['location']);
                $personMapper = new PersonMapper();
                $personMapper->update($this->current_person);
        }
        $patientProfileMapper->update($this->thisprofile);
}
    
    
    
        $medication_list = null;
        $this->ReturnView();
        require($this->template);