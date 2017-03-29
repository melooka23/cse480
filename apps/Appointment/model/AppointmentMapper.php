<?php

class AppointmentMapper extends BaseDataMapper {

    protected $entityTable = "APPOINTMENT";

    public function insert(Appointment $appointment) {
        if ($appointment == null) {
            throw new Exception('Entity is empty.');
        }
        $appointment_values = array(
            'patient_fk' => $appointment->getPatientFK()->getID(),
            'date' => $appointment->getDate(),
            'appointment_time_fk' => $appointment->getAppointmentTimeFK()->getID(),
            'physician_fk' => $appointment->getPhysicianFK()->getID(),
            'reason_for_visit' => $appointment->getReasonForVisit(),
            'explanation' => $appointment->getExplanation(),
            'appointment_record_fk' => $appointment->getAppointmentRecordFK());
            
        $appointment->setID($this->adapter->insert($this->entityTable, $appointment_values));
        return $appointment;
    }
    

    public function update(Appointment $appointment) {
        $db_compare_appointment = $this->FindBy(array('id' => $appointment->getID()));
        $update_fields = "";
        
        if ($appointment->getPatientFK()->getID() != null)
        if ($db_compare_appointment->getPatientFK() != $appointment->getPatientFK())
                $update_fields['patient_fk'] = $appointment->getPatientFK()->getID();

        if ($appointment->getDate() != null)
        if ($db_compare_appointment->getDate() != $appointment->getDate())
                $update_fields['date'] = $appointment->getDate();

        if ($appointment->getPhysicianFK() != null)
        if ($db_compare_appointment->getPhysicianFK()->getID() != $appointment->getPhysicianFK()->getID())
                $update_fields['physician_fk'] = $appointment->getPhysicianFK()->getID();
        
        if ($appointment->getAppointmentTimeFK() != null)
        if ($db_compare_appointment->getAppointmentTimeFK()->getID() != $appointment->getAppointmentTimeFK()->getID())
                $update_fields['appointment_time_fk'] = $appointment->getAppointmentTimeFK()->getID();

        if ($appointment->getReasonForVisit() != null)
        if ($db_compare_appointment->getReasonForVisit() != $appointment->getReasonForVisit())
                $update_fields['reason_for_visit'] = $appointment->getReasonForVisit();
                
        if ($appointment->getExplanation() != null)
        if ($db_compare_appointment->getExplanation() != $appointment->getExplanation())
                $update_fields['explanation'] = $appointment->getExplanation();
                
        if ($appointment->getAppointmentRecordFK() != null)
        if ($db_compare_appointment->getAppointmentRecordFK() != $appointment->getAppointmentRecordFK())
                $update_fields['appointment_record_fk'] = $appointment->getAppointmentRecordFK();
        
        if ($update_fields != "") {
            $where = "id=" . $appointment->getID();
            return $this->adapter->update($this->entityTable, $update_fields, $where);
        }
        else
            return 0;
    }
    
    public function delete($id) {
        if ($id instanceof Appointment)
            $id = $id->getID();
        return $this->adapter->delete($this->entityTable, 'id = ' . $id);
    }

    protected function createEntity(array $row) {
        return new Appointment($row);
    }

}

?>
