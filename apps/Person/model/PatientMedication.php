<?php

final class PatientMediction extends BaseObject {

    private $id;
    private $person_fk;
    private $medication_name;
    private $dosage;
    private $frequency;
    private $prescribed_by;
    
    public function getPersonFK() {
        if (is_numeric($this->person_fk)) {
            $personMapper = new PersonMapper();
            $this->person_fk = $personMapper->FindBy(array('id' => $this->person_fk));
        } elseif (empty($this->person_fk))
            $this->person_fk = new Person();
        return $this->person_fk;
    }

    public function setPersonFK($person_fk) {
        $this->person_fk = $person_fk;
    }

    public function setMedicationName($medication_name) {
        $this->medication_name = $medication_name;
    }

    public function getMedicationName() {
        return $this->medication_name;
    }

    public function setDosage($dosage) {
        $this->dosage = $dosage;
    }
    
    public function getDosage(){
        return $this->dosage;
    }
    
    public function setFrequency($frequency) {
        $this->frequency = $frequency;
    }
    
    public function getFrequency(){
        return $this->frequency;
    }
    
    public function setPrescribedBy($prescribed_by) {
        $this->prescribed_by = $prescribed_by;
    }
    
    public function getPrescribedBy(){
        return $this->prescibed_by;
    }

}