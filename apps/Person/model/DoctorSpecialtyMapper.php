<?php

class DoctorSpecialtyMapper extends BaseDataMapper {

    protected $entityTable = "DOCTOR_Specialty";

    protected function createEntity(array $row) {
        return new DoctorSpecialty($row);
    }

}

?>
