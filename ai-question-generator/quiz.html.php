<?php
// Flask server URL
$flask_server_url = "http://127.0.0.1:5000/quiz"; // Change this to your Flask server URL

// Get the request method (GET, POST, PUT, DELETE, etc.)
$request_method = $_SERVER['REQUEST_METHOD'];

// Get the endpoint from the client's request
$endpoint = $_SERVER['REQUEST_URI'];

// Initialize cURL
$curl = curl_init();

// Build the full URL for the Flask server
$flask_url = $flask_server_url . $endpoint;

// Forward headers from the client
$headers = [];
foreach (getallheaders() as $key => $value) {
    $headers[] = "$key: $value";
}

// Configure cURL options
curl_setopt($curl, CURLOPT_URL, $flask_url);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $request_method);
curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

// Forward body data if the request is POST, PUT, or PATCH
if (in_array($request_method, ['POST', 'PUT', 'PATCH'])) {
    $body_data = file_get_contents("php://input");
    curl_setopt($curl, CURLOPT_POSTFIELDS, $body_data);
}

// Execute the cURL request to the Flask server
$response = curl_exec($curl);

// Check for cURL errors
if (curl_errno($curl)) {
    http_response_code(500); // Internal Server Error
    echo "cURL Error: " . curl_error($curl);
    exit;
}

// Get the HTTP status code from the Flask server response
$http_status = curl_getinfo($curl, CURLINFO_HTTP_CODE);

// Close the cURL session
curl_close($curl);

// Set the response status code and headers
http_response_code($http_status);
header("Content-Type: application/json");

// Return the Flask server's response to the client
echo $response;
?>
