<?php


        $personMapper = new personMapper();
        
        if (isset($_POST['register'])) {//second pass
            $this->thisperson = new Person($_POST['register']);
        } else //first pass - new person
            $this->thisperson = new Person();
            
        if(isset($_POST['register-button'])){
            if ($this->thisperson->getID() == null) {
                if (!is_object($this->current_person)) {
                    //adding self as inactive  - email will go to user
                    $personMapper->Insert($this->thisperson);
                }
            }
            //Flash::addFlash('User saved successfully.');
            
            Utils::redirect('Person', 'loginPerson');
        }


$this->ReturnView();
require($this->template);