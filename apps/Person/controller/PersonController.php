<?php

final class PersonController extends BaseController {

    protected $thisperson;
    protected $thiscompany;


    public function addeditPersonAction() {
        $personMapper = new personMapper();
        if (isset($_POST['person'])) { //second pass
            $this->thisperson = new Person($_POST['person']);
            $old_person = $personMapper->FindBy(array('id' => $this->thisperson->getID()));
        } else if (isset($_GET['username'])) //first pass - current person does not exist in DB
            if (isset($this->params['email']))
                $this->thisperson = new Person(array('username' => $_GET['username'], 'email' => $this->params['email']));
            else
                $this->thisperson = new Person(array('username' => $_GET['username']));
        else if (isset($this->params['id'])) { //first pass - edit person
            $this->thisperson = $personMapper->FindBy(array('id' => $this->params['id']));
        }
        else //first pass - new persons
            $this->thisperson = new Person();

        if (isSet($_POST['save'])) {
//validate -- this should only be needed if the javascript validation fails.
            $errors = PersonValidator::validate($this->thisperson);
            if ($errors == 0) {
                $personMapper = new PersonMapper();
                if ($this->thisperson->getID() == null) {
                    if (!is_object($this->current_person)) {
                        //adding self as inactive  - email will go to user
                        $personMapper->Insert($this->thisperson, -1);
                        $profileMapper = new ProfileMapper();
                        $profile = new Profile();
                        $profile->setPersonFK($this->thisperson->getID());
                        $profile->setStateFK(0);
                        $profileMapper->insert($profile);
                        //TODO - Meg - Replace email recipient with a pull-down of administrators.
                        $recipient = "margaret.e.corr.ctr@mail.mil"; //recipient
                        $mail_body = $this->thisperson->getName() . " has requested access to the Tools Suite, please process as soon as possible.\r\n";
                        $subject = "Tools Suite User Access Request"; //subject
                        Utils::SendMessage($recipient, $subject, $mail_body, $this->controller, "Initial Entry");
                    } else {
                        //administrator adding user
                        $personMapper->Insert($this->thisperson, 1);
                        $profileMapper = new ProfileMapper();
                        $profile = new Profile();
                        $profile->setPersonFK($this->thisperson->getID());
                        $profile->setStateFK(0);
                        $profileMapper->insert($profile);
                        //TODO - Meg - This code might go elsewhere -- also make it generic.
                        if (isset($_POST['administrator']) && $this->thisperson->isAdministrator() != true) {
                            $role_mapper = new RoleMapper();
                            $administrator_role = $role_mapper->FindBy(array('role' => 'Administrator'));
                            $person_roleMapper = new PersonRoleMapper();
                            $person_role = new PersonRole(array('person_fk' => $this->thisperson->getID(), 'role_fk' => $administrator_role->getID()));
                            $person_roleMapper->insert($person_role);
                        } elseif (!isset($_POST['administrator']) && $this->thisperson->isAdministrator() == true) {
                            $role_mapper = new RoleMapper();
                            $administrator_role = $role_mapper->FindBy(array('role' => 'Administrator'));
                            $person_roleMapper = new PersonRoleMapper();
                            $person_role = $person_roleMapper->FindBy(array('person_fk' => $this->thisperson->getID(), 'role_fk' => $administrator_role->getID()));
                            $person_roleMapper->delete($person_role);
                        }
                        if (isset($_POST['supervisor']) && $this->thisperson->isSupervisor() != true) {
                            $role_mapper = new RoleMapper();
                            $supervisor_role = $role_mapper->FindBy(array('role' => 'Supervisor'));
                            $person_roleMapper = new PersonRoleMapper();
                            $person_role = new PersonRole(array('person_fk' => $this->thisperson->getID(), 'role_fk' => $supervisor_role->getID()));
                            $person_roleMapper->insert($person_role);
                        } elseif (!isset($_POST['supervisor']) && $this->thisperson->isSuperVisor() == true) {
                            $role_mapper = new RoleMapper();
                            $supervisor_role = $role_mapper->FindBy(array('role' => 'Supervisor'));
                            $person_roleMapper = new PersonRoleMapper();
                            $person_role = $person_roleMapper->FindBy(array('person_fk' => $this->thisperson->getID(), 'role_fk' => $supervisor_role->getID()));
                            $person_roleMapper->delete($person_role);
                        }
                    }
                } else {
                    //update
                    if (isset($_POST['active'])) {
                        $this->thisperson->setActive(1);
                        if ($old_person->getActive() != 1) {
                            $recipient = $this->thisperson->getEmail() . ", " . $this->current_person->getEmail();
                            $mail_body = "You have been activated in the Tool Suite Database.\n\rPlease go to the link identified below to access the tool.\r\n";
                            $subject = "Tools Suite Access confirmed"; //subject
                            Utils::SendMessage($recipient, $subject, $mail_body, $this->controller, $this->current_person->getFullName());
                        }
                    } elseif (!isset($_POST['active']))
                        $this->thisperson->setActive(0);
                    if (isset($_POST['single_charger']))
                        $this->thisperson->setSingleCharger(1);
                    else
                        $this->thisperson->setSingleCharger(0);
                    //TODO - Meg - this code might go elsewhere -- also make it generic for any type of org role.
                    if (isset($_POST['administrator']) && $old_person->isAdministrator() != true) {
                        $role_mapper = new RoleMapper();
                        $administrator_role = $role_mapper->FindBy(array('role' => 'Administrator'));
                        $person_roleMapper = new PersonRoleMapper();
                        $person_role = new PersonRole(array('person_fk' => $this->thisperson->getID(), 'role_fk' => $administrator_role->getID()));
                        $person_roleMapper->insert($person_role);
                    } elseif (!isset($_POST['administrator']) && $old_person->isAdministrator() == true) {
                        $role_mapper = new RoleMapper();
                        $administrator_role = $role_mapper->FindBy(array('role' => 'Administrator'));
                        $person_roleMapper = new PersonRoleMapper();
                        $person_role = $person_roleMapper->FindBy(array('person_fk' => $this->thisperson->getID(), 'role_fk' => $administrator_role->getID()));
                        $person_roleMapper->delete($person_role);
                    }
                    if (isset($_POST['supervisor']) && $old_person->isSupervisor() != true) {
                        $role_mapper = new RoleMapper();
                        $supervisor_role = $role_mapper->FindBy(array('role' => 'Supervisor'));
                        $person_roleMapper = new PersonRoleMapper();
                        $person_role = new PersonRole(array('person_fk' => $this->thisperson->getID(), 'role_fk' => $supervisor_role->getID()));
                        $person_roleMapper->insert($person_role);
                    } elseif (!isset($_POST['supervisor']) && $old_person->isSuperVisor() == true) {
                        $role_mapper = new RoleMapper();
                        $supervisor_role = $role_mapper->FindBy(array('role' => 'Supervisor'));
                        $person_roleMapper = new PersonRoleMapper();
                        $person_role = $person_roleMapper->FindBy(array('person_fk' => $this->thisperson->getID(), 'role_fk' => $supervisor_role->getID()));
                        $person_roleMapper->delete($person_role);
                    }
                    $personMapper->Update($this->thisperson);
                }
                Flash::addFlash('User saved successfully.');
            }
        }
//Redirect appropriately
        if (isset($_POST['save']) && $errors == 0) {
            if (isset($this->params['username'])) {
                $this->current_person = $this->thisperson;
                Utils::redirect('Main', 'list');
            }
        }
        $this->ReturnView();
        require($this->template);
    }

