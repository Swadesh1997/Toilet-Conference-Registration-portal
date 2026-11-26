<?php
session_start();
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
session_unset();
session_destroy();
echo json_encode([
    "success" => true,
    "message" => "User successfully logged out."
]);

