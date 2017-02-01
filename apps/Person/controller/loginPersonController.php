<?php
        if(isset($this->current_person)){
            Utils::redirect('Main', 'list');
        }
        
        $this->ReturnView();
        require($this->template);