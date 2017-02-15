<?php

include "../../../lib/Loader.php";
spl_autoload_register(array("Loader", "MyLoader"));

$mapper = new DoctorSpecialtyMapper();
$specialties = $mapper->findAll();
foreach ($specialties as $specialty) {
  $items[$specialty->getSpecialty()] = htmlentities($specialty->getID());
}
$response = isset($_GET['callback']) ? $_GET['callback'] . "(" . json_encode($items) . ")" : json_encode($items);
echo $response;