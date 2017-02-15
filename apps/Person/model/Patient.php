<?php

final class Patient extends BaseObject {

    protected $id;
    protected $person_fk;
    protected $medication_allergy;
    protected $tobacco_use;
    protected $alcohol_use;
    protected $family_history;
    protected $insurance_name;
    protected $date_of_birth;
    protected $insurance_group_number;
    protected $insurance_policy_number;
    protected $notes;


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

    public function setMedicationAllergy($medication_allergy) {
        $this->medication_allergy = $medication_allergy;
    }

    public function getMedicationAllergy() {
        return $this->medication_allergy;
    }

    
    public function setTobaccoUse($tobacco_use) {
       $this->tobacco_use = $tobacco_use;
    }
    
    public function getTobaccoUse() {
       return $this->tobacco_use;
    }

    public function setAlcoholUse($alcohol_use) {
        $this->alcohol_use = $alcohol_use;
    }
    
    public function getAlcoholUse(){
        return $this->alcohol_use;
    }
    
    public function setFamilyHistory($family_history) {
        $this->family_history = $family_history;
    }
    
    public function getFamilyHistory(){
        return $this->family_history;
    }
    
    public function setInsuranceName($insurance_name) {
        $this->insurance_name = $insurance_name;
    }
    
    public function getInsuranceName(){
        return $this->insurance_name;
    }
    public function setDateOfBirth($date_of_birth) {
        $this->date_of_birth = $date_of_birth;
    }
    public function getDateOfBirth(){
        return $this->date_of_birth;
    }
    public function setInsuranceGroupNumber($insurance_group_number) {
        $this->insurance_group_number = $insurance_group_number;
    }
     public function getInsuranceGroupNumber(){
        return $this->insurance_group_number;
    }
     public function setInsurancePolicyNumber($insurance_policy_number) {
        $this->insurance_policy_number = $insurance_policy_number;
    }
    
    public function getInsurancePolicyNumber(){
        return $this->insurance_policy_number;
    }
    
     public function setNotes($notes) {
        $this->notes = $notes;
    }
    
    public function getNotes(){
        return $this->notes;
    }
}

