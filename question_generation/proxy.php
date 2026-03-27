<?php
$request_method = $_SERVER['REQUEST_METHOD'];
$request_uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

$flask_base_url = "http://python:5000";
$flask_path = "";

if (str_ends_with($request_uri, "/proxy.php")) {
    $flask_path = "/question_generation/quiz";
} elseif (str_ends_with($request_uri, "/result")) {
    $flask_path = "/question_generation/result";
} else {
    $flask_path = "/question_generation/quiz";
}

$flask_url = $flask_base_url . $flask_path;

$curl = curl_init();

$headers = [];
foreach (getallheaders() as $key => $value) {
    $lower_key = strtolower($key);
    if ($lower_key !== 'host' && $lower_key !== 'content-length') {
        $headers[] = "$key: $value";
    }
}

curl_setopt($curl, CURLOPT_URL, $flask_url);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $request_method);
curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);

if (in_array($request_method, ['POST', 'PUT', 'PATCH'])) {
    $body_data = file_get_contents("php://input");
    curl_setopt($curl, CURLOPT_POSTFIELDS, $body_data);
}

$response = curl_exec($curl);

if ($response === false) {
    http_response_code(500);
    echo "cURL Error: " . curl_error($curl);
    curl_close($curl);
    exit;
}

$http_status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
$content_type = curl_getinfo($curl, CURLINFO_CONTENT_TYPE);

curl_close($curl);

http_response_code($http_status);

if (!headers_sent()) {
    if ($content_type) {
        header("Content-Type: " . $content_type);
    } else {
        header("Content-Type: text/html; charset=UTF-8");
    }
}

echo $response;
?>