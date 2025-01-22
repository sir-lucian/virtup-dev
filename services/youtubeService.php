<?php
    function getErrorResponse($code = 400) {
        $is_success = false;
        $message_error = null;
        switch ($code) {
            case 400:
                $message_error = "Bad Request"; break;
            case 401:
                $message_error = "Unauthorized"; break;
            case 404:
                $message_error = "Not Found"; break;
            default:
                $message_error = "Server error";
        }
        return json_encode([
            "is_success" => $is_success,
            "response_code" => $code,
            "message_error" => $message_error
        ]);
    }

    function getSuccessResponse($data) {
        return json_encode([
            "is_success" => true,
            "response_code" => 200,
            "data" => $data
        ]);
    }

    $response = getErrorResponse(400);

    /* Code Here */

    echo $response;

?>