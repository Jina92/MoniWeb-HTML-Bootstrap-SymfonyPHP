<?php

    class mwAdminSession {
        // attributes will be stored in session, but always test incognito
        
        private $adminid = 0;
        private $email = "";   //  Email is a user ID 
        private $firstname;
        private $lastname; 
    
        private $origin;
        private $db_conn; 
        

        public function __construct() {
            $this->origin = $_ENV['ORIGIN'];
        }

        public function loginAdmin($email, $password) {
           global $mwAdminDB;
 
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

        public function registerAdmin($firstname, $lastname, $email, $password) {
            global $mwAdminDB; // db connection 
            if ((!isset($firstname)) or (!isset($lastname)) or (!isset($email)) or (!isset($password))) {
                return false;
            }
            
            $res = $mwAdminDB->registerUserAdmin($firstname, $lastname, $email, $password);
            if ($res > 0) {  // adminid is returned 
                //if registration is successful, set session variables
                $this->email = $email;
                $this->adminid = $res;
                return true;
            }
            else {
                return false;
            }
        }

        public function emailExist($email) {
            global $mwAdminDB; // db connection 

            if (!isset($email)) return false;

            return ($mwAdminDB->emailExist($email));
        }

        public function isLoggedIn() {
            if($this->adminid <= 0) {
                return false;
            } else {
                return true;
            }
        }

        public function displayAllCustomers() {
            // Display all customers of MoniWeb
            global $mwAdminDB; // db connection 

            return ($mwAdminDB->displayAllCustomers());
        }

        public function displayCustomer($customerid) {
            // Display the customer detail of given customer id 
            global $mwAdminDB; // db connection 

            return ($mwAdminDB->displayCustomer($customerid));
        }

        public function cancelCustomer($customerid) {
            // cancel the membership of given customer id 
            global $mwAdminDB; // db connection 

            return ($mwAdminDB->cancelCustomer($customerid));
        }

        public function displayLogs() {
            // display logs, recent 50 logs only  
            global $mwAdminDB; // db connection 

            return ($mwAdminDB->displayLogs());
        }
    }
?>
