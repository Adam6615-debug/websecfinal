<?php
header('Content-Type: application/json');
echo json_encode([
    'message' => 'Basic PHP is working',
    'time' => date('Y-m-d H:i:s'),
    'server' => $_SERVER['SERVER_SOFTWARE']
]); 