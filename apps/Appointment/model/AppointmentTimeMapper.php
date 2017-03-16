<?php

class AppointmentTimeMapper extends BaseDataMapper {

    protected $entityTable = "APPOINTMENT_Time";

    /* No updating roles through the tool */
     public function insert(AppointmentTime $appointmentTime) {
        if ($appointmentTime == null) {
            throw new Exception('Entity is empty.');
        }
        $appointmentTime_values = array(
            'time' => $appointmentTime->getTime());
            
        $appointmentTime->setID($this->adapter->insert($this->entityTable, $appointmentTIme_values));
        return $appointmentTime;
    }
    
    public function update(AppointmentTime $appointmentTime) {
        $db_compare_appointmentTime = $this->FindBy(array('id' => $appointmentTime->getID()));
        $update_fields = "";

        if ($appointmentTime->getTime() != null)
        if ($db_compare_appointmentTime->getTime() != $appointmentTime->getTime())
                $update_fields['time'] = $appointmentTime->getTime();
        
        if ($update_fields != "") {
            $where = "id=" . $appointmentTime->getID();
            return $this->adapter->update($this->entityTable, $update_fields, $where);
        }
        else
            return 0;
    }

    protected function createEntity(array $row) {
        return new AppointmentTime($row);
    }

}

?>