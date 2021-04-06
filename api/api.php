<?php
require_once('../vendor/autoload.php');
require_once('./db.php');
require_once('./se.php');
require_once('./ft.php');

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\Attribute\AttributeBag;
use Symfony\Component\HttpFoundation\Session\Storage\NativeSessionStorage;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Dotenv\Dotenv;

$dotenv = new Dotenv();   
$dotenv->load(__DIR__.'/.env');    
/*  $dbUser = getenv('DBUSER');  ==> getenv didn't work. You can use $_ENV
 *  $dotenv->load() automatically set the env variable from .env to $_ENV 
 *  This should be before "new mwModel", because mwModel constructor use it.  
 */

$mwDB = new mwModel;   // user-define class for database connection

$request = Request::createFromGlobals();
$response = new Response();
$session = new Session();



$response->headers->set('Content-Type', 'application/json');
$response->headers->set('Access-Control-Allow-Headers', 'origin, content-type, accept');
$response->headers->set('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
$response->headers->set('Access-Control-Allow-Origin', $_ENV['ORIGIN']);
$response->headers->set('Access-Control-Allow-Credentials', 'true');



$requestMethod = $request->getMethod();
$selectedAction = null;



// Session start 
$session->start(); 
// If a session object is not set,  it creates new session object. 
// If a session object is already set, it means an session is connected 
// and you can use exiting session object 
// FYI, login status will be checked in each function of the session object 
if(!$session->has('sessionObj')) {
    $session->set('sessionObj', new mwSession);   // If a session object is not defined, create a new session object                                               // user-define class 
}

$thisSession = $session->get('sessionObj');
if(empty($request->query->all())) {   // Error if there are no GET parameters
    $response->setStatusCode(400);
    
} 
elseif (($request->query->has('action')) and ($request->query->getAlpha('action') == 'check')) {  // Check an URL
    // Check a single URL, login is not necessary 
    // This is not logged 
    if($request->query->has('url')) { 
        
        $res = checkURL($request->query->get('url'));
        $response->setStatusCode(200);
        switch($res) {
            case 200: 
            case 302: 
                $response->setContent(json_encode("The site works well."));
                break;
            case 0:  
                $response->setContent(json_encode("The site does not work."));
                break;
            default: 
                $response->setContent(json_encode("Check Error"));
                break;
        }
    } 
    else {
        $response->setStatusCode(400);
        $response->setContent(json_encode("Check your input"));
    }
    $response->send();
    return;
}
elseif (($request->query->has('action')) and ($request->query->getAlpha('action') == 'login')) { // Login
    if($request->request->has('loginEmailAddress') and
        $request->request->has('loginPassword')) {
            $res = $session->get('sessionObj')->login($request->request->get('loginEmailAddress'),
            $request->request->get('loginPassword'));
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
    $thisSession->logEvent($request->getClientIp(), $session->getId(), $request->query->getAlpha('action'), $response->getStatusCode());
    $response->send();
    return;
} 
elseif($request->cookies->has('PHPSESSID')) {
    // $thisSession = $session->get('sessionObj');
    
     
    // check too frequent visits to detect cyber attack
    if($thisSession->isRateLimited()) { // check two conditions and limit the access. 
        $response->setStatusCode(429); // 429 Too Many Requests
    }

    $selectedAction = $request->query->getAlpha('action');
        
    if($requestMethod == 'POST') { // register, login
        // Register User 
        if($selectedAction == 'register') {  
            if ($request->request->has('email')) { // check the email registered already.
                //$res = $session->get('sessionObj')->emailExist($request->request->get('email'));
                $res = $session->get('sessionObj')->emailExist($request->request->filter('email', null, FILTER_VALIDATE_EMAIL));
                     // filter(): the 2nd para is null --> if the $_POST is null, return this 2nd para value 
                if($res) {
                    $response->setStatusCode(206);  // 206 partial content. Email is registered already 
                    $response->setContent(json_encode("Email exists"));
                } 
                else {  // no registered emails, new profile will be registered 
                    if ($request->request->has('firstname') and
                        $request->request->has('lastname') and
                        $request->request->has('password') and 
                        $request->request->has('confirmpassword') and 
                        $request->request->has('phoneno') and 
                        $request->request->has('address') and 
                        $request->request->has('suburb') and
                        $request->request->has('state') and
                        $request->request->has('postcode')) {
                        
                        if (($request->request->get('password')) == ($request->request->get('confirmpassword'))) {
                           
                            $res = $session->get('sessionObj')->register(
                                $request->request->getAlpha('firstname'), // getAlpha(): Returns the alphabetic characters of the parameter value
                                $request->request->getAlpha('lastname'),
                                //$request->request->get('email'),
                                $request->request->filter('email', null, FILTER_VALIDATE_EMAIL),
                                $request->request->get('password'),
                                $request->request->get('phoneno'),
                                $request->request->getAlnum('address'),
                                $request->request->getAlpha('suburb'),
                                $request->request->getAlpha('state'), 
                                $request->request->getDigits('postcode')
                            );
                            
                            if ($res === true) {
                                $response->setStatusCode(201);  // 201 Created 
                            } elseif ($res === false) {
                                $response->setStatusCode(403); // 403 Forbidden
                            } elseif ($res === 0) {  
                                $response->setStatusCode(500);  // 500 Internal Server Error
                            }
                        } else {
                            $response->setStatusCode(500); 
                        }
                    } else {
                        $response->setStatusCode(400); // 400 Bad request
                    }
                }
            }
        } 
        // Login 
        // elseif($selectedAction == 'login') {
        //     if($request->request->has('loginEmailAddress') and
        //         $request->request->has('loginPassword')) {
        //         $res = $session->get('sessionObj')->login($request->request->get('loginEmailAddress'),
        //             $request->request->get('loginPassword'));
        //         if ($res == false) {
        //             $response->setStatusCode(401);
        //         // } elseif(count($res) == 1) {
        //         //     $response->setStatusCode(203);
        //         //     $response->setContent(json_encode($res));
        //         } elseif(count($res) > 0) {
        //             $response->setStatusCode(200);
        //             $response->setContent(json_encode($res));
        //         }
        //     } else {
        //         $response->setStatusCode(400);
        //     }
        // } 
        // Get user profile 
        elseif($selectedAction == 'getProfile') {
            if ($thisSession->isLoggedIn() == false) {
                $response->setStatusCode(401);  
            }
            elseif($thisSession->getEmail()) {
                $res = $thisSession->getProfile($thisSession->getEmail());
                if ($res == false) {
                    $response->setStatusCode(404);  // NOT FOUND
                } elseif(count($res) > 0) {
                    $response->setStatusCode(200);
                    $response->setContent(json_encode($res));
                }
            } else {
                $response->setStatusCode(400);  // BAD Request
            }
        } 
        // update user profile 
        elseif($selectedAction == 'updateProfile') {
            if ($thisSession->isLoggedIn() == false) {
                $response->setStatusCode(401);  
            }
            elseif( $request->request->has('editEmail') and 
                ($thisSession->getEmail() !== $request->request->get('editEmail')) and 
                $thisSession->emailExist($request->request->filter('editEmail', null, FILTER_VALIDATE_EMAIL))) { 
                    $response->setStatusCode(206);  // 206 partial content. New email is registered already 
                    $response->setContent(json_encode("Email exists"));
            } 
            else {  // update profile except password. changing password is separated
                if ($request->request->has('editFirstName') and
                    $request->request->has('editLastName') and
                    $request->request->has('editEmail') and
                    $request->request->has('editPhoneNo') and 
                    $request->request->has('editAddress') and 
                    $request->request->has('editSuburb') and
                    $request->request->has('editState') and
                    $request->request->has('editPostcode')) {
                    $res = $thisSession->updateProfile(
                        $thisSession->getEmail(),  // old email, which saved in a session variable
                        $request->request->getAlpha('editFirstName'), 
                        $request->request->getAlpha('editLastName'),
                        $request->request->filter('editEmail', null, FILTER_VALIDATE_EMAIL), // new email, which is from form 
                        $request->request->get('editPhoneNo'),
                        $request->request->getAlnum('editAddress'),
                        $request->request->getAlpha('editSuburb'),
                        $request->request->getAlpha('editState'), 
                        $request->request->getDigits('editPostcode')); 
                    if ($res === true) {
                        $response->setStatusCode(200); 
                    } 
                    elseif ($res === false) {
                        $response->setStatusCode(403); // 403 Forbidden
                    } 
                    elseif ($res === 0) {  
                        $response->setStatusCode(500);  // 500 Internal Server Error
                    }
                } else {
                    $response->setStatusCode(400);  // BAD Request
                }
            }
        } else {
            $response->setStatusCode(400);
        }
    } 
    if($requestMethod  == 'GET') { // check URL
        if($selectedAction == 'myplan') {
            if ($thisSession->isLoggedIn() == false) {
                $response->setStatusCode(401);
            }
            else {
                $res = $thisSession->getPlan();
                if ($res) {
                    $response->setStatusCode(200);
                    $response->setContent(json_encode($res));
                } 
                else {
                    $response->setStatusCode(500);
                }
            }
        } 
        elseif($selectedAction == 'editURL') {
            if ($thisSession->isLoggedIn() == false) {
                $response->setStatusCode(401);  
            }
            elseif ($request->query->has('url') ) {
                $array_url = explode("_", $request->query->get('url'));
                $res = $thisSession->editURL($array_url); 
                if ($res) $response->setStatusCode(200);
                else $response->setStatusCode(400);
            } 
            else {
                $response->setStatusCode(400);
            }
        }
        elseif($selectedAction == 'upgrade') {
            if ($thisSession->isLoggedIn() == false) {
                $response->setStatusCode(401);  
            }
            elseif ($request->query->has('level') ) {
                $res = $thisSession->upgradePlan($request->query->get('level')); 
                if ($res) $response->setStatusCode(200);
                else $response->setStatusCode(400);
            }  
        }
        elseif($selectedAction == 'logout') {
            $session->clear();
            $session->invalidate();
            $response->setStatusCode(200);
        } 
        else {
            $response->setStatusCode(400);
        }
    }
    if($request->getMethod() == 'DELETE') {           
        $response->setStatusCode(400);
    }
    if($request->getMethod() == 'PUT') {             
        $response->setStatusCode(400);
    }

    $thisSession->logEvent($request->getClientIp(), $request->cookies->get('PHPSESSID'), $selectedAction, $response->getStatusCode());
} 
else {
    $redirect = new RedirectResponse($_SERVER['REQUEST_URI']);
}

$response->send();

?>
