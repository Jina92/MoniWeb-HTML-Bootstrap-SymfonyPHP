<?php

/* This function is for guest member, Sesssion is not necessary */

function checkURL($url) {
    // check the website with the given URL 
    // success: return HTTP Response code of the website
    // fail: return 0 

    $timeout = 5;
    $cHandle = curl_init();  //Initializes a new session and return a cURL handle for use with the curl_setopt(), curl_exec(), and curl_close() functions
    
    if (strpos($url, "https") !== false)  {
        curl_setopt($cHandle, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($cHandle, CURLOPT_SSL_VERIFYHOST,  2);
    }
    curl_setopt($cHandle, CURLOPT_URL, $url ); // Set value to the URL to fetch
    curl_setopt($cHandle, CURLOPT_RETURNTRANSFER, true ); // I think: return as a string 
    // Set value to true to return the transfer as a string of the return value of curl_exec() instead of outputting it directly.
    curl_setopt($cHandle, CURLOPT_HEADER, true); //  Set value to true to include the header in the output.
    curl_setopt($cHandle,CURLOPT_NOBODY,true);  // Set value to true to exclude the body from the output. Request method is then set to HEAD. Changing this to false does not change it to GET.
    curl_setopt($cHandle, CURLOPT_TIMEOUT, $timeout ); //The maximum number of seconds to allow cURL functions to execute.
    $http_respond = curl_exec($cHandle);
    $http_respond = trim(strip_tags($http_respond ));
    $http_code = curl_getinfo($cHandle, CURLINFO_RESPONSE_CODE); //new alias for CURLINFO_HTTP_CODE
    
    // you need these send back to web browser  for detail messages
    // if(curl_errno($cHandle)) {
    //     echo 'Curl errorNO: ' . curl_errno($cHandle);
    //     echo 'Curl error: ' . curl_error($cHandle);
    // }
    curl_close($cHandle);
    return($http_code) ;   // Error: return 0
}

function logTestAction($message) {
    $fname = "test.log";
    if (file_exists($fname)) { 
        $fp = fopen($fname, "a");
    }
    else {
        $fp = fopen($fname, "w");
    }
    fwrite($fp, $message."\n");
    fclose($fp);
}
?>