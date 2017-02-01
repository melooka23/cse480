<?php

final class PersonSecurityQuestion extends BaseObject {

  protected $id;
  private $question;

  public function getQuestion() {
    return $this->question;
  }

  public function setQuestion($question) {
    $this->question = $question;
  }

}

?>
