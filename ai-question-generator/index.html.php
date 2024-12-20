<?php
$flask_server_url = "http://127.0.0.1:5000";

// Get request method and endpoint
$request_method = $_SERVER['REQUEST_METHOD'];
$endpoint = str_replace('/index.html', '', $_SERVER['REQUEST_URI']);

// Initialize cURL
$curl = curl_init();
$flask_url = $flask_server_url . $endpoint;

// Forward headers
$headers = [];
foreach (getallheaders() as $key => $value) {
    $headers[] = "$key: $value";
}

// Configure cURL
curl_setopt($curl, CURLOPT_URL, $flask_url);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $request_method);
curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

// Forward body data
if (in_array($request_method, ['POST', 'PUT', 'PATCH'])) {
    $body_data = file_get_contents("php://input");
    curl_setopt($curl, CURLOPT_POSTFIELDS, $body_data);
}

// Execute and handle cURL response
$response = curl_exec($curl);
if (curl_errno($curl)) {
    http_response_code(500);
    echo "cURL Error: " . curl_error($curl);
    exit;
}

$http_status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
curl_close($curl);

// Return response
http_response_code($http_status);
header("Content-Type: application/json");
echo $response;
?>
