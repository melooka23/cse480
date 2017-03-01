<?php

final class Doctor extends BaseObject {

    protected $id;
    protected $person_fk;
    protected $hospital;
    protected $specialty_fk;
    protected $undergraduate_school;
    protected $undergraduate_degree;
    protected $undergraduate_year;
    protected $graduate_school;
    protected $graduate_degree;
    protected $graduate_year;
    protected $residency;
    protected $accept_patient;
    protected $accepted_insurance;
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

    public function setHospital($hospital) {
        $this->hospital = $hospital;
    }

    public function getHospital() {
        return $this->hospital;
    }
    
    public function getSpecialtyFK() {
        if (is_numeric($this->specialty_fk)) {
            $specialtyMapper = new DoctorSpecialtyMapper();
            $this->specialty_fk = $specialtyMapper->FindBy(array('id' => $this->specialty_fk));
        } elseif (empty($this->specialty_fk))
            $this->specialty_fk = new DoctorSpecialty();
        return $this->specialty_fk;
    }

    public function setSpecialtyFK($specialty_fk) {
        $this->specialty_fk = $specialty_fk;
    }

    public function setUndergraduateSchool($undergraduate_school) {
        $this->undergraduate_school = $undergraduate_school;
    }
    
    public function getUndergraduateSchool(){
        return $this->undergraduate_school;
    }
    
    public function setUndergraduateDegree($undergraduate_degree) {
        $this->undergraduate_degree = $undergraduate_degree;
    }
    
    public function getUndergraduateDegree(){
        return $this->undergraduate_degree;
    }
    
    public function setUndergraduateYear($undergraduate_year) {
        $this->undergraduate_year = $undergraduate_year;
    }
    
    public function getUndergraduateYear(){
        return $this->undergraduate_year;
    }
    public function setGraduateSchool($graduate_school) {
        $this->graduate_school = $graduate_school;
    }
    public function getGraduateSchool(){
        return $this->graduate_school;
    }
    public function setGraduateDegree($graduate_degree) {
        $this->graduate_degree = $graduate_degree;
    }
     public function getGraduateDegree(){
        return $this->graduate_degree;
    }
     public function setGraduateYear($graduate_year) {
        $this->graduate_year = $graduate_year;
    }
    
    public function getGraduateYear(){
        return $this->graduate_year;
    }
    public function setResidency($residency) {
        $this->residency = $residency;
    }
    
    public function getResidency(){
        return $this->residency;
    }
    public function setAcceptPatient($accept_patient) {
        $this->accept_patient = $accept_patient;
    }
    
    public function getAcceptPatient(){
        return $this->accept_patient;
    }
    public function setAcceptedInsurance($accepted_insurance) {
        $this->accepted_insurance = $accepted_insurance;
    }
    
    public function getAcceptedInsurance(){
        return $this->accepted_insurance;
    }
    
    public function setNotes($notes) {
        $this->notes = $notes;
    }
    
    public function getNotes(){
        return $this->notes;
    }
}

