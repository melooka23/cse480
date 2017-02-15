<?php

class PatientMapper extends BaseDataMapper {

    protected $entityTable = "PATIENT";

    public function insert(Patient $patient) {
        if ($patient == null) {
            throw new Exception('Entity is empty.');
        }
        $patient_values = array(
            'person_fk' => $patient->getPersonFK()->getID(),
            'medication_allergy' => $patient->getMedicationAllergy(),
            'tobacco_use' => $patient->getTobaccoUse(),
            'alcohol_use' => $patient->getAlcoholUse(),
            'family_history' => $patient->getFamilyHistory(),
            'insurance_name' => $patient->getInsuranceName(),
            'date_of_birth' => $patient->getDateofBirth(),
            'insurance_group_number' => $patient->getInsuranceGroupNumber(),
            'insurance_policy_number' => $patient->getInsurancePolicyNumber(),
            'notes' => $patient->getNotes());
        $patient->setID($this->adapter->insert($this->entityTable, $patient_values));
        return $patient;
    }
    

    public function update(Patient $patient) {
        $db_compare_patient = $this->FindBy(array('id' => $patient->getID()));
        $update_fields = "";
        
        if ($patient->getPersonFK()->getID() != null)
        if ($db_compare_patient->getPersonFK() != $patient->getPersonFK())
                $update_fields['person_fk'] = $patient->getPersonFK();

        if ($patient->getMedicationAllergy() != null)
        if ($db_compare_patient->getMedicationAllergy() != $patient->getMedicationAllergy())
                $update_fields['medication_allergy'] = $patient->getMedicationAllergy();

        if ($patient->getTobaccoUse() != null)
        if ($db_compare_patient->getTobaccoUse() != $patient->getTobaccoUse())
                $update_fields['tobacco_use'] = $patient->getTobaccoUse();

        if ($patient->getAlcoholUse() != null)
        if ($db_compare_patient->getAlcoholUse() != $patient->getAlcoholUse())
                $update_fields['alcohol_use'] = $patient->getAlcoholUse();

        if ($patient->getFamilyHistory() != null)
        if ($db_compare_patient->getFamilyHistory() != $patient->getFamilyHistory())
                $update_fields['family_history'] = $patient->getFamilyHistory();
        
        if ($patient->getInsuranceName() != null)
        if ($db_compare_patient->getInsuranceName() != $patient->getInsuranceName())
                $update_fields['insurance_name'] = $patient->getInsuranceName();
                
        if ($patient->getDateOfBirth() != null)
        if ($db_compare_patient->getDateOfBirth() != $patient->getDateOfBirth())
                $update_fields['date_of_birth'] = $patient->getDateOfBirth();
          
        if ($patient->getInsuranceGroupNumber() != null)
        if ($db_compare_patient->getInsuranceGroupNumber() != $patient->getInsuranceGroupNumber())
                $update_fields['insurance_group_number'] = $patient->getInsuranceGroupNumber();
        
        if ($patient->getInsurancePolicyNumber() != null)
        if ($db_compare_patient->getInsurancePolicyNumber() != $patient->getInsurancePolicyNumber())
                $update_fields['insurance_policy_number'] = $patient->getInsurancePolicyNumber();
                
        if ($patient->getNotes() != null)
        if ($db_compare_patient->getNotes() != $patient->getNotes())
                $update_fields['notes'] = $patient->getNotes();
        
        
        if ($update_fields != "") {
            $where = "id=" . $patient->getID();
            return $this->adapter->update($this->entityTable, $update_fields, $where);
        }
        else
            return 0;
    }

    protected function createEntity(array $row) {
        return new Patient($row);
    }

}

?>
