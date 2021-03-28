<?php
/* 
 * This Check Server php will be registered Task Scheduler in Windows 10 for Cron job. 
 * This is for Free Plan, and it checks once in 60 minutes 
 * 
 * For standard and premium plans, 
 * copys of checkserver.php with 'Standard' and 'Premium' will be registered into the scheduler
 */ 
require_once('../vendor/autoload.php');
require_once('./db_svr.php');
require_once('./ft.php');

// namespace App\Controller;

// use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
// use Symfony\Component\Mailer\MailerInterface;
// use Symfony\Component\Mime\Email;


// use Symfony\Component\Dotenv\Dotenv;

// $dotenv = new Dotenv(); 
// $dotenv->load(__DIR__.'/.env');  

// $mwDB = new mwModelServer;   // user-defined class for database connection

// // For test, change the value from Free to Premium 
// $url_list = $mwDB->getURL('Premium');   // true or false 

// $timeout = 5;
// foreach ($url_list as $row) {  // row: pair of <urlid, url> 
//     $url = $row[1];

//     // Check a website
//     if (isset($url)) {
//         $c_handle = curl_init();  //Initializes a new session and return a cURL handle for use with the curl_setopt(), curl_exec(), and curl_close() functions
//         curl_setopt($c_handle, CURLOPT_URL, $url ); // Set value to the URL to fetch
//         curl_setopt($c_handle, CURLOPT_RETURNTRANSFER, true ); // return the result on success, including http response code
//         curl_setopt($c_handle, CURLOPT_TIMEOUT, $timeout ); //The maximum number of seconds to allow cURL functions to execute.
//         $http_respond = curl_exec($c_handle);
//         //$http_respond = trim(strip_tags($http_respond ));
//         $http_code = curl_getinfo($c_handle, CURLINFO_RESPONSE_CODE); //new alias for CURLINFO_HTTP_CODE
        
//         if (!$http_code) { // Error 
//             $urlid = $row[0];
//             $result = $mwDB->getEmail($urlid); 
            sendEmail('jabaek92@naver.com', 'Helen Keller', 'machbase.com');  // send a notification 
            // log only Error 
    //         $mwDB->logStatus($urlid, curl_errno($c_handle), curl_error($c_handle));
    //     } 
    //     curl_close($c_handle);
    // }
// }

function sendEmail($email, $name, $url) {
    $subject = "MoniWeb Error Notification";
    $msg = "Dear ".$name."\n\n    Your website, ".$url." is abnormal.\n    Please check the status. ";
    mail($email,$subject,$msg);
    // for logging internal moniweb server error, you need to generate to a table or log file.
}

?>