<?php

final class Person extends BaseObject {

    protected $id;
    private $first_name;
    private $last_name;
    private $email;
    private $username;
    private $password;
    private $role_fk;
    private $security_question_fk;
    private $security_answer;

    public static function compareLast($m, $n) {
        if ($m->last_name == $n->last_name)
            return 0;
        return ($m->last_name < $n->last_name) ? -1 : 1;
    }

    public function getFullName() {
        $full_name = $this->first_name . " ";
        if (!empty($this->middle))
            $full_name .= $this->middle . " ";
        $full_name .= $this->last_name;
        return $full_name;
    }

    public function getName() {
        return $this->last_name . ", " . $this->first_name;
    }

    public function getFirstName() {
        return $this->first_name;
    }

    public function setFirstName($first_name) {
        $this->first_name = $first_name;
    }

    public function getLastName() {
        return $this->last_name;
    }

    public function setLastName($last_name) {
        $this->last_name = $last_name;
    }

    public function getEmail() {
        return $this->email;
    }

    public function setEmail($email) {
        $this->email = $email;
    }

    public function getUsername() {
        return $this->username;
    }

    public function setUsername($username) {
        $this->username = $username;
    }

    public function getPassword() {
        return $this->password;
    }

    public function setPassword($password) {
        $this->password = $password;
    }
    
    public function getRoleFK() {
        if (is_numeric($this->role_fk)) {
            $roleMapper = new RoleMapper();
            $this->role_fk = $roleMapper->FindBy(array('id' => $this->role_fk));
        } elseif (empty($this->role_fk))
            $this->role_fk = new Role();
        return $this->role_fk;
    }

    public function setRoleFK($role_fk) {
        $this->role_fk = $role_fk;
    }
    
    public function getSecurityQuestionFK() {
        if (is_numeric($this->security_question_fk)) {
            $securityQuestionMapper = new PersonSecurityQuestionMapper();
            $this->security_question_fk = $securityQuestionMapper->FindBy(array('id' => $this->security_question_fk));
        } elseif (empty($this->security_question_fk))
            $this->$security_question_fk = new PersonSecurityQuestion();
        return $this->security_question_fk;
    }

    public function setSecurityQuestionFK($security_question_fk) {
        $this->security_question_fk = $security_question_fk;
    }
    
    public function getSecurityAnswer() {
        return $this->security_answer;
    }

    public function setSecurityAnswer($security_answer) {
        $this->security_answer = $security_answer;
    }

}

