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
        $host = gethostname();
        
            if (isset($_POST['login-field'])) {
                $username = $_POST['login-field'];
                setcookie("user", $_POST['login-field']);
            } else if (isset($_COOKIE["user"])) {
                $username = $_COOKIE["user"];
            } else {
                $username = "";
            }
        
        $personMapper = new PersonMapper();
        $this->current_person = $personMapper->FindBy(array('username' => $username));

        $this->params['current_person'] = $this->current_person;
    }
    

    public function getCurrentPerson() {
        return $this->current_person;
    }

    public function addCurrentPerson($username) {
        $this->params['username'] = $username;
        Utils::redirect('Person', 'addeditPerson', $this->params);
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
