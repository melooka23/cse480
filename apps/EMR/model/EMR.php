<?php

final class EMR extends BaseObject {

    protected $id;
    protected $appointment_fk;
    protected $patient_fk;
    protected $physician_fk;
    protected $hpi;
    protected $ros;
    protected $hx_medical;
    protected $hx_surgical;
    protected $hx_social;
    protected $hx_family;
    protected $hx_medication;
    protected $hx_allergies;
    protected $pe_general;
    protected $pe_skin;
    protected $pe_head;
    protected $pe_eyes;
    protected $pe_enmt;
    protected $pe_neck;
    protected $pe_cardiovascular;
    protected $pe_abdominal;
    protected $pe_extremities;
    protected $pe_neurological;
    protected $pe_psychiatric;
    protected $mdm_labs;
    protected $mdm_imaging;
    protected $mdm_ekg;
    protected $mdm_course;
    protected $mdm_consults;
    protected $diagnosis;
    protected $disposition;
    protected $discharge_instructions;
    protected $physician_signature;
    protected $signed_date;

    public function getAppointmentFK() {
        if (is_numeric($this->appointment_fk)) {
            $appointmentMapper = new AppointmentMapper();
            $this->appointment_fk = $appointmentMapper->FindBy(array('id' => $this->appointment_fk));
        } elseif (empty($this->appointment_fk))
            $this->appointment_fk = new Appointment();
        return $this->appointment_fk;
    }
    
    public function setAppointmentFK($appointment_fk) {
        $this->appointment_fk = $appointment_fk;
    }
    
     public function getPhysicianFK() {
        if (is_numeric($this->physician_fk)) {
            $personMapper = new PersonMapper();
            $this->physician_fk = $personMapper->FindBy(array('id' => $this->physician_fk));
        } elseif (empty($this->physician_fk))
            $this->physician_fk = new Person();
        return $this->physician_fk;
    }

    public function setPhysicianFK($physician_fk) {
        $this->physician_fk = $physician_fk;
    }
    
        public function getPatientFK() {
        if (is_numeric($this->patient_fk)) {
            $personMapper = new PersonMapper();
            $this->patient_fk = $personMapper->FindBy(array('id' => $this->patient_fk));
        } elseif (empty($this->patient_fk))
            $this->patient_fk = new Person();
        return $this->patient_fk;
    }

    public function setPatientFK($patient_fk) {
        $this->patient_fk = $patient_fk;
    }

    public function setHpi($hpi) {
        $this->hpi = $hpi;
    }
    
    public function getHpi(){
        return $this->hpi;
    }
    
    public function setRos($ros) {
        $this->ros = $ros;
    }
    
    public function getRos(){
        return $this->ros;
    }
    
    public function setHxMedical($hx_medical) {
        $this->hx_medical = $hx_medical;
    }
    
    public function getHxMedical(){
        return $this->hx_medical;
    }
    
     public function setHxSurgical($hx_surgical) {
        $this->hx_surgical = $hx_surgical;
    }
    
    public function getHxSurgical(){
        return $this->hx_surgical;
    }
    
     public function setHxSocial($hx_social) {
        $this->hx_social = $hx_social;
    }
    
    public function getHxSocial(){
        return $this->hx_social;
    }
    
     public function setHxFamily($hx_family) {
        $this->hx_family = $hx_family;
    }
    
    public function getHxFamily(){
        return $this->hx_family;
    }
    
    public function setHxMedication($hx_medication) {
        $this->hx_medication = $hx_medication;
    }
    
    public function getHxMedication(){
        return $this->hx_medication;
    }
    
    public function setHxAllergies($hx_allergies) {
        $this->hx_allergies = $hx_allergies;
    }
    
    public function getHxAllergies(){
        return $this->hx_allergies;
    }
    
    public function setPeGeneral($pe_general) {
        $this->pe_general = $pe_general;
    }
    
