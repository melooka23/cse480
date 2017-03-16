<?php

final class AppointmentTime extends BaseObject {

    protected $id;
    protected $time;

    public function setTime($time) {
        $this->time = $time;
    }

    public function getTime() {
        return $this->time;
    }

}

