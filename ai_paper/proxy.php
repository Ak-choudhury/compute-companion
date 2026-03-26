<?php
$flask_server_url = "http://python:5000/ai_paper/quiz"; // Flask server URL (localhost:5000)
$request_method = $_SERVER['REQUEST_METHOD'];
$endpoint = $_SERVER['REQUEST_URI'];

$curl = curl_init();
$flask_url = $flask_server_url . $endpoint;

$headers = [];
foreach (getallheaders() as $key => $value) {
    $headers[] = "$key: $value";
}

curl_setopt($curl, CURLOPT_URL, $flask_url);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $request_method);
curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

if (in_array($request_method, ['POST', 'PUT', 'PATCH'])) {
    $body_data = file_get_contents("php://input");
    curl_setopt($curl, CURLOPT_POSTFIELDS, $body_data);
}

$response = curl_exec($curl);
if (curl_errno($curl)) {
    http_response_code(500);
    echo "cURL Error: " . curl_error($curl);
    exit;
}

$http_status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
curl_close($curl);

http_response_code($http_status);
header("Content-Type: application/json");
echo $response;
?>
