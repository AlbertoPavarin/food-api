<?php
require("../../COMMON/connect.php");
require("../../MODEL/ingredient.php");

if (isset($_GET["id"]))
    $id = $_GET["id"];

if (isset($_GET["name"]))
    $name = $_GET["name"];

if (isset($_GET["description"]))
    $description = $_GET["description"];

if (isset($_GET["price"]))
    $price = $_GET["price"];

if (isset($_GET["extra"]))
    $extra = $_GET["extra"];

if (isset($_GET["quantity"]))
    $quantity = $_GET["quantity"];


$database = new Database();
$db_connection = $database->connect();

$controller = new IngredientController($db_connection);
$controller->updateIngredient($id, $name, $description,$price,$extra, $quantity);
?>