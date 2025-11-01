<?php
function fetchFromApi($endpoint, $params = []) {
    // Base URL of your API
    $baseUrl = "https://moonlit.trusttino.com/html/template/api.php";
    
    // Build full URL with query parameters
    $url = $baseUrl . "?action=" . urlencode($endpoint);
    if (!empty($params)) {
        $url .= "&" . http_build_query($params);
    }

    // Initialize cURL
    $ch = curl_init();

    // Set cURL options
    curl_setopt_array($ch, [
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_TIMEOUT => 10,
        CURLOPT_SSL_VERIFYPEER => false, // ignore SSL for local development
    ]);

    // Execute request
    $response = curl_exec($ch);

    // Handle cURL errors
    if (curl_errno($ch)) {
        $error = curl_error($ch);
        curl_close($ch);
        return [
            "status" => false,
            "message" => "cURL Error: $error"
        ];
    }

    curl_close($ch);

    // Decode and return JSON response
    $data = json_decode($response, true);

    if (is_array($data)) {
        return $data;
    }

    return [
        "status" => false,
        "message" => "Invalid API response"
    ];
}

$siteInfoResponse = fetchFromApi("get_site_info");

if ($siteInfoResponse['status'] === true) {
    $siteInfo = $siteInfoResponse['data'];
} else {
    echo $siteInfoResponse['message'];
}

?>
