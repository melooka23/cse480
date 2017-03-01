<?php

class Loader {

    const DEFAULT_ACTION = 'listAction';
    const DEFAULT_CONTROLLER = 'MainController';

    protected $controller = self::DEFAULT_CONTROLLER;
    protected $action = self::DEFAULT_ACTION;
    protected $params = array();

    public function __construct() {
        error_reporting(E_ALL);
        ini_set('display_errors', '1');
        set_exception_handler(array($this, "Handler"));
        spl_autoload_register(array($this, "MyLoader"));
        session_start();
        $this->params = $_GET;
        $this->getAction();
        $this->getController();
    }

    public function Handler($ex) {
        CustomException::Handler($ex);
    }

    public function createController() {
//not getting good error checking from here
        $this->checkController();
//not getting good error checking from here.
        $this->checkAction();
        return new $this->controller($this->action, $this->params);
    }

// Class Loader
    public static function MyLoader($class) {
// pull apps from DB eventually or directory structure
        $apps = array("Main", "Person", "Messages");
        $found = false;
        
        $path = "/";


        $file = $_SERVER['DOCUMENT_ROOT'] . $path . "config/" . $class . '.php';
        if (file_exists($file)) {
            $found = true;
        } else {
            $file = $_SERVER['DOCUMENT_ROOT'] . $path . "lib/" . $class . '.php';
            if (file_exists($file)) {
                $found = true;
            } else {
                foreach ($apps as $app) {
                    $file = $_SERVER['DOCUMENT_ROOT'] . $path . "apps/" . $app . "/controller/" . $class . '.php';
                    if (file_exists($file)) {
                        $found = true;
                        break;
                    } else {
                        $file = $_SERVER['DOCUMENT_ROOT'] . $path . "apps/" . $app . "/model/" . $class . '.php';
                        if (file_exists($file)) {
                            $found = true;
                            break;
                        }
                    }
                }
            }
        }
        if ($found == true) {
            require_once $file;
        }
    }

    private function getController() {
        if (array_key_exists('controller', $this->params)) {
            $this->controller = $_GET['controller'] . "Controller";
        }
    }

    private function checkController() {
        if (!preg_match('/^[a-z0-9-]+$/i', $this->controller)) {
            throw new Exception('Unsafe Controller "' . $this->controller . '" requested');
        }
        if (class_exists($this->controller)) {
            $parents = class_parents($this->controller);
            if (!in_array("BaseController", $parents)) {
                return new Error("badUrl", $this->params);
            }
        } else {
            print "badUrl";
            print_r($this->controller);
            return;
        }
    }

    private function getAction() {
        if (array_key_exists('action', $this->params)) {
            $this->action = $_GET['action'] . "Action";
        }
    }

    private function checkAction() {
        if (!preg_match('/^[a-z0-9-]+$/i', $this->action)) {
            throw new Exception('Unsafe action "' . $this->action . '" requested');
        }
        if (!method_exists($this->controller, $this->action)) {
            print "badUrl";
            print_r($this->action);
            return;
        }
    }

}
