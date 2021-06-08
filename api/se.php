<?php

    class mwSession {
        // attributes will be stored in session, but always test incognito

        private int $last_visit = 0;
        private int $first_visit = 0;
        private int $last_visitSecond = 0;
        private int $last_visitMicro = 0;
        private int $first_visitSecond = 0;
        private int $first_visitMicro = 0;      
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
        // public function isRateLimited() { // Proj 2 
        
        //     $this->visit_count++;
        //     $current_time = time();

        //     if($this->last_visit == $current_time) {  // two visits occur at the same second, limit the second 
        //                                                  // This is not done by human
        //         return true;  
        //     }
            
        //     if(($this->visit_count >= 1000) and 
        //        (($current_time - $this->first_visit) <= $this->second_24hour)) {
        //         return true;  // more than 500 visits occur in 24 hours, limit 1001-th visit and the following visits
        //     }
        //     // Permit the visit 
        //     if ($this->first_visit == 0) { // This is the first visit 
        //         $this->first_visit = $current_time;
        //     }
        //     $this->last_visit = $current_time;
        //     return false;
        // }

        // microtime() return current Unix timestamp as a string 
        // The string consists of two parts. 
        // The first part has a "0.xxxxx" format and represent micro second of the current moment. 
        // The second part has a integer format  and represent second of the current moment. 
        // The second part is same as the result of time() 
        public function isRateLimited() { // Proj 4 
        
            $this->visit_count++;
            $current_time = microtime();  // [microsecond + seccond] of currunt Unix time 

            $tempArray = explode(" ", $current_time);
            $curr_timeSecond = $tempArray[1]; 
            $curr_timeMicro = $tempArray[0]; 

            // If the gap between two visits is less than 0.5 second, limit the second access. Too many Request.
            // Caculate the gap 
            $gapTime = ($curr_timeSecond - $this->last_visitSecond) + ($curr_timeMicro - $this->last_visitMicro);
            if ($gapTime < 0.5) return true;  
            
            if(($this->visit_count >= 500) and   //  If someone visits more than 500 times in 24 hours, limit the access
               (($curr_timeSecond - $this->first_visitSecond) <= $this->second_24hour)) {
                return true;  // more than 500 visits occur in 24 hours, limit 501-th visit and the following visits
            }
            // Permit the visit 
            if ($this->first_visitSecond == 0) { // This is the first visit 
                $this->first_visitSecond = $curr_timeSecond;
                $this->first_visitMicro = $curr_timeMicro;
            }
            $this->last_visitSecond = $curr_timeSecond;
            $this->last_visitMicro = $curr_timeMicro;
            return false;
        }

        public function login($email, $password) {
            global $mwDB;

            if ((!isset($email)) or (!isset($password))) {
                return false;
            }
            
            $res = $mwDB->checkLogin($email, $password);  // customised array returned
            if($res === false) {
                return false;
            } elseif(count($res) > 0) {
                $this->email = $res['email'];
                $this->customerid = $res['customerid'];
                $this->plantype = $res['plantype'];
                return Array('email'=>$res['email'],
                'firstname'=>$res['firstname'],
                'theme'=>$res['theme']);
            } 
            else return false; 
        }

        public function register($firstname, $lastname, $email, $password, $phoneno, $address, $suburb, $state, $postcode) {
            global $mwDB; // db connection 
            if ((!isset($firstname)) or (!isset($lastname)) or (!isset($email)) or 
                (!isset($password)) or (!isset($phoneno)) or (!isset($address)) or 
                (!isset($suburb)) or (!isset($state)) or (!isset($postcode)) ) {
                return false;
            }
            
            if ($this->customerid > 0) return 0; // Logout is necessary to register  // 500 internal error 
                // You also need to think what you need to save in the localstorage considering security.  talk with John
            $res = $mwDB->registerUser($firstname, $lastname, $email, $password, $phoneno, $address, $suburb, $state, $postcode);
            if ($res > 0) {
                //if registration is successful, set session variables
                $this->email = $email;
                $this->customerid = $res;
                $this->plantype = "Free";
                return true;
            }
            else {
                return false;
            }
        }

        public function getProfile($email) {
            global $mwDB;

            if (!isset($email)) return false;

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

            if (!isset($email)) return false;

            return ($mwDB->emailExist($email));
        }

        public function updateProfile($orgEmail, $firstname, $lastname, $newEmail, $phoneno, $address, $suburb, $state, $postcode) {
            global $mwDB; 

            if ((!isset($orgEmail)) or (!isset($firstname)) or (!isset($lastname)) or 
                (!isset($newEmail)) or (!isset($phoneno)) or (!isset($address)) or 
                (!isset($suburb)) or (!isset($state)) or (!isset($postcode)) ) {
                return false;
            }
            return ($mwDB->updateProfile($orgEmail, $firstname, $lastname, $newEmail, $phoneno, $address, $suburb, $state, $postcode));
        }

        public function changePassword($currentPassword, $newPassword, $confirmPassword) {
            global $mwDB; 

            if ((!isset($currentPassword)) or (!isset($newPassword)) or (!isset($confirmPassword))) {
                return false;
            }
            if ($newPassword != $confirmPassword) 
                return false;
            return ($mwDB->changePassword($currentPassword, $newPassword));
        }

        public function updateURL($array_url) {
            global $mwDB;
            
            if (!isset($array_url)) return false;

            $res = $mwDB->updateURL($this->customerid, $array_url);  // customised array returned
            return $res;
        }

        public function getPlan() {
            global $mwDB;

            if ($this->customerid == 0) return false;
            $res = $mwDB->getPlan($this->customerid);  // customised array returned
            return $res;
        }

        /*  Upgrade a customer's price plan */
        public function upgradePlan($newPlanType) {
            global $mwDB;

            if (!isset($newPlanType)) return false;
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

        public function getReport() {
            global $mwDB;

            $res = $mwDB->getReport($this->customerid);  // customised array returned
            return $res;
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

        public function loginAdmin($email, $password) {
            global $mwDB;
  
             if ((!isset($email)) or (!isset($password))) {
                 return false;
             }
             
             $res = $mwAdminDB->checkLoginAdmin($email, $password);  // customised array returned
             if($res === false) {
                 return false;
             } elseif(count($res) > 0) {
                 $this->email = $res['email'];
                 $this->adminid = $res['adminid'];
                 return Array('email'=>$res['email'],
                 'firstname'=>$res['firstname'],
                 'lastname'=>$res['lastname']); 
             } 
             else return false; 
         }
    }
?>
