<?php
/* 
 * This Check Server php will be registered Task Scheduler in Windows 10 for Cron job. 
 * This is for Free Plan, and it checks once in 60 minutes 
 * 
 * For standard and premium plans, 
 * copys of checkserver.php with 'Standard' and 'Premium' will be registered into the scheduler
 */ 
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Symfony\Component\Dotenv\Dotenv;

require_once('../vendor/autoload.php');
require_once('./db_svr.php');
require_once('./ft.php');

$dotenv = new Dotenv(); 
$dotenv->load(__DIR__.'/.env');  

$mwDB = new mwModelServer;   // user-defined class for database connection


// For test, change the value from Free to Premium 
$url_list = $mwDB->getURL('Premium');   // true or false 

$timeout = 5;
foreach ($url_list as $row) {  // row: pair of <urlid, url> 
    $url = $row[1];
    echo "###Foreach url: ".$url;
    // Check a website
    if (isset($url)) {
        $c_handle = curl_init();  //Initializes a new session and return a cURL handle for use with the curl_setopt(), curl_exec(), and curl_close() functions
        curl_setopt($c_handle, CURLOPT_URL, $url ); // Set value to the URL to fetch
        curl_setopt($c_handle, CURLOPT_RETURNTRANSFER, true ); // return the result on success, including http response code
        curl_setopt($c_handle, CURLOPT_TIMEOUT, $timeout ); //The maximum number of seconds to allow cURL functions to execute.
        $http_respond = curl_exec($c_handle);
        //$http_respond = trim(strip_tags($http_respond ));
        $http_code = curl_getinfo($c_handle, CURLINFO_RESPONSE_CODE); //new alias for CURLINFO_HTTP_CODE
        
        if (!$http_code) { // Error 
            $urlid = $row[0];
            $result = $mwDB->getEmail($urlid); 
            sendEmail($result['email'], $result['name'], $url);  // send a notification 
            // log only Error 
            $mwDB->logStatus($urlid, curl_errno($c_handle), curl_error($c_handle));
        } 
        curl_close($c_handle);
    }
}

function sendEmail($email, $name, $url) {
    $mail = new PHPMailer(true); // for SMTP email server 

    $mail->IsSMTP();
    $mail->Host = "smtp.gmail.com";
    $mail->Port=587;

    $mail->SMTPAuth = true;
    $mail->SMTPSecure = "tls";

    $mail->Username = $_ENV['SMTP_USERNAME'];
    $mail->Password = $_ENV['SMTP_PASSWORD'];

    $mail->From = "admin@moniweb.com.au";
    $mail->FromName = "MoniWeb";

    $mail->addAddress($email, $name);

    $mail->addReplyTo("admin@moniweb.com.au", "Reply");

    $mail->isHTML(true);


    $mail->Subject = "MoniWeb Monitoring Notification";

    $mail->Body = "<p> Dear ".$name. "<br> <br><br>\n\n    Your website, ".$url." is abnormal.<br><br>\n    Please check the status. <br> </p>";
    echo ($mail->Body);
    $mail->AltBody = "Your website is abnormal. Please check it";

    try {
        echo "email: ".$email;
        echo "name: ".$name;
        echo "url: ".$url; 
       // $mail->send();
        echo "Message has been sent successfully";
    } catch (Exception $e) {
        echo "Mailer Error: " . $mail->ErrorInfo;
    }
    
    // for logging internal moniweb server error, you need to generate to a table or log file.
}

?>