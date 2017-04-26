<?php

class MessageMapper extends BaseDataMapper {

    protected $entityTable = "MESSAGE";

    public function insert(Message $message) {
        if ($message == null) {
            throw new Exception('Entity is empty.');
        }
        $message_values = array(
            'sender_fk' => $message->getSenderFK()->getID(),
            'recipient_fk' => $message->getRecipientFK()->getID(),
            'subject' => $message->getSubject(),
            'message' => $message->getMessage(),
            'date_time' => $message->getDateTime(),
            'is_read'=> $message->getIsRead());
            
        $message->setID($this->adapter->insert($this->entityTable, $message_values));
        return $message;
    }
    

    public function update(Message $message) {
        $db_compare_message = $this->FindBy(array('id' => $message->getID()));
        $update_fields = "";

        if ($message->getSenderFK() != null)
        if ($db_compare_message->getSenderFK()->getID() != $message->getSenderFK()->getID())
                $update_fields['sender_fk'] = $message->getSenderFK()->getID();
        
        if ($message->getRecipientFK() != null)
        if ($db_compare_message->getRecipientFK()->getID() != $message->getRecipientFK()->getID())
                $update_fields['recipient_fk'] = $message->getRecipientFK()->getID();

        if ($message->getSubject() != null)
        if ($db_compare_message->getSubject() != $message->getSubject())
                $update_fields['subject'] = $message->getSubject();
                
        if ($message->getDateTime() != null)
        if ($db_compare_message->getDateTime() != $message->getDateTime())
                $update_fields['date_time'] = $message->getDateTime();
        
        if ($message->getIsRead() != null)
        if ($db_compare_message->getIsRead() != $message->getIsRead())
                $update_fields['is_read'] = $message->getIsRead();

        if ($update_fields != "") {
            $where = "id=" . $message->getID();
            return $this->adapter->update($this->entityTable, $update_fields, $where);
        }
        else
            return 0;
    }

    protected function createEntity(array $row) {
        return new Message($row);
    }
}

?>
