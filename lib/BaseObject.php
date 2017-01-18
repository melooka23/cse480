<?php

abstract class BaseObject {

    public function __construct(array $info = array()) {
        spl_autoload_register(array("Loader", "MyLoader"));
        $this->Fill($info);
        return $this;
    }

    public function Fill(array $info = array()) {
        foreach (array_keys($info) as $key) {
            $my_method = 'set' . Utils::camelCase($key);
            if (isset($info[$key])) {
                if (method_exists($this, $my_method)) {
                    call_user_func(array(&$this, $my_method), $info[$key]);
                } else {
                    $msg = __METHOD__ . ": '" . get_class($this) . "' is missing {$my_method}";
                    Utils::logToClientConsole($msg);
                    print 'FILL Problem (Function Not Found):  ' . get_class($this) . '.' . $my_method . '<br>';
                }
            }
        }
        return $this;
    }

    public function getID() {
        return $this->id;
    }

    public function setID($id) {
        if ($this->id !== null && $this->id != $id && $this->id != 0)
            throw new Exception('Cannot change identifier to ' . $id . ', already set to ' . $this->id);
        $this->id = (int) $id;
    }

}
