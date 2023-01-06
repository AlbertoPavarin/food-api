<?php 
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once dirname(__FILE__) . '/../../../COMMON/connect.php';
include_once dirname(__FILE__) . '/../../../MODEL/pickup.php';

$database = new Database();
$db = $database->connect();

if (!strpos($_SERVER["REQUEST_URI"], "?ID=")) // Controlla se l'URI contiene ?ID
{
    http_response_code(400);
    echo json_encode(array("Message" => "Bad request"));
}

$id = explode("?ID=" ,$_SERVER['REQUEST_URI'])[1]; // Viene ricavato quello che c'è dopo ?ID

$order = new Pickup($db);

$stmt = $order->getPickupById($id);

if ($stmt->num_rows > 0) // Se la funzione getOrder ha ritornato dei record
{
    $pickup_arr = array();
    while($record = $stmt->fetch_assoc()) // trasforma una riga in un array e lo fa per tutte le righe di un record
    {
       extract($record);
       $pickup_record = array(
        'id' => $id,
        'name' => $name
       );
       array_push($pickup_arr, $pickup_record);
    }
    http_response_code(200);
    echo json_encode($pickup_arr, JSON_PRETTY_PRINT);
    //return json_encode($order_arr);
}
else {
    http_response_code(404);
    echo json_encode(array("Message" => "No record"));
    //return json_encode(array("Message" => "No record"));
}
die();
?>