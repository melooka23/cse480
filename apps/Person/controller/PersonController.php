<?php

final class PersonController extends BaseController {

    protected $thisperson;


    public function loginPersonAction() {
        self::getSubController();
    }
    
    public function logoutPersonAction() {
        unset($_SESSION['user']);
        $this->current_person = null;
        Utils::redirect('Person', 'loginPerson');
    }
    
    public function registerPersonAction() {
        self::getSubController();
    }
    
    public function patientProfileAction() {
        self::getSubController();
    }
    
    public function doctorProfileAction() {
        self::getSubController();
    }
    public function inboxViewAction() {
        self::getSubController();
    }
     public function scheduleAppointmentAction() {
        self::getSubController();
    }
    public function emrViewAction() {
        self::getSubController();
    }
    
}

?>
