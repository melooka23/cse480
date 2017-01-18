<?php

class PersonMapper extends BaseDataMapper {

    protected $entityTable = "PERSON";

    public function insert(Person $person) {
        if ($person == null) {
            throw new Exception('User is empty.');
        }
        $person_values = array(
            'username' => $person->getUsername(),
            'last_name' => $person->getLastName(),
            'first_name' => $person->getFirstName(),
            'email' => $person->getEmail(),
            'password' => $person->getPassword());

        $person->setID($this->adapter->insert($this->entityTable, $person_values));
        return $person;
//NEED TO ADD PERSON ROLE (DOCTOR OR PATIENT FROM HERE)
    }

    public function update(Person $person) {
        $db_compare_person = $this->FindBy(array('id' => $person->getID()));
        $update_fields = "";

        if ($db_compare_person->getEmail() != $person->getEmail())
            $update_fields['email'] = $person->getEmail();

        if ($db_compare_person->getFirstName() != $person->getFirstName())
            $update_fields['first_name'] = $person->getFirstName();

        if ($db_compare_person->getLastName() != $person->getLastName())
            $update_fields['last_name'] = $person->getLastName();

        if ($db_compare_person->getUsername() != $person->getUsername())
            $update_fields['username'] = $person->getUsername();

        if ($db_compare_person->getPassword() != $person->getPassword())
            $update_fields['password'] = $person->getPassword();
            
        if ($update_fields != "") {
            $where = "id=" . $person->getID();
            return $this->adapter->update($this->entityTable, $update_fields, $where);
        }
        else
            return 0;
    }

    protected function createEntity(array $row) {
        return new Person($row);
    }

}

?>
