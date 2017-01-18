<?php

class MainController extends BaseController {

    public function listAction() {
        
        $this->ReturnView();
        require($this->template);
    }

}

?>
