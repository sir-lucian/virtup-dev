<?php

define(
    'KEY',
    ''
);
function getErrorResponse($code = 400)
{
    $is_success = false;
    $message_error = null;
    switch ($code) {
        case 400:
            $message_error = "Bad Request";
            break;
        case 401:
            $message_error = "Unauthorized";
            break;
        case 404:
            $message_error = "Not Found";
            break;
        default:
            $message_error = "Server error";
    }
    return json_encode([
        "is_success" => $is_success,
        "response_code" => $code,
        "message_error" => $message_error
    ]);
}

function getSuccessResponse($data)
{
    return json_encode([
        "is_success" => true,
        "response_code" => 200,
        "data" => $data
    ]);
}

if ($_GET['handle']) {
    $handle = $_GET['handle'];
    $ch = curl_init("https://www.googleapis.com/youtube/v3/channels?key=". KEY ."&part=statistics&forHandle=" . $handle);

    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Accept: application/json',
        'Content-Type: application/json'
    ]);

    $response = curl_exec($ch);
    curl_close($ch);

    if (curl_error($ch)) {
        $response = json_encode(getErrorResponse());
    } else {
        $response = json_encode([
            "is_success" => true,
            "response_code" => 200,
            "data" => $response
        ]);
    }
} else {
    $response = getErrorResponse(400);
}

echo $response;

?>