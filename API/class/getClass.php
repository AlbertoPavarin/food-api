<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
header("Content-Type: application/json; charset=UTF-8");

include_once dirname(__FILE__) . '/../../COMMON/connect.php';
include_once dirname(__FILE__) . '/../../MODEL/class.php';

$database = new Database();
$db = $database->connect();

$class = new Class_($db);

$stmt = $class->getClass();

if ($stmt->num_rows > 0) // Se la funzione getArchiveOrderStatus ha ritornato dei record
{
    $class_arr = array();
    while($record = $stmt->fetch_assoc()) // trasforma una riga in un array e lo fa per tutte le righe di un record
    {
       extract($record);
       $class_record = array(
        'id' => $id,
        'year' => $year,
        'section' => $section,
       );
       array_push($class_arr, $class_record);
    }
    http_response_code(200);
    echo json_encode($class_arr, JSON_PRETTY_PRINT); 
    //return json_encode($order_arr);
}

?>