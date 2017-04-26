<?php

//ARRAYS
$message = filter_input(INPUT_POST, "message", FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);

//VARIABLES
$id = filter_input(INPUT_GET, "id", FILTER_DEFAULT);

//BUTTONS
$send = filter_input(INPUT_POST, "send_message");

//MAPPERS
$messageMapper = new MessageMapper();


if (isset($id)) {
    $this->thismessage = $messageMapper->findBy(array('id' => $id));
    $this->thismessage->setIsRead(1);
    $messageMapper->update($this->thismessage);
} else {
    Utils::redirect('Messages', 'inboxView');
}


if(isset($send)){
    if(isset($message)){
        $new_message = new Message($message);
        $new_message->setSenderFK($this->current_person->getID());
        $new_message->setRecipientFK($this->thismessage->getSenderFK()->getID());
        $new_message->setIsRead(0);
        $new_message->setDateTime(date("Y-m-d h:i:s"));
        $messageMapper->insert($new_message);
    }
    

}

    $my_inbox = $messageMapper->findAll(array('recipient_fk' => $this->current_person->getId()));

    $this->ReturnView();
    require($this->template);
    
    