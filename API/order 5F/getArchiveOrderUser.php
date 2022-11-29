<?php 
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once dirname(__FILE__) . '/../config/database.php';
include_once dirname(__FILE__) . '/../models/order.php';

$database = new Database();
$db = $database->connect();

if (!strpos($_SERVER["REQUEST_URI"], "?USER_ID=")) // Controlla se l'URI contiene ?USER_ID
{
    http_response_code(400);
    die(json_encode(array("Message" => "Bad request")));
}

$id = explode("?USER_ID=" ,$_SERVER['REQUEST_URI'])[1]; // Viene ricavato quello che c'è dopo ?USER_ID

$order = new Order($db);

$stmt = $order->getArchiveOrderUser($id);

if ($stmt->num_rows > 0) // Se la funzione getArchiveOrderBreak ha ritornato dei record
{
    $order_arr = array();
    while($record = $stmt->fetch_assoc()) // trasforma una riga in un array e lo fa per tutte le righe di un record
    {
       extract($record);
       $order_record = array(
        'ID' => $ID,
        'user_ID' => $user_ID,
        'total_price' => $total_price,
        'date_hour_sale' => $date_hour_sale,
        'break_ID' => $break_ID,
        'status_ID' => $status_ID,
        'pickup_ID' => $pickup_ID,
        'json' => json_decode($json)
       );
       array_push($order_arr, $order_record);
    }
    echo json_encode($order_arr, JSON_PRETTY_PRINT);
    http_response_code(200);
    return json_encode($order_arr);
}
else {
    echo "\n\nNo record";
    http_response_code(404);
    return json_encode(array("Message" => "No record"));
}
?>