<?php

final class Role extends BaseObject {

  protected $id;
  private $role;

  public function getRole() {
    return $this->role;
  }

  public function setRole($role) {
    $this->role = $role;
  }

}

?>
