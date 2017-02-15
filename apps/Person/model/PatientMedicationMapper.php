<?php

class PatientMedicationMapper extends BaseDataMapper {

    protected $entityTable = "PATIENT_Medication";

    public function insert(PatientMediction $medication) {
        if ($medicationr == null) {
            throw new Exception('Entity is empty.');
        }
        $medication_values = array(
            'patient_fk' => $medication->getPatientFK()->getID(),
            'medication_name' => $medication->getMedicationName(),
            'dosage' => $medication->getDosage(),
            'frequency' => $medication->getFrequency(),
            'prescibed_by' => $medication->getPrescribedBy());

        $medication->setID($this->adapter->insert($this->entityTable, $medication_values));
        return $medication;
    }
    

    public function update(PatientMediction $medication) {
        $db_compare_medication= $this->FindBy(array('id' => $medication->getID()));
        $update_fields = "";
        
        if ($medication->getPatientFK()->getID != null)
        if ($db_compare_medication->getPatientFK() != $medication->getPatientFK())
                $update_fields['patient_fk'] = $medication->getPatientFK();

        if ($medication->getMedicationName() != null)
        if ($db_compare_medication->getMedicationName() != $medication->getMedicationName())
                $update_fields['medication_name'] = $medication->getMedicationName();

        if ($medication->getDosage != null)
        if ($db_compare_medication->getDosage() != $medication->getDosage())
                $update_fields['dosage'] = $medication->getDosage();

        if ($medication->getFrequency() != null)
        if ($db_compare_medication->getFrequency() != $medication->getFrequency())
                $update_fields['frequency'] = $medication->getFrequency();
        
        if ($medication->getPrescribedBy() != null)
        if ($db_compare_medication->getPrescribedBy() != $medication->getPrescribedBy())
                $update_fields['prescibed_by'] = $medication->getPrescribedBy();
        
        
        if ($update_fields != "") {
            $where = "id=" . $medication->getID();
            return $this->adapter->update($this->entityTable, $update_fields, $where);
        }
        else
            return 0;
    }

    protected function createEntity(array $row) {
        return new PatientMedication($row);
    }

}

?>