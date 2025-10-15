<?php
header('Content-Type: application/json');
$data = json_decode(file_get_contents('php://input'), true);
$file = __DIR__ . '/../data/modules.json';
file_put_contents($file, json_encode($data, JSON_PRETTY_PRINT));
echo json_encode(["status" => "success"]);
