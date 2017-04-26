<?php

class EMRMapper extends BaseDataMapper {

    protected $entityTable = "EMR";
    
        public function searchRecords($conditions) {

        $select = "SELECT r.*";
        $from = " FROM EMR r LEFT JOIN PERSON p ON r.patient_fk = p.id";
        $where = " WHERE 1=1";

        if (isset($conditions["firstname"])) {
            $where .= " AND p.first_name LIKE '%" . $conditions["firstname"] . "%'";
        }
        if (isset($conditions["lastname"])) {
            $where .= " AND p.last_name like '%" . $conditions["lastname"] . "%'";
        }
        if (isset($conditions["appointment_date"])) {
            $where .= " AND r.appointment_fk in (SELECT id FROM APPOINTMENT a WHERE a.date = " . $conditions["appointment_date"] . ")";
        }
        
        $query = $select . $from . $where;
        return $this->findObjectsWithRawQuery($query);
    }

    public function insert(EMR $emr) {
        if ($emr == null) {
            throw new Exception('Entity is empty.');
        }
        $emr_values = array(
            'appointment_fk' => $emr->getAppointmentFK()->getID(),
            'patient_fk' => $emr->getPatientFK()->getID(),
            'physician_fk' => $emr->getPhysicianFK()->getID(),
            'hpi' => $emr->getHpi(),
            'ros' => $emr->getRos(),
            'hx_medical' => $emr->getHxMedical(),
            'hx_surgical' => $emr->getHxSurgical(),
            'hx_social' => $emr->getHxSocial(),
            'hx_family' => $emr->getHxFamily(),
            'hx_medication' => $emr->getHxMedication(),
            'hx_allergies' => $emr->getHxAllergies(),
            'pe_general' => $emr->getPeGeneral(),
            'pe_skin' => $emr->getPeSkin(),
            'pe_head' => $emr->getPeHead(),
            'pe_eyes' => $emr->getPeEyes(),
            'pe_enmt' => $emr->getPeEnmt(),
            'pe_neck' => $emr->getPeNeck(),
            'pe_cardiovascular' => $emr->getPeCardiovascular(),
            'pe_abdominal' => $emr->getPeAbdominal(),
            'pe_extremities' => $emr->getPeExtremities(),
            'pe_neurological' => $emr->getPeNeurological(),
            'pe_psychiatric' => $emr->getPePsychiatric(),
            'mdm_labs' => $emr->getMdmLabs(),
            'mdm_imaging' => $emr->getMdmImaging(),
            'mdm_ekg'=> $emr->getMdmEkg(),
            'mdm_course' => $emr->getMdmCourse(),
            'mdm_consults'=> $emr->getMdmConsults(),
            'diagnosis'=> $emr->getDiagnosis(),
            'disposition' => $emr->getDisposition(),
            'discharge_instructions' => $emr->getDischargeInstructions(),
            'physician_signature' => $emr->getPhysicianSignature(),
            'signed_date'=> $emr->getSignedDate());
            
        $emr->setID($this->adapter->insert($this->entityTable, $emr_values));
        return $emr;
    }
    

