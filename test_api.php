<?php

// Test API endpoints
$baseUrl = 'http://localhost:8000/api';

echo "Testing API Error Responses...\n\n";

// Test 1: Wrong method to /me endpoint
echo "1. Testing POST to GET endpoint (/me):\n";
$response = file_get_contents($baseUrl . '/me', false, stream_context_create([
    'http' => [
        'method' => 'POST',
        'header' => 'Content-Type: application/json'
    ]
]));

echo "Response: " . $response . "\n\n";

// Test 2: Non-existent endpoint
echo "2. Testing non-existent endpoint:\n";
$response = file_get_contents($baseUrl . '/nonexistent', false, stream_context_create([
    'http' => [
        'method' => 'GET',
        'header' => 'Content-Type: application/json'
    ]
]));

echo "Response: " . $response . "\n\n";

// Test 3: Login with missing password
echo "3. Testing login with missing password:\n";
$postData = json_encode(['email' => 'test@example.com']);
$response = file_get_contents($baseUrl . '/login', false, stream_context_create([
    'http' => [
        'method' => 'POST',
        'header' => 'Content-Type: application/json',
        'content' => $postData
    ]
]));

echo "Response: " . $response . "\n\n";

echo "All tests completed!\n";
