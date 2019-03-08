<?php
error_reporting(0);
ini_set("display_errors", 0);
set_time_limit(0);
function add($data) {
	if (!file_exists("blockchain.json")) {
		$blockchain = [];
	} else {
		$blockchain = json_decode(file_get_contents("blockchain.json"), true);
	}
	$latestBlock = end($blockchain);
	$checkHash = hash("sha256", $data["index"] . $data["previousHash"] . $data["data"] . $data["timestamp"] . $data["nonce"]);
	if (count($blockchain) !== 0 && $data["index"] !== $latestBlock["index"] + 1) {
		return "Block index must be 1 greater than the previous index.";
	} else if (count($blockchain) === 0 && $data["index"] !== 0) {
		return "Index entry must be 0 for genesis block.";
	} else if (count($blockchain) !== 0 && $data["previousHash"] !== $latestBlock["hash"]) {
		return "Previous hash mismatch!";
	} else if (count($blockchain) === 0 && $data["previousHash"] !== 0) {
		return "Previous block entry must be 0 for genesis block.";
	} else if (empty($data["data"])) {
		return "Enter something before sending!";
	} else if (strlen($data) > 1000) {
		return "Data can't exceed 1,000 characters.";
	} else if (count($blockchain) !== 0 && $data["timestamp"] < $latestBlock["timestamp"]) {
		return "Timestamp must be greater than previous timestamp.";
	} else if ($checkHash !== $data["hash"]) {
		return "The hash you entered was invalid!";
	} else if (substr($data["hash"], 0, 5) !== "00000") {
		return "Hash must start with 4 zeros!";
	} else {
		$blockchain[] = array(
			"index" => $data["index"],
			"previousHash" => $data["previousHash"],
			"data" => $data["data"],
			"timestamp" => $data["timestamp"],
			"hash" => $data["hash"],
			"nonce" => $data["nonce"]
		);
		file_put_contents("blockchain.json", json_encode($blockchain, JSON_PRETTY_PRINT));
		return true;
	}
}
function mine($index, $previousHash, $data, $timestamp) {
	$nonce = 1;
	$hash = hash("sha256", $index . $previousHash . $data . $timestamp . $nonce);
	while (substr($hash, 0, 5) !== "00000") {
		$nonce++;
		$hash = hash("sha256", $index . $previousHash . $data . $timestamp . $nonce);
	}
	return "$index, $hash, $nonce, $timestamp";
}
//echo mine(0, 0, "hello, world!", time());
?>
