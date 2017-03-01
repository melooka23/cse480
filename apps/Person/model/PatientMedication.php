<?php

final class PatientMedication extends BaseObject {

    protected $id;
    private $patient_fk;
    private $medication_name;
    private $dosage;
    private $frequency;
    private $prescribed_by;
    
    public function getPatientFK() {
        if (is_numeric($this->patient_fk)) {
            $patientMapper = new PatientMapper();
            $this->patient_fk = $patientMapper->FindBy(array('id' => $this->patient_fk));
        } elseif (empty($this->patient_fk))
            $this->patient_fk = new Patient();
        return $this->patient_fk;
    }

    public function setPatientFK($patient_fk) {
        $this->patient_fk = $patient_fk;
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
        return $this->prescribed_by;
    }

}