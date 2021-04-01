<?php

    class mwSession {
        // attributes will be stored in session, but always test incognito

        private int $last_visit = 0;
        private int $first_visit = 0;
        private int $visit_count = 0;
        private int $second_24hour = 86400; // 60 * 60 * 24
        
        private $customerid = 0;
        private $email = "";   //  Email is a user ID 
        private $firstname;
        private $plantype; 
        
        
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

        /* 
         limited: the last and this visits occur at the same second 
                  (the last visit time equals current time )
         limited: the visit count during 24 hours is over 1000 
                  ( visit_count > 1000  and time_period < 86400 ) 
                  86400 seconds =  60 seconds * 60 minutes * 24 hours  
         permited: other cases. 
         */ 
        public function isRateLimited() {
        
            $this->visit_count++;
            $current_time = time();

            if($this->last_visit == $current_time) {
                return true;  // two visits occur at the same second, limit the second
                              // This is not done by human 
            }
            if(($this->visit_count >= 1000) and 
               (($current_time - $this->first_visit) <= $this->second_24hour)) {
                return true;  // more than 1000 visits occur in 24 hours, limit 1001-th visit and the following visits
            }
            // Permit the visit 
            if ($this->first_visit == 0) { // This is the first visit 
                $this->first_visit = $current_time;
            }
            $this->last_visit = $current_time;
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
                $this->plantype = $res['plantype'];
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

        public function isLoggedIn() {
            if($this->customerid == 0) {
                return false;
            } else {
                return true;
            }
        }
        
        public function validate($type, $dirty_string) {
        }

        /* 
         log HTTP actions during a session 
         not log HTTP actions out of session. 
         */ 
        public function logEvent($clientip, $sid, $action, $responsecode) {
            global $mwDB;
            $res = $mwDB->logEvent($clientip, $sid, $this->email, $this->plantype, $action, $responsecode);  
            return $res;
        }
    }
?>
