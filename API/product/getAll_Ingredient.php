<?php
require("../../COMMON/connect.php");
require("../../MODEL/ingredient.php");

$database = new Database();
$db_connection = $database->connect();


$controller = new IngredientController($db_connection);

$controller->getArchiveIngredient();
?>