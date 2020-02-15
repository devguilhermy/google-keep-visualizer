<?php 

$response = [];
$notes = [];
if (isset($_REQUEST['array'])) {
    $notes = $_REQUEST['array'];
    $fp = fopen('notes.json', 'w');
    fwrite($fp, json_encode($notes));
    fclose($fp);

    
    $response = ["status" => "success"];

} else {
    $response = ["status" => "error"];
}


echo json_decode($response);


?>