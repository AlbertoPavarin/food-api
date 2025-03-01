<?php 
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once dirname(__FILE__) . '/../../COMMON/connect.php';
include_once dirname(__FILE__) . '/../../MODEL/order.php';

$database = new Database();
$db = $database->connect();

$order = new Order($db);

if (!isset($_GET['year']) || !isset($_GET['section']))
{
    http_response_code(400);
    echo json_encode(array("Message" => "Bad request"));
    die();
}

$stmt = $order->getArchiveOrderByClass($_GET['year'], $_GET['section']);

if ($stmt->num_rows > 0) // Se la funzione getArchiveOrderStatus ha ritornato dei record
{
    $order_arr = array();
    while($record = $stmt->fetch_assoc()) // trasforma una riga in un array e lo fa per tutte le righe di un record
    {
       extract($record);
       $order_record = array(
        'id' => $id,
        'year' => $year,
        'section' => $section,
        'created' => $created,
        'pickup' => $pickup,
        'break' => $break,
        'status' => $status,
        'json' => json_decode($json)
       );
       array_push($order_arr, $order_record);
    }
    http_response_code(200);
    echo json_encode($order_arr, JSON_PRETTY_PRINT); 
    //return json_encode($order_arr);
}
else {
    http_response_code(404);
    echo json_encode(array("Message" => "No record"));
    //return json_encode(array("Message" => "No record"));
}
die();
?>