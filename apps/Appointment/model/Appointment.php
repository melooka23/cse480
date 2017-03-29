<?php

final class Appointment extends BaseObject {

    protected $id;
    protected $date;
    protected $physician_fk;
    protected $patient_fk;
    protected $reason_for_visit;
    protected $explanation;
    protected $appointment_record_fk;
    
    public function getAppointmentTimeFK() {
        if (is_numeric($this->appointment_time_fk)) {
            $AppointmentTimeMapper = new AppointmentTimeMapper();
            $this->appointment_time_fk = $AppointmentTimeMapper->FindBy(array('id' => $this->appointment_time_fk));
        } elseif (empty($this->appointment_time_fk))
            $this->appointment_time_fk = new AppointmentTime();
        return $this->appointment_time_fk;
    }

    public function setAppointmentTimeFK($appointment_time_fk) {
        $this->appointment_time_fk = $appointment_time_fk;
    }
    
        public function getPhysicianFK() {
        if (is_numeric($this->physician_fk)) {
            $DoctorMapper = new PersonMapper();
            $this->physician_fk = $DoctorMapper->FindBy(array('id' => $this->physician_fk));
        } elseif (empty($this->physician_fk))
            $this->physician_fk = new Person();
        return $this->physician_fk;
    }

    public function setPhysicianFK($physician_fk) {
        $this->physician_fk = $physician_fk;
    }
    
    public function getPatientFK() {
        if (is_numeric($this->patient_fk)) {
            $patientMapper = new PersonMapper();
            $this->patient_fk = $patientMapper->FindBy(array('id' => $this->patient_fk));
        } elseif (empty($this->patient_fk))
            $this->patient_fk = new Person();
        return $this->patient_fk;
    }

    public function setPatientFK($patient_fk) {
        $this->patient_fk = $patient_fk;
    }


 public function getAppointmentRecordFK() {
        // if (is_numeric($this->appointment_record_fk)) {
        //     $AppointmentRecordMapper = new AppointmentRecord();
        //     $this->appointment_record_fk = $AppointmentRecordMapper->FindBy(array('id' => $this->appointment_record_fk));
        // } elseif (empty($this->appointment_record_fk))
        //     $this->appointment_record_fk = new AppointmentRecord();
        // return $this->appointment_record_fk;
        return $this->appointment_record_fk;
    }

    public function setAppointmentRecordFK($appointment_record_fk) {
        $this->appointment_record_fk = $appointment_record_fk;
    }

    public function setReasonForVisit($reason_for_visit) {
        $this->reason_for_visit = $reason_for_visit;
    }

    public function getReasonForVisit() {
        return $this->reason_for_visit;
    }

    public function setExplanation($explanation) {
        $this->explanation = $explanation;
    }
    
    public function getExplanation(){
        return $this->explanation;
    }
    
    public function setDate($date) {
        $this->date = $date;
    }
    
    public function getDate(){
        return $this->date;
    }


}