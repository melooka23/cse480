<?php

final class Message extends BaseObject {

    protected $id;
    protected $subject;
    protected $message;
    protected $read;
    
    public function getSenderFK() {
        if (is_numeric($this->sender_fk)) {
            $MessageMapper = new MessageMapper();
            $this->sender_fk = $MessageMapper->FindBy(array('id' => $this->sender_fk));
        } elseif (empty($this->sender_fk))
            $this->sender_fk = new Person();
        return $this->sender_fk;
    }

    public function setSenderFK($sender_fk) {
        $this->sender_fk = $sender_fk;
    }
    
        public function getRecipientFK() {
        if (is_numeric($this->recipient_fk)) {
            $MessageMapper = new MessageMapper();
            $this->recipient_fk = $MessageMapper->FindBy(array('id' => $this->recipient_fk));
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
    
    public function setTimeStamp($timestamp) {
        $this->timestamp = $timestamp;
    }
    
    public function getTimeStamp(){
        return $this->timestamp;
    }


  public function setRead($read) {
        $this->read = $read;
    }
    
    public function getRead(){
        return $this->read;
    }

}