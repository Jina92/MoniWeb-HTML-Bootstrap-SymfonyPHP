<?php

    class sqsModel {

        private $dbconn;

        public function __construct() {
            $dbURI = 'mysql:host=' . $_ENV['DBHOST'] . ';port='.$_ENV['PORT'].';dbname=' . $_ENV['DATABASE'];
            $this->dbconn = new PDO($dbURI, $_ENV['DBUSER'], $_ENV['DBPASSWORD']);
            $this->dbconn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }

        function checkLogin($email, $password) {
            // check user_id(email), password correct
            $sql = "SELECT Email FROM customer WHERE Email = :email AND Password = :password";
            $stmt = $this->dbconn->prepare($sql);
            $stmt->bindParam(':email', $email, PDO::PARAM_INT);
            $stmt->bindParam(':password', $password, PDO::PARAM_INT);
            $stmt->execute();
            if($stmt->rowCount() > 0) {  // email is unique, rowCount is one 
                $retVal = $stmt->fetch(PDO::FETCH_ASSOC);
                if(strlen($retVal['Email']) > 0) {
                    if($retVal['Password'] == $password) { // encrypt & decrypt
                        return Array('user_id'=>$retVal['student_NO'],
                                   'user_nick'=>$retVal['nick'],
                                  'user_color'=>$retVal['color'],
                                   'user_icon'=>$retVal['icon'],
                                  'user_theme'=>$retVal['theme']);
                    } else {
                        return false;
                    }
                } else {
                    return Array('user_id'=>$retVal['student_NO']);
                }
            } else {
                return false;
            }
        }
        function emailExist($email) {
            $sql = "SELECT Email FROM customer WHERE Email = :email"; 
            $stmt = $this->dbconn->prepare($sql);
            $stmt->bindParam(':email', $email, PDO::PARAM_STR); //3rd: Explicit data type for the parameter (related to SQL data type) 
            $stmt->execute();
            if($stmt->rowCount() > 0) {
                return true;
            } else {
                return false;
            }
        }
        function registerUser($fname, $lname, $email, $pass, $phone, $add, $suburb, $state, $postcode) {
            $country = "Australia";
            
            // Retister user into system, assume validation has happened.
            $sql = "INSERT INTO customer(FirstName, LastName, Email, Password, PhoneNo, Address, Suburb, State, Postcode, Country) 
            VALUES (:fname, :lname, :email, :pass, :phone, :add, :suburb, :state, :postcode, :country)";
            $stmt = $this->dbconn->prepare($sql);
            $stmt->bindParam(':fname', $fname, PDO::PARAM_STR);
            $stmt->bindParam(':lname', $lname, PDO::PARAM_STR);
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt->bindParam(':pass', $pass, PDO::PARAM_STR);
            $stmt->bindParam(':phone', $phone, PDO::PARAM_STR);
            $stmt->bindParam(':add', $add, PDO::PARAM_STR);
            $stmt->bindParam(':suburb', $suburb, PDO::PARAM_STR);
            $stmt->bindParam(':state', $state, PDO::PARAM_STR);
            $stmt->bindParam(':postcode', $postcode, PDO::PARAM_STR);
            $stmt->bindParam(':country', $country, PDO::PARAM_STR);
            $result = $stmt->execute();
            if($result === true) {
                return true;
            } else {
                return false;
            }
        }
        // function logEvent($uid, $url, $resp_code, $source_ip) {
        //     $sql = "INSERT INTO logtable (url, uid, response_code, ip_addr) 
        //         VALUES (:url, :uid, :resp_code, :ip);";
        //     $stmt = $this->dbconn->prepare($sql);
        //     $stmt->bindParam(':uid', $uid, PDO::PARAM_INT);
        //     $stmt->bindParam(':url', $url, PDO::PARAM_STR);
        //     $stmt->bindParam(':resp_code', $resp_code, PDO::PARAM_INT);
        //     $stmt->bindParam(':ip', $source_ip, PDO::PARAM_STR);
        //     $result = $stmt->execute();
        //     if($result === true) {
        //         return true;
        //     } else {
        //         return false;
        //     }
        // }
    }
?>
