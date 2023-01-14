<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once dirname(__FILE__) . '/../../../COMMON/connect.php';
include_once dirname(__FILE__) . '/../../../MODEL/break.php';

$database = new Database();
$db = $database->connect();

$break = new Break_($db);

$stmt = $break -> getArchiveBreak();

if ($stmt->num_rows > 0) // Se la funzione getBreak ha ritornato dei record
{
    $break_arr = array();
    while($record = $stmt->fetch_assoc()) // trasforma una riga in un array e lo fa per tutte le righe di un record
    {
       extract($record); // importa variabili da un array
       $break_record = array(
        'id' => $id,
        'time' => $time,
       );
       array_push($break_arr, $break_record); // appende il record all'array che contiene tutti i record
    }
    http_response_code(200);
    echo json_encode($break_arr, JSON_PRETTY_PRINT);
    
    //return json_encode($break_arr, JSON_PRETTY_PRINT);
}
else {
    http_response_code(404);
    echo json_encode(["message" => "No record"]);    
    //return json_encode(array("Message" => "No record"));
}
die();
?>