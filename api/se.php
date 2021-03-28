<?php

    class mwSession {
        // attributes will be stored in session, but always test incognito
        private int $last_visit = 0;
        private $last_visits = Array();

        
        private $customerid;
        private $email = "";   //  Email is a user ID 
        private $firstname;

        private $user_token;
    
        private $origin;
        private $db_conn; 
         
        

        public function __construct() {
            // global $mwDB;
            $this->origin = $_ENV['ORIGIN'];
            // $this->db_conn = $mwDB;
        }


        public function getCustomerId() {
            return $this->customerid;
        }

        public function getEmail() {
            return $this->email;
        }

        public function is_rate_limited() { 
            if($this->last_visit == 0) {
                $this->last_visit = time(); // time() returns the current time in the number of seconds
                return false;
            }
            if($this->last_visit == time()) { // the same second means computer visits not human visits 
                return true;
            }
            return false;
        }
        public function login($email, $password) {
            global $mwDB;
            
            $res = $mwDB->checkLogin($email, $password);  // customised array returned
            if($res === false) {
                return false;
            } elseif(count($res) > 0) {
                $this->email = $res['email'];
                $this->customerid = $res['customerid'];
                //$this->user_privilege = 1;
                //$this->user_token = md5(json_encode($res));
                return Array('email'=>$res['email'],
                'firstname'=>$res['firstname'],
                'theme'=>$res['theme']);
                // 'Hash'=>$this->user_token);
            } 
            else return false; 
        }

        public function register($firstname, $lastname, $email, $password, $phoneno, $address, $suburb, $state, $postcode) {
            global $mwDB; // db connection 
            //if($csrf == $this->user_token) {  // Checksum using hash, consider it later 
                // You also need to think what you need to save in the localstorage considering security.  talk with John
                if($mwDB->registerUser($firstname, $lastname, $email, $password, $phoneno, $address, $suburb, $state, $postcode)) {
                    return true;
                }
                else {
                    return 0;
                }
            //} else {
            //     return false;
            // }
        }

        public function getProfile($email) {
            global $mwDB;
            
            $res = $mwDB->getProfile($email);  // customised array returned
            if($res === false) {
                return false;
            } elseif(count($res) > 0) {
               return $res;
            } 
            else return false; // no case 
        }


        public function emailExist($email) {
            global $mwDB; // db connection 
            return ($mwDB->emailExist($email));
        }

        public function updateProfile($orgEmail, $firstname, $lastname, $newEmail, $phoneno, $address, $suburb, $state, $postcode) {
            global $mwDB; 
            return ($mwDB->updateProfile($orgEmail, $firstname, $lastname, $newEmail, $phoneno, $address, $suburb, $state, $postcode));
        }

        public function editURL($array_url) {
            global $mwDB;
            $res = $mwDB->editURL($this->customerid, $array_url);  // customised array returned
            return $res;
        }

        public function getPlan() {
            global $mwDB;
            $res = $mwDB->getPlan($this->customerid);  // customised array returned
            return $res;
        }

        public function upgradePlan($newPlanType) {
            global $mwDB;
            $res = $mwDB->upgradePLan($this->customerid, $newPlanType);  // customised array returned
            return $res;
        }

        // public function isLoggedIn() {
            // if($this->user_id === 0) {
            //     return false;
            // } else {
            //     return Array('Hash'=>$this->user_token);
            // }
        // }
        // public function logout() {
        //     $session->invalidate();
            // $this->user_id = 0;
            // $this->user_privilege = 0;
        // }
        public function validate($type, $dirty_string) {
        }
        public function logEvent() {
        }
    }
?>
