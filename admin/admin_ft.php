<?php
    function setSessionMessage($response, $statusCode, $rawMessage) { 
        $response->setStatusCode($statusCode);
        $response->setContent(json_encode($rawMessage));
    }
?>
