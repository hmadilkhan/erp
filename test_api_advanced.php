<?php

// Test API endpoints with proper error handling
$baseUrl = 'http://localhost:8000/api';

echo "Testing API Error Responses...\n\n";

function makeRequest($url, $method = 'GET', $data = null) {
    $context = stream_context_create([
        'http' => [
            'method' => $method,
            'header' => 'Content-Type: application/json',
            'content' => $data ? json_encode($data) : null,
            'ignore_errors' => true // This allows us to get the response even with error status codes
        ]
    ]);
    
    $response = file_get_contents($url, false, $context);
    $headers = $http_response_header ?? [];
    
    return [
        'body' => $response,
        'headers' => $headers
    ];
}

// Test 1: Wrong method to /me endpoint
echo "1. Testing POST to GET endpoint (/me):\n";
$result = makeRequest($baseUrl . '/me', 'POST');
echo "Response Body: " . $result['body'] . "\n";
echo "Status: " . (isset($result['headers'][0]) ? $result['headers'][0] : 'Unknown') . "\n\n";

// Test 2: Non-existent endpoint
echo "2. Testing non-existent endpoint:\n";
$result = makeRequest($baseUrl . '/nonexistent', 'GET');
echo "Response Body: " . $result['body'] . "\n";
echo "Status: " . (isset($result['headers'][0]) ? $result['headers'][0] : 'Unknown') . "\n\n";

// Test 3: Login with missing password
echo "3. Testing login with missing password:\n";
$result = makeRequest($baseUrl . '/login', 'POST', ['email' => 'test@example.com']);
echo "Response Body: " . $result['body'] . "\n";
echo "Status: " . (isset($result['headers'][0]) ? $result['headers'][0] : 'Unknown') . "\n\n";

// Test 4: Valid login
echo "4. Testing valid login:\n";
$result = makeRequest($baseUrl . '/login', 'POST', ['email' => 'admin@example.com', 'password' => 'password']);
echo "Response Body: " . $result['body'] . "\n";
echo "Status: " . (isset($result['headers'][0]) ? $result['headers'][0] : 'Unknown') . "\n\n";

echo "All tests completed!\n";