    public function getPeGeneral(){
        return $this->pe_general;
    }
    
    public function setPeSkin($pe_skin) {
        $this->pe_skin = $pe_skin;
    }
    
    public function getPeSkin(){
        return $this->pe_skin;
    }
    
    public function setPeHead($pe_head) {
        $this->pe_head = $pe_head;
    }
    
    public function getPeHead(){
        return $this->pe_head;
    }
    
    public function setPeEyes($pe_eyes) {
        $this->pe_eyes = $pe_eyes;
    }
    
    public function getPeEyes(){
        return $this->pe_eyes;
    }
    
    public function setPeEnmt($pe_enmt) {
        $this->pe_enmt = $pe_enmt;
    }
    
    public function getPeEnmt(){
        return $this->pe_enmt;
    }
    
    public function setPeNeck($pe_neck) {
        $this->pe_neck = $pe_neck;
    }
    
    public function getPeNeck(){
        return $this->pe_neck;
    }
    
    public function setPeCardiovascular($pe_cardiovascular) {
        $this->pe_cardiovascular = $pe_cardiovascular;
    }
    
    public function getPeCardiovascular(){
        return $this->pe_cardiovascular;
    }
    
    public function setPeAbdominal($pe_abdominal) {
        $this->pe_abdominal = $pe_abdominal;
    }
    
    public function getPeAbdominal(){
        return $this->pe_abdominal;
    }
    
    public function setPeExtremities($pe_extremities) {
        $this->pe_extremities = $pe_extremities;
    }
    
    public function getPeExtremities(){
        return $this->pe_extremities;
    }
    
    public function setPeNeurological($pe_neurological) {
        $this->pe_neurological = $pe_neurological;
    }
    
    public function getPeNeurological(){
        return $this->pe_neurological;
    }
    
    public function getPePsychiatric(){
        return $this->pe_psychiatric;
    }
    
    public function setPePsychiatric($pe_psychiatric){
        $this->pe_psychiatric = $pe_psychiatric;
    }
    
    public function setMdmLabs($mdm_labs) {
        $this->mdm_labs = $mdm_labs;
    }
    
    public function getMdmLabs(){
        return $this->mdm_labs;
    }
    
    public function setMdmImaging($mdm_imaging) {
        $this->mdm_imaging = $mdm_imaging;
    }
    
    public function getMdmImaging(){
        return $this->mdm_imaging;
    }
    
    public function setMdmEkg($mdm_ekg) {
        $this->mdm_ekg = $mdm_ekg;
    }
    
    public function getMdmEkg(){
        return $this->mdm_ekg;
    }
    
    public function setMdmCourse($mdm_course) {
        $this->mdm_course = $mdm_course;
    }
    
    public function getMdmCourse(){
        return $this->mdm_course;
    }
    
    public function setMdmConsults($mdm_consults) {
        $this->mdm_consults = $mdm_consults;
    }
    
    public function getMdmConsults(){
        return $this->mdm_consults;
    }
    
    public function setDiagnosis($diagnosis) {
        $this->diagnosis = $diagnosis;
    }
    
    public function getDiagnosis(){
        return $this->diagnosis;
    }
    
    public function setDisposition($disposition) {
        $this->disposition = $disposition;
    }
    
    public function getDisposition(){
        return $this->disposition;
    }
    
    public function setDischargeInstructions($discharge_instructions) {
        $this->discharge_instructions = $discharge_instructions;
    }
    
    public function getDischargeInstructions(){
        return $this->discharge_instructions;
    }
    
    public function setPhysicianSignature($physician_signature) {
        $this->physician_signature = $physician_signature;
    }
    
    public function getPhysicianSignature(){
        return $this->physician_signature;
    }
    
    public function setSignedDate($signed_date) {
        $this->signed_date = $signed_date;
    }
    
    public function getSignedDate(){
        return $this->signed_date;
    }
    
}