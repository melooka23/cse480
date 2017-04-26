<?php

include "../../../lib/Loader.php";
spl_autoload_register(array("Loader", "MyLoader"));

$mapper = new PersonMapper();

$role = filter_input(INPUT_GET, "role", FILTER_SANITIZE_NUMBER_INT);

if($role == 1){
    $people = $mapper->findAll(array('role_fk' => 1));
}
else{
    $people = $mapper->findAll();   
}

foreach ($people as $person) {
        $items[$person->getFullName()] = htmlentities($person->getID());
}

$response = isset($_GET['callback']) ? $_GET['callback'] . "(" . json_encode($items) . ")" : json_encode($items);
echo $response;