<?php

class MessageMapper extends BaseDataMapper {

    protected $entityTable = "MESSAGE";

    public function insert(Message $message) {
        if ($message == null) {
            throw new Exception('Entity is empty.');
        }
        $message_values = array(
            'sender_fk' => $message->getPersonFK()->getID(),
            'recipient_fk' => $message->getPersonFK()->getID(),
            'subject' => $message->getSubject(),
            'message' => $message->getMessage(),
            'timestamp' => $message->getTimestamp(),
            'read'=> $message->getRead());
            
        $message->setID($this->adapter->insert($this->entityTable, $message_values));
        return $message;
    }
    

    public function update(Message $message) {
        $db_compare_message = $this->FindBy(array('id' => $message->getID()));
        $update_fields = "";

        if ($message->getPersonFK() != null)
        if ($db_compare_message->getPersonFK()->getID() != $message->getPersonFK()->getID())
                $update_fields['sender_fk'] = $message->getPersonFK()->getID();
        
        if ($message->getPersonFK() != null)
        if ($db_compare_message->getPersonFK()->getID() != $message->getPersonFK()->getID())
                $update_fields['recipient_fk'] = $message->getPersonFK()->getID();

        if ($message->getSubject() != null)
        if ($db_compare_message->getSubject() != $message->getSubject())
                $update_fields['subject'] = $message->getSubject();
                
        if ($message->getTimestamp() != null)
        if ($db_compare_message->getTimestamp() != $message->getTimestamp())
                $update_fields['timestamp'] = $message->getTimestamp();
        
        if ($message->getRead() != null)
        if ($db_compare_message->getRead() != $message->getRead())
                $update_fields['read'] = $message->getRead();

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
