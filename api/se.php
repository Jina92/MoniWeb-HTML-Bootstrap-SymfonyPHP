<?php

    class sqsSession {
        // attributes will be stored in session, but always test incognito
        private int $last_visit = 0;
        private $last_visits = Array();

        // private $user_id = 0;   //  Email is a user ID 
        // private $user_name;
        // private $user_icon;
        // private $user_color;
        // private $user_privilege = 0;
        private $user_token;

        private $origin;

        public function __construct() {
            $this->origin = $_ENV['ORIGIN'];
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
            global $sqsdb;

            $res = $sqsdb->checkLogin($email, $password);
            if($res === false) {
                return false;
            } elseif(count($res) > 1) {
                $this->user_id = $res['user_id'];
                $this->user_privilege = 1;
                $this->user_token = md5(json_encode($res));
                return Array('nick'=>$res['user_nick'],
                'theme'=>$res['user_theme'],
                'color'=>$res['user_color'],
                'icon'=>$res['user_icon'],
                'Hash'=>$this->user_token);
            } elseif(count($res) == 1) {
                $this->user_id = $res['user_id'];
                $this->user_token = md5(json_encode($res));
                return Array('Hash'=>$this->user_token);
            }
        }

        public function register($firstname, $lastname, $email, $password, $phoneno, $address, $suburb, $state, $postcode) {
            global $sqsdb; // db connection 
            //if($csrf == $this->user_token) {  // Checksum using hash, consider it later 
                // You also need to think what you need to save in the localstorage considering security.  talk with John
                if($sqsdb->registerUser($firstname, $lastname, $email, $password, $phoneno, $address, $suburb, $state, $postcode)) {
                    return true;
                }
                else {
                    return 0;
                }
            //} else {
            //     return false;
            // }
        }

        public function emailExist($email) {
            global $sqsdb; // db connection 
            return ($sqsdb->emailExist($email));
        }
        public function isLoggedIn() {
            // if($this->user_id === 0) {
            //     return false;
            // } else {
            //     return Array('Hash'=>$this->user_token);
            // }
        }
        public function logout() {
            // $this->user_id = 0;
            // $this->user_privilege = 0;
        }
        public function validate($type, $dirty_string) {
        }
        public function logEvent() {
        }
    }
?>
