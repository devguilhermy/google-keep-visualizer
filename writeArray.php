<?php 

$myFile = "notes.json";
$fh = fopen($myFile, 'w') or die("impossible to open file");
$stringData = $_POST['array'];
$stringData=json_encode($stringData);
fwrite($fh, $stringData);
fclose($fh);


?>