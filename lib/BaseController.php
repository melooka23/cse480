<?php

abstract class BaseController {

    protected $params;
    protected $controller;
    protected $action;
    protected $view;
    protected $template;
    protected $current_person;
    protected $sidebar;
    protected $accesslevel;

    public function __construct($action, $params) {
        spl_autoload_register(array("Loader", "MyLoader"));
        $this->setCurrentPerson();
        $this->action = str_replace("Action", "", $action);
        $this->controller = str_replace("Controller", "", get_class($this));
        $this->params = $params;
    }

    protected function getSubController() {
        return require_once 'apps/' . $this->controller . '/controller/' . $this->action . 'Controller.php';
    }

    public function setCurrentPerson() {
        //Person Mapper
        $personMapper = new PersonMapper();
        
        
        if(isset($_POST['login-button'])){
            $login_fields = $_POST['login'];
            $username = $login_fields['username'];
            $password = $login_fields['password'];
            
            if(isset($username)){
                $personTryingToLogin = $personMapper->FindBy(array('username' => $username));
                
                if(!isset($personTryingToLogin)){
                    $personTryingToLogin = new Person();
                }
                
                if($password == $personTryingToLogin->getPassword()){
                    $_SESSION['user'] = $username;
                    //setcookie("user", $username);
                    $this->current_person = $personTryingToLogin;
                } else{
                    $this->current_person = null;
                }
            } else {
                $this->current_person == null;
            }
        } else if (isset($_SESSION["user"])) {
            $username = $_SESSION["user"];
            $this->current_person = $personTryingToLogin = $personMapper->FindBy(array('username' => $username));
        } else {
            $username = "";
            $this->current_person = null;
        }

        
if ($this->current_person == null) { //current person is not set
            if ((get_class($this) != "PersonController") && (($this->action != "addeditPersonAction"))) { //not on register or forgot password pages
                $this->addCurrentPerson($username);
            }
            return null;
        }

        $this->params['current_person'] = $this->current_person;
        
        
    }
    

    public function getCurrentPerson() {
        return $this->current_person;
    }

    public function addCurrentPerson($username) {
        Utils::redirect('Person', 'loginPerson');
    }


    public function ExecuteAction() {
        return $this->{$this->action . "Action"}();
    }

    protected function ReturnView() {
        $this->view = 'apps/' . $this->controller . '/view/' . $this->action . 'Action.phtml';

        if (file_exists($this->view)) {
                $this->template = 'layout/index.phtml';
        }
        else
            unset($this->view);
    }

}
?>
