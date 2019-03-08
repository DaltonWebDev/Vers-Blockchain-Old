<?php
header("Content-Type: application/json; charset=utf-8");
include("functions.php");
$data = !empty($_REQUEST["data"]) ? json_decode($_REQUEST["data"], true) : false;
if ($data === false) {
  $error = "Data is missing!";
} else {
  $error = false;
  $added = add($data);
}
/*
api_error = BOOLEAN false on success, STRING explanation on failure
added = BOOLEAN true on success, STRING explanation on failure
*/
$array = [
  "api_error" => $error,
  "added" => $added
];
echo json_encode($array, JSON_PRETTY_PRINT);
?>
