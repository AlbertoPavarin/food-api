<?php
require("../../COMMON/connect.php");
require("../../MODEL/nutritionalValue.php");


$database = new Database();
$db_connection = $database->connect();

if (!strpos($_SERVER["REQUEST_URI"], "?NUTRITIONALVALUE_ID=")) // Controlla se l'URI contiene ?PRODUCT_ID
{
    http_response_code(400);
    echo json_encode(array("Message" => "Bad request"));
}

$nutritionlValue_id = explode("?NUTRITIONALVALUE_ID=", $_SERVER["REQUEST_URI"])[1];// per ottenere il valore posto dopo di product_id

$controller = new NutritionalValuesController($db_connection);

$controller->getNutritionalValue($nutritionlValue_id);
?>