    public function update(EMR $emr) {
        $db_compare_emr = $this->FindBy(array('id' => $emr->getID()));
        $update_fields = "";
        
        if ($emr->getAppointmentFK()->getID() != null)
        if ($db_compare_emr->getAppointmentFK()->getID() != $emr->getAppointmentFK()->getID())
                $update_fields['appointment_fk'] = $emr->getAppointmentFK()->getID();
                
        if ($emr->getPatientFK()->getID() != null)
        if ($db_compare_emr->getPatientFK()->getID() != $emr->getPatientFK()->getID())
                $update_fields['patient_fk'] = $emr->getPatientFK()->getID();

        if ($emr->getPhysicianFK()->getID() != null)
        if ($db_compare_emr->getPhysicianFK()->getID() != $emr->getPhysicianFK()->getID())
                $update_fields['physician_fk'] = $emr->getPhysicianFK()->getID();

        if ($emr->getHpi() != null)
        if ($db_compare_emr->getHpi() != $emr->getHpi())
                $update_fields['hpi'] = $emr->getHpi();

        if ($emr->getRos() != null)
        if ($db_compare_emr->getRos() != $emr->getRos())
                $update_fields['ros'] = $emr->getRos();
        
        if ($emr->getHxMedical() != null)
        if ($db_compare_emr->getHxMedical() != $emr->getHxMedical())
                $update_fields['hx_medical'] = $emr->getHxMedical();
          
        if ($emr->getHxSurgical() != null)
        if ($db_compare_emr->getHxSurgical() != $emr->getHxSurgical())
                $update_fields['hx_surgical'] = $emr->getHxSurgical();

        if ($emr->getHxSocial() != null)
        if ($db_compare_emr->getHxSocial() != $emr->getHxSocial())
                $update_fields['hx_social'] = $emr->getHxSocial();
        
        if ($emr->getHxFamily() != null)
        if ($db_compare_emr->getHxFamily() != $emr->getHxFamily())
                $update_fields['hx_family'] = $emr->getHxFamily();
                
        if ($emr->getHxMedication() != null)
        if ($db_compare_emr->getHxMedication() != $emr->getHxMedication())
                $update_fields['hx_medication'] = $emr->getHxMedication();
                
        if ($emr->getHxAllergies() != null)
        if ($db_compare_emr->getHxAllergies() != $emr->getHxAllergies())
                $update_fields['hx_allergies'] = $emr->getHxAllergies();
                
        if ($emr->getPeGeneral() != null)
        if ($db_compare_emr->getPeGeneral() != $emr->getPeGeneral())
                $update_fields['pe_general'] = $emr->getPeGeneral();
        
        if ($emr->getPeSkin() != null)
        if ($db_compare_emr->getPeSkin() != $emr->getPeSkin())
                $update_fields['pe_skin'] = $emr->getPeSkin();
        
        if ($emr->getPeHead() != null)
        if ($db_compare_emr->getPeHead() != $emr->getPeHead())
                $update_fields['pe_head'] = $emr->getPeHead();
                
        if ($emr->getPeEyes() != null)
        if ($db_compare_emr->getPeEyes() != $emr->getPeEyes())
                $update_fields['pe_eyes'] = $emr->getPeEyes();
        
        if ($emr->getPeEnmt() != null)
        if ($db_compare_emr->getPeEnmt() != $emr->getPeEnmt())
                $update_fields['pe_enmt'] = $emr->getPeEnmt();
        
        if ($emr->getPeNeck() != null)
        if ($db_compare_emr->getPeNeck() != $emr->getPeNeck())
                $update_fields['pe_neck'] = $emr->getPeNeck();
                                
        if ($emr->getPeCardiovascular() != null)
        if ($db_compare_emr->getPeCardiovascular() != $emr->getPeCardiovascular())
                $update_fields['pe_cardiovascular'] = $emr->getPeCardiovascular();
                                
        if ($emr->getPeAbdominal() != null)
        if ($db_compare_emr->getPeAbdominal() != $emr->getPeAbdominal())
                $update_fields['pe_abdominal'] = $emr->getPeAbdominal();
                                
        if ($emr->getPeExtremities() != null)
        if ($db_compare_emr->getPeExtremities() != $emr->getPeExtremities())
                $update_fields['pe_extremities'] = $emr->getPeExtremities();
        
        if ($emr->getPeNeurological() != null)
        if ($db_compare_emr->getPeNeurological() != $emr->getPeNeurological())
                $update_fields['pe_neurological'] = $emr->getPeNeurological();
                
        if ($emr->getPePsychiatric() != null)
        if ($db_compare_emr->getPePsychiatric() != $emr->getPePsychiatric())
                $update_fields['pe_psychiatric'] = $emr->getPePsychiatric();
                                                        
        if ($emr->getMdmLabs() != null)
        if ($db_compare_emr->getMdmLabs() != $emr->getMdmLabs())
                $update_fields['mdm_labs'] = $emr->getMdmLabs();
                                
        if ($emr->getMdmImaging() != null)
        if ($db_compare_emr->getMdmImaging() != $emr->getMdmImaging())
                $update_fields['mdm_imaging'] = $emr->getMdmImaging();
        
        if ($emr->getMdmEkg() != null)
        if ($db_compare_emr->getMdmEkg() != $emr->getMdmEkg())
                $update_fields['mdm_ekg'] = $emr->getMdmEkg();
        
        if ($emr->getMdmCourse() != null)
        if ($db_compare_emr->getMdmCourse() != $emr->getMdmCourse())
                $update_fields['mdm_course'] = $emr->getMdmCourse();
        
        if ($emr->getMdmConsults() != null)
        if ($db_compare_emr->getMdmConsults() != $emr->getMdmConsults())
                $update_fields['mdm_consults'] = $emr->getMdmConsults();
        
        if ($emr->getDiagnosis() != null)
        if ($db_compare_emr->getDiagnosis() != $emr->getDiagnosis())
                $update_fields['diagnosis'] = $emr->getDiagnosis();
        
        if ($emr->getDisposition() != null)
        if ($db_compare_emr->getDisposition() != $emr->getDisposition())
                $update_fields['disposition'] = $emr->getDisposition();
                
        if ($emr->getDischargeInstructions() != null)
        if ($db_compare_emr->getDischargeInstructions() != $emr->getDischargeInstructions())
                $update_fields['discharge_instructions'] = $emr->getDischargeInstructions();
        
        if ($emr->getPhysicianSignature() != null)
        if ($db_compare_emr->getPhysicianSignature() != $emr->getPhysicianSignature())
                $update_fields['physician_signature'] = $emr->getPhysicianSignature();
        
        if ($emr->getSignedDate() != null)
        if ($db_compare_emr->getSignedDate() != $emr->getSignedDate())
                $update_fields['signed_date'] = $emr->getSignedDate();
        
        if ($update_fields != "") {
            $where = "id=" . $emr->getID();
            return $this->adapter->update($this->entityTable, $update_fields, $where);
        }
        else
            return 0;
    }

    protected function createEntity(array $row) {
        return new EMR($row);
    }

}

?>
