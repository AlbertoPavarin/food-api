<?php
require("../../COMMON/connect.php");
require("../../MODEL/product.php");

if (!isset($_GET["PRODUCT_ID"]) || empty($_GET['PRODUCT_ID'])){
    http_response_code(400);
    echo json_encode(array("Message" => "Bad request"));
    die();
}

$product = $_GET['PRODUCT_ID'];

$database = new Database();
$db_connection = $database->connect();


$controller = new ProductController($db_connection);


if (!empty($_GET['PRODUCT_ID']))
    $controller->getProductAllergen($product);
else
    $controller->SendError(JSON_OK);
?>
