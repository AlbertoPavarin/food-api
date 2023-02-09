<?php 
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

require("../../COMMON/connect.php");
require("../../MODEL/product.php");


$database = new Database();
$db_connection = $database->connect();

if (!isset($_GET['TAG_ID']))
{
    http_response_code(400);
    die(json_encode(["message" => "No id found"]));
}

$controller = new ProductController($db_connection);

$tag = $_GET['TAG_ID'];

$controller->getActiveProductByTag($tag);
?>