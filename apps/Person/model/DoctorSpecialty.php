<?php

final class DoctorSpecialty extends BaseObject {

  protected $id;
  private $specialty;

  public function setSpecialty($specialty) {
    $this->specialty = $specialty;
  }
  public function getSpecialty() {
    return $this->specialty;
  }

}

?>