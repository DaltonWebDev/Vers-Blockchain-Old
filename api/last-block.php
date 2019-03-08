<?php
include("functions.php");
header("Content-Type: application/json; charset=utf-8");
$blockchain = json_decode(file_get_contents("blockchain.json"), true);
$data = end($blockchain);
if (!file_exists("blockchain.json")) {
  $index = 0;
  $previousHash = 0;
} else {
  $index = $data["index"];
  $previousHash = $data["previousHash"];
}
$blockchain = array(
  "index" => $index,
  "previousHash" => $previousHash,
  "data" => $data["data"],
  "timestamp" => $data["timestamp"],
  "hash" => $data["hash"],
  "nonce" => $data["nonce"]
);
echo json_encode($blockchain, JSON_PRETTY_PRINT);
?>
