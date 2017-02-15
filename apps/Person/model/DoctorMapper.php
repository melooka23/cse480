<?php

class DoctorMapper extends BaseDataMapper {

    protected $entityTable = "DOCTOR";

    public function insert(Doctor $doctor) {
        if ($doctor == null) {
            throw new Exception('Entity is empty.');
        }
        $doctor_values = array(
            'person_fk' => $doctor->getPersonFK()->getID(),
            'degree_type' => $doctor->getDegreeType(),
            'specialty_fk' => $doctor->getSpecialtyFK()->getID(),
            'undergraduate_school' => $doctor->getUndergraduateSchool(),
            'undergraduate_degree' => $doctor->getUndergraduateDegree(),
            'undergraduate_year' => $doctor->getUndergraduateYear(),
            'graduate_school' => $doctor->getGraduateSchool(),
            'graduate_degree' => $doctor->getGraduateDegree(),
            'graduate_year' => $doctor->getGraduateYear());
        $doctor->setID($this->adapter->insert($this->entityTable, $doctor_values));
        return $doctor;
    }
    

    public function update(Doctor $doctor) {
        $db_compare_doctor = $this->FindBy(array('id' => $doctor->getID()));
        $update_fields = "";
        
        if ($doctor->getPersonFK()->getID != null)
        if ($db_compare_doctor->getPersonFK() != $doctor->getPersonFK())
                $update_fields['person_fk'] = $doctor->getPersonFK();

        if ($doctor->getDegreeType() != null)
        if ($db_compare_doctor->getDegreeType() != $doctor->getDegreeType())
                $update_fields['degree_type'] = $doctor->getDegreeType();

        if ($doctor->getSpecialtyFK() != null)
        if ($db_compare_doctor->getSpecialtyFK()->getID() != $doctor->getSpecialtyFK()->getID())
                $update_fields['specialty_fk'] = $doctor->getSpecialtyFK();

        if ($doctor->getUndergraduateSchool() != null)
        if ($db_compare_doctor->getUndergraduateSchool() != $doctor->getUndergraduateSchool())
                $update_fields['undergraduate_school'] = $doctor->getUndergraduateSchool();

        if ($doctor->getUndergraduateDegree() != null)
        if ($db_compare_doctor->getUndergraduateDegree() != $doctor->getUndergraduateDegree())
                $update_fields['undergraduate_degree'] = $doctor->getUndergraduateDegree();
        
        if ($doctor->getUndergraduateYear() != null)
        if ($db_compare_doctor->getUndergraduateYear() != $doctor->getUndergraduateYear())
                $update_fields['undergraduate_year'] = $doctor->getUndergraduateYear();
          
        if ($doctor->getGraduateSchool() != null)
        if ($db_compare_doctor->getGraduateSchool() != $doctor->getGraduateSchool())
                $update_fields['graduate_school'] = $doctor->getGraduateSchool();

        if ($doctor->getGraduateDegree() != null)
        if ($db_compare_doctor->getGraduateDegree() != $doctor->getGraduateDegree())
                $update_fields['graduate_degree'] = $doctor->getGraduateDegree();
        
        if ($doctor->getGraduateYear() != null)
        if ($db_compare_doctor->getGraduateYear() != $doctor->getGraduateYear())
                $update_fields['graduate_year'] = $doctor->getGraduateYear();
        
        
        if ($update_fields != "") {
            $where = "id=" . $doctor->getID();
            return $this->adapter->update($this->entityTable, $update_fields, $where);
        }
        else
            return 0;
    }

    protected function createEntity(array $row) {
        return new Doctor($row);
    }

}

?>
