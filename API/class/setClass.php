<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
header("Content-Type: application/json; charset=UTF-8");

include_once dirname(__FILE__) . '/../../COMMON/connect.php';
include_once dirname(__FILE__) . '/../../MODEL/class.php';

if (isset($_GET["year"]))
    $year = $_GET["year"];

if (isset($_GET["section"]))
    $section = $_GET["section"];
 
$database = new Database();
$db = $database->connect();

$class = new Class_($db);

$stmt = $class->setClass($year,$section);

?>