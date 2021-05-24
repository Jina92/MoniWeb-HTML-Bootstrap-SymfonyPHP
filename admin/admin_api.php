<?php
require_once('../vendor/autoload.php');
require_once('./admin_db.php');
require_once('./admin_se.php');
require_once('./admin_ft.php');

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\Attribute\AttributeBag;
use Symfony\Component\HttpFoundation\Session\Storage\NativeSessionStorage;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Dotenv\Dotenv;


$dotenv = new Dotenv();   
$dotenv->load('./.env');    
/*  $dbUser = getenv('DBUSER');  ==> getenv didn't work. You can use $_ENV
 *  $dotenv->load() automatically set the env variable from .env to $_ENV 
 *  This should be before "new mwModel", because mwModel constructor use it.  
 */



/*****************************************************************
 * Instantiated the database class
 * The main job of API is connecting and manipulating data of the database.
 * mwModel is the class of Database connection and manipulation
 * The mwDB variable is instanciated of the mwModel class.
 * Most of API will use this variable as a global to connect the database from anywhere in these API. 
 * Therefore it needs to be instanciated at the first part of API. 
 ******************************************************************/
$mwAdminDB = new mwAdminModel;   // mwModel: user-define class for database connection
$request = Request::createFromGlobals();
$response = new Response();
/*****************************************************************
 * Instantiated the session class
 * All API functions need to be managed by session including database connection functions. 
 * The session object needs to be instantiated 
 ******************************************************************/
$session = new Session();

// Miyuki recommended 

// delete headers from fetch call in javascript React. 
$response->headers->set('Access-Control-Allow-Headers', 'origin, content-type, accept');
$response->headers->set('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
//$response->headers->set('Access-Control-Allow-Origin', $_ENV['ORIGIN']);
$response->headers->set('Access-Control-Allow-Origin', 'http://localhost');
$response->headers->set('Access-Control-Allow-Credentials', 'true');


$requestMethod = $request->getMethod();
$selectedAction = null;

/* Origin blocing */
/* whiltelist: localhost */ 
$originHost = $request->headers->get('ORIGIN');
$originPass = false;
if (isset($originHost)) {
    // if (strpos($request->headers->get('ORIGIN'), $_ENV['ORIGIN']) !== false) 
    if (strpos($request->headers->get('ORIGIN'), "localhost") !== false) 
    
        $originPass = true; 
} 
if ($originPass === false) {
    if (strpos($request->headers->get('referer'), "localhost") !== false) {
        $originPass = true; 
    }
}
if ($originPass === false) { 
    $response->setStatusCode(403);
    $response->send();
    return;
} 

/********************************************************
 * Session start 
 ********************************************************/
$session->start(); 
// If a session object is not set,  it creates new session object. 
// If a session object is already set, it means an session is connected 
// and you can use exiting session object 
// FYI, login status will be checked in each function of the session object 
if(!$session->has('sessionAdminObj')) {
    $session->set('sessionAdminObj', new mwAdminSession);   // If a session object is not defined, create a new session object                                               // user-define class 
}
$thisSession = $session->get('sessionAdminObj');
if(empty($request->query->all())) {   // Error if there are no GET parameters
    $response->setStatusCode(400);
} 
elseif (!($request->query->has('action'))) {  // no actions: Error
    $response->setStatusCode(400);
} 
elseif ($request->query->getAlpha('action') == 'login') { // Login, No session 
    // $request->toArray(); // for JSON format 

    if($request->request->has('email') and
        $request->request->has('password')) {
            $res = $session->get('sessionAdminObj')->loginAdmin($request->request->get('email'),
            $request->request->get('password'));
        if ($res == false) {
            $response->setStatusCode(401);
        // } elseif(count($res) == 1) {
        //     $response->setStatusCode(203);
        //     $response->setContent(json_encode($res));
        } elseif(count($res) > 0) {
            $response->setStatusCode(200);
            $response->setContent(json_encode($res));
        }
    } else {
        $response->setStatusCode(400);
    }
} 
elseif($request->cookies->has('PHPSESSID')) {

    $selectedAction = $request->query->getAlpha('action');

    if ($thisSession->isLoggedIn() !== true) {
        $response->setStatusCode(401); 
    }
    elseif($requestMethod  == 'GET') { 
        if($selectedAction == 'displayall') {
            if ($thisSession->isLoggedIn() == false) {
                $response->setStatusCode(401);
            }
            else {
                $result = $thisSession->displayAllCustomers();
                switch ($result) {
                    case false:  // Internal Error 
                        $response->setStatusCode(500);
                        break;
                    case 0: 
                        $response->setStatusCode(200);
                        $response->setContent(json_encode("No Data"));
                        break;
                    default: // data returned 
                        // $response->setStatusCode(200);
                        // $response->setContent(json_encode($res));
                        setSessionMessage($response, 200, $result);  // (response object, status code, raw message - not JSON format) 
                }
            }
        } 
        elseif($selectedAction == 'displaycustomer') {
            // Display details of the given customer id
            if ($request->query->has('customerid')) {
                $result = $thisSession->displayCustomer($request->query->get('customerid'));
                switch ($result) {
                    case false:  // Internal Error 
                        $response->setStatusCode(500);
                        break;
                    case 0: 
                        // $response->setStatusCode(200);
                        // $response->setContent(json_encode("No Data"));
                        setSessionMessage($response, 200, "No Data");
                        break;
                    default: // customer detail data returned as a JSON format
                        setSessionMessage($response, 200, $result);  // (response object, status code, raw message - not JSON format) 
                }
            }
        }
        elseif($selectedAction == 'cancel') {
            if ($request->query->has('customerid')) {
                $result = $thisSession->cancelCustomer($request->query->get('customerid'));
                if ($result) {
                    setSessionMessage($response, 200, "Cancelled");
                }
                else {
                    $response->setStatusCode(500);
                }
            }
            else {
                $response->setStatusCode(400);
            }
        }
        elseif($selectedAction == 'logs') {
            if ($thisSession->isLoggedIn() == false) {
                $response->setStatusCode(401);
            }
            else {
                $result = $thisSession->displayLogs();
                switch ($result) {
                    case false:  // Internal Error 
                        $response->setStatusCode(500);
                        break;
                    case 0: 
                        $response->setStatusCode(200);
                        $response->setContent(json_encode("No Data"));
                        break;
                    default: // data returned 
                        setSessionMessage($response, 200, $result);  // (response object, status code, raw message - not JSON format) 
                }
            }
        } 
        elseif($selectedAction == 'logout') {
            $session->clear();
            $session->invalidate();
            setSessionMessage($response, 200, "Logout Success");
        } 
        else {
            $response->setStatusCode(400);
        }
    }
    elseif($request->getMethod() == 'POST') {  
        $response->setStatusCode(500);
    }
    elseif($request->getMethod() == 'DELETE') {           
        $response->setStatusCode(400);
    }
    elseif($request->getMethod() == 'PUT') {             
        $response->setStatusCode(400);
    }
} 
else {
    $redirect = new RedirectResponse($_SERVER['REQUEST_URI']);
}

$response->send();

?>
