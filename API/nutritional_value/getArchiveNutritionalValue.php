<?php
require("../../COMMON/connect.php");
require("../../MODEL/nutritionalValue.php");


$database = new Database();
$db_connection = $database->connect();

$controller = new NutritionalValuesController($db_connection);

$controller->getArchiveNutritionalValue();
?>