<?php
require_once('../vendor/autoload.php');
require_once('./db.php');
require_once('./se.php');

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
 *  This should be before "new sqsModel", because sqsModel constructor use it.  
 */

$sqsdb = new sqsModel;   // user-define class for database connection

$request = Request::createFromGlobals();
$response = new Response();
$session = new Session(new NativeSessionStorage(), new AttributeBag());

$response->headers->set('Content-Type', 'application/json');
$response->headers->set('Access-Control-Allow-Headers', 'origin, content-type, accept');
$response->headers->set('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
$response->headers->set('Access-Control-Allow-Origin', $_ENV['ORIGIN']);
$response->headers->set('Access-Control-Allow-Credentials', 'true');

$session->start();

if(!$session->has('sessionObj')) {
    $session->set('sessionObj', new sqsSession);   // If a session object is not defined, create a new session object
                                                   // user-define class 
}

if(empty($request->query->all())) {   // Error if there are no GET parameters
    $response->setStatusCode(400);
} elseif($request->cookies->has('PHPSESSID')) {
    if($session->get('sessionObj')->is_rate_limited()) { // check two connections happen in the same second. 
        $response->setStatusCode(429); // 429 Too Many Requests
    }
    if($request->getMethod() == 'POST') { // register, login
        // echo "step 001";
        if($request->query->getAlpha('action') == 'register') {  // $request->query: GET method in URL 
            // echo "step ttt01";
            // echo "firstname:".$request->request->get('firstname');
            // echo "lastname:".$request->request->get('lastname');
            // echo "email:".$request->request->get('email');
            // echo "password:".$request->request->get('password'); 
            // echo "confirmpassword:".$request->request->get('confirmpassword'); 
            // echo "phoneno:".$request->request->get('phoneno'); 
            // echo "address:".$request->request->get('address'); 
            // echo "suburb:".$request->request->get('suburb');
            // echo "state:".$request->request->get('state');
            // echo "postcode:".$request->request->get('postcode');

            if ($request->request->has('email')) { // check email registered already.
                $res = $session->get('sessionObj')->emailExist($request->request->get('email'));
                if($res) {
                    $response->setStatusCode(200);  // 206 partial content. Email is registered already 
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
                                $request->request->get('email'),
                                $request->request->get('password'),
                                $request->request->get('phoneno'),
                                $request->request->get('address'),
                                $request->request->get('suburb'),
                                $request->request->get('state'), 
                                $request->request->get('postcode')
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
        // elseif($request->query->getAlpha('action') == 'login') {
        //     if($request->request->has('username') and
        //         $request->request->has('password')) {
        //         $res = $session->get('sessionObj')->login($request->request->getInt('username'),
        //             $request->request->get('password'));
        //         if ($res === false) {
        //             $response->setStatusCode(401);
        //         } elseif(count($res) == 1) {
        //             $response->setStatusCode(203);
        //             $response->setContent(json_encode($res));
        //         } elseif(count($res) > 1) {
        //             $response->setStatusCode(200);
        //             $response->setContent(json_encode($res));
        //         }
        //     } else {
        //         $response->setStatusCode(400);
        //     }
        // } 
        else {
            $response->setStatusCode(400);
        }
    }
    if($request->getMethod() == 'GET') {              // showqueu, accountexists
        if($request->query->getAlpha('action') == 'accountexists') {
            if($request->query->has('username')) {
                $res = $sqsdb->userExists($request->query->getInt('username'));
                if($res) {
                    $response->setStatusCode(400);
                } else {
                    $response->setStatusCode(204);
                }
            }
        } elseif($request->query->getAlpha('action') == 'isloggedin') {
            $res = $session->get('sessionObj')->isLoggedIn();
            if($res == false) {
                $response->setStatusCode(403);
            } elseif(count($res) == 1) {
                $response->setStatusCode(200);
                $response->setContent(json_encode($res));
            }
        } elseif($request->query->getAlpha('action') == 'logout') {
            $session->get('sessionObj')->logout();
            $response->setStatusCode(200);
        } else {
            $response->setStatusCode(400);
        }
    }
    if($request->getMethod() == 'DELETE') {           // delete queue, delete comment
        $response->setStatusCode(400);
    }
    if($request->getMethod() == 'PUT') {              // enqueue, add comment
        $response->setStatusCode(400);
    }
} else {
    $redirect = new RedirectResponse($_SERVER['REQUEST_URI']);
}

// Do logging just before sending response?

$response->send();

?>
