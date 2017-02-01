<?php

include "../../../lib/Loader.php";
spl_autoload_register(array("Loader", "MyLoader"));

$questionMapper = new PersonSecurityQuestionMapper();
$questions = $questionMapper->findAll();
foreach ($questions as $question) {
  $items[$question->getQuestion()] = htmlentities($question->getID());
}
$response = isset($_GET['callback']) ? $_GET['callback'] . "(" . json_encode($items) . ")" : json_encode($items);
echo $response;