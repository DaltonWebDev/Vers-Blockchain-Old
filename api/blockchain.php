<?php
header("Content-Type: application/json; charset=utf-8");
if (file_exists("blockchain.json")) {
  $blockchain = json_decode(file_get_contents("blockchain.json"), true);
} else {
  $blockchain = [];
}
$array = [
  "blockchain" => $blockchain
];
echo json_encode($array, JSON_PRETTY_PRINT);
?>
