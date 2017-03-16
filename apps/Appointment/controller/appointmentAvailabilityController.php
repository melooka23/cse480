<?php

    $patientProfileMapper = new PatientMapper();
    $patientProfile = $patientProfileMapper->findBy(array('person_fk' => $this->current_person->getID()));

    $this->ReturnView();
    require($this->template);