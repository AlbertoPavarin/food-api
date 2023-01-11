<?php 
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once dirname(__FILE__) . '/../../COMMON/connect.php';
include_once dirname(__FILE__) . '/../../MODEL/class.php';

$database = new Database();
$db = $database->connect();

$class = new Class_($db);

if (!isset($_GET['ID']))
{
    http_response_code(400);
    echo json_encode(array("Message" => "Bad request"));
    die();
}

$stmt = $class->getClass($_GET['ID']);

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
else {
    http_response_code(404);
    echo json_encode(array("Message" => "No record"));
    //return json_encode(array("Message" => "No record"));
}
die();
?>