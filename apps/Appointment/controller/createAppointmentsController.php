<?php

    $appointmentTimeMapper = new AppointmentTimeMapper();
    $times = $appointmentTimeMapper->FindAll();
    
    $this->ReturnView();
    require($this->template);