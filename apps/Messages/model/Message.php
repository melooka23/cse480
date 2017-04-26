<?php

final class Message extends BaseObject {

    protected $id;
    protected $subject;
    protected $message;
    protected $is_read;
    protected $date_time;
    protected $sender_fk;
    protected $recipient_fk;
    
    public function getSenderFK() {
        if (is_numeric($this->sender_fk)) {
            $personMapper = new PersonMapper();
            $this->sender_fk = $personMapper->FindBy(array('id' => $this->sender_fk));
        } elseif (empty($this->sender_fk))
            $this->sender_fk = new Person();
        return $this->sender_fk;
    }

    public function setSenderFK($sender_fk) {
        $this->sender_fk = $sender_fk;
    }
    
        public function getRecipientFK() {
        if (is_numeric($this->recipient_fk)) {
            $personMapper = new PersonMapper();
            $this->recipient_fk = $personMapper->FindBy(array('id' => $this->recipient_fk));
        } elseif (empty($this->recipient_fk))
            $this->recipient_fk = new Person();
        return $this->recipient_fk;
    }

    public function setRecipientFK($recipient_fk) {
        $this->recipient_fk = $recipient_fk;
    }


    public function setSubject($subject) {
        $this->subject = $subject;
    }

    public function getSubject() {
        return $this->subject;
    }

    public function setMessage($message) {
        $this->message = $message;
    }
    
    public function getMessage(){
        return $this->message;
    }
    
    public function setDateTime($date_time) {
        $this->date_time = $date_time;
    }
    
    public function getDateTime(){
        return $this->date_time;
    }


  public function setIsRead($is_read) {
        $this->is_read = $is_read;
    }
    
    public function getIsRead(){
        return $this->is_read;
    }

}