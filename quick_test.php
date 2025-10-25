<?php

// Quick test for API JSON responses
$baseUrl = 'http://localhost:8000/api';

echo "Testing API JSON Error Responses...\n\n";

// Test 1: Wrong method to /me endpoint
echo "1. Testing POST to GET endpoint (/me):\n";
$context = stream_context_create([
    'http' => [
        'method' => 'POST',
        'header' => 'Content-Type: application/json',
        'ignore_errors' => true
    ]
]);

$response = file_get_contents($baseUrl . '/me', false, $context);
echo "Response: " . $response . "\n\n";

// Test 2: Non-existent endpoint
echo "2. Testing non-existent endpoint:\n";
$response = file_get_contents($baseUrl . '/nonexistent', false, $context);
echo "Response: " . $response . "\n\n";

echo "Test completed!\n";
