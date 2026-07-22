<?php
require_once __DIR__ . '/function.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed']);
    exit;
}

$barcode = sanitizeBarcode($_POST['barcode'] ?? '');

if ($barcode === '') {
    http_response_code(400);
    echo json_encode(['error' => 'Barcode is required']);
    exit;
}

// Example: here we simply return the barcode. In a real app, you could query a database.
header('Content-Type: application/json');
echo json_encode(['success' => true, 'barcode' => $barcode]);
