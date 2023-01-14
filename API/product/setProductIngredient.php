<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

require("../../COMMON/connect.php");
require("../../MODEL/product.php");

$data = json_decode(file_get_contents("php://input"));

if (empty($data) || empty($data->product) || empty($data->ingredient))
{
    http_response_code(400);
    echo json_encode(array("Message" => "Bad request"));
    die();
}

$database = new Database();
$db_connection = $database->connect();

$controller = new ProductController($db_connection);
$controller->setProductIngredient($data->product,$data->ingredient);

?>