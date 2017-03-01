<?php

//ARRAYS
$profile = filter_input(INPUT_POST, "doctorprofile", FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);

//VARIABLES
$location = filter_input(INPUT_POST, "location");

//BUTTONS
$save = filter_input(INPUT_POST, "save");

//MAPPERS
$doctorProfileMapper = new DoctorMapper();
$personMapper = new PersonMapper();

$dbProfile = $doctorProfileMapper->FindBy(array('person_fk' => $this->current_person->getID()));

if (isset($profile)) {//second pass
    $this->thisprofile = new Doctor($profile);
} else if ($dbProfile != null) { //first pass - edit Profile
    $this->thisprofile = $dbProfile;
} else { //first pass - new Profile - Does not exist in database
    $this->thisprofile = new Doctor();
    $this->thisprofile->setPersonFK($this->current_person->getID());
    $doctorProfileMapper->insert($this->thisprofile);
}


if(isset($save)){
    if(isset($location)){
        $this->current_person->setLocation($location);
        $personMapper->update($this->current_person);
    }
    $doctorProfileMapper->update($this->thisprofile);

}
    

        $this->ReturnView();
        require($this->template);