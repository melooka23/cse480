<?php

class PersonSecurityQuestionMapper extends BaseDataMapper {

    protected $entityTable = "PERSON_Security_Question";

    /* No updating security questions through the tool */
    protected function createEntity(array $row) {
        return new PersonSecurityQuestion($row);
    }

}

?>
