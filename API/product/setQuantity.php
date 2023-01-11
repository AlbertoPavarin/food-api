<?php
require("../../COMMON/connect.php");
require("../../MODEL/product.php");

if (isset($_GET["PRODUCT_ID"]))
$product_id = $_GET["PRODUCT_ID"];

if (isset($_GET["QUANTITY"]))
$quantity = $_GET["QUANTITY"];

$database = new Database();
$db_connection = $database->connect();

$controller = new ProductController($db_connection);
$controller->setQuantity($product_id,$quantity);
/*if (strlen($product) > 2)
    $controller->DeleteProduct($product);
else
    $controller->SendError(JSON_OK);*/
?>