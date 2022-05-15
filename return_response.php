<?php
    function returnResponse($info = null, $filelink = null, $status = "error", $code = 200) {
    http_response_code($code);
    die (json_encode( array(
        "status" => $status,
        "info" => $info,
        "file_link" => $filelink
    )));
    }
?>