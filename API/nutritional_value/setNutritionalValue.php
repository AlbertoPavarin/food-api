<?php
require("../../COMMON/connect.php");
require("../../MODEL/nutritionalValue.php");


if (isset($_GET["kcal"]))
    $kcal = $_GET["kcal"];

if (isset($_GET["fats"]))
    $fats = $_GET["fats"];

if (isset($_GET["saturated_fats"]))
    $saturated_fats = $_GET["saturated_fats"];

if (isset($_GET["carbohydrates"]))
    $carbohydrates = $_GET["carbohydrates"];

if (isset($_GET["sugars"]))
    $sugars = $_GET["sugars"];
 
if (isset($_GET["proteins"]))
    $proteins = $_GET["proteins"];

if (isset($_GET["fiber"]))
    $fiber = $_GET["fiber"];

if (isset($_GET["salt"]))
    $salt = $_GET["salt"];
   
$database = new Database();
$db_connection = $database->connect();

$controller = new NutritionalValuesController($db_connection);
$controller->setNutritionalValue($kcal,$fats,$saturated_fats,$carbohydrates,$sugars,$proteins,$fiber,$salt);

?>