    public function listPersonsAction() {
        if (isSet($_POST['add'])) {
            Utils::redirect('Person', 'addeditPerson');
        }
        $personMapper = new PersonMapper();
        if (isset($_GET['all'])) {
            $persons = $personMapper->FindAll();
        } else {
            $persons = $personMapper->FindAll(array('active' => 1));
        }
//create an array from the fields we actually want to see
        foreach ($persons as $person) {
            $id = $person->getID();
            $mylist[$id]['Username'] = $person->getUsername();
            $mylist[$id]['Name'] = $person->getName();
            $mylist[$id]['Email'] = $person->getEmail();
            $mylist[$id]['Domain'] = $person->getDomainFK()->getDomain();
            $mylist[$id]['Company'] = $person->getCompanyFK()->getName();
            $mylist[$id]['Organization'] = $person->getOrganizationFK()->getOrganization();
            $mylist[$id]['Supervisor'] = $person->getSupervisorFK()->getLastName();
            if ($person->getActive() == 1)
                $mylist[$id]['Active?'] = "Active";
            else if ($person->getActive() == -1)
                $mylist[$id]['Active?'] = "Pending";
            else
                $mylist[$id]['Active?'] = "NOT Active";
        }
        $this->ReturnView();
        require($this->template);
    }

}

?>
