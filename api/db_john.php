<?php

    class sqsModel {

        private $dbconn;

        public function __construct() {
            $dbURI = 'mysql:host=' . $_ENV['DBHOST'] . ';port='.$_ENV['PORT'].';dbname=' . $_ENV['DATABASE'];
            $this->dbconn = new PDO($dbURI, $_ENV['DBUSER'], $_ENV['DBPASSWORD']);
            $this->dbconn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }

        function checkLogin($username, $password) {
            // Return uid if user/password tendered are correct otherwise 0
            $sql = "SELECT * FROM student WHERE student_NO = :stno";
            $stmt = $this->dbconn->prepare($sql);
            $stmt->bindParam(':stno', $username, PDO::PARAM_INT);
            $stmt->execute();
            // echo ("\ninput pass:".$p);
            // echo ("row count : ".$stmt->rowCount());
            if($stmt->rowCount() > 0) {
                $retVal = $stmt->fetch(PDO::FETCH_ASSOC);
                // echo ("\ndb pass: ".$retVal['pass']);
                if(strlen($retVal['pass']) > 0) {
                    if($retVal['pass'] == $password) { // encrypt & decrypt
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
        function userExists($u) {
            $sql = "SELECT * FROM student WHERE student_NO = :stno";
            $stmt = $this->dbconn->prepare($sql);
            $stmt->bindParam(':stno', $u, PDO::PARAM_INT);
            $stmt->execute();
            if($stmt->rowCount() > 0) {
                return true;
            } else {
                return false;
            }
        }
        function registerUser($uid, $nick, $color, $icon, $pass) {
            // Retister user into system, assume validation has happened.
            // return UID created or false if fail
            $sql = "UPDATE student SET nick = :nick, pass = :pass, color = :color, icon = :icon, privilege = 1 WHERE student_NO = :uid";
            $stmt = $this->dbconn->prepare($sql);
            $stmt->bindParam(':uid', $uid, PDO::PARAM_INT);
            $stmt->bindParam(':nick', $nick, PDO::PARAM_STR);
            $stmt->bindParam(':color', $color, PDO::PARAM_STR);
            $stmt->bindParam(':icon', $icon, PDO::PARAM_STR);
            $stmt->bindParam(':pass', $pass, PDO::PARAM_STR);
            $result = $stmt->execute();
            if($result === true) {
                return true;
            } else {
                return false;
            }
        }
        function logEvent($uid, $url, $resp_code, $source_ip) {
            $sql = "INSERT INTO logtable (url, uid, response_code, ip_addr) 
                VALUES (:url, :uid, :resp_code, :ip);";
            $stmt = $this->dbconn->prepare($sql);
            $stmt->bindParam(':uid', $uid, PDO::PARAM_INT);
            $stmt->bindParam(':url', $url, PDO::PARAM_STR);
            $stmt->bindParam(':resp_code', $resp_code, PDO::PARAM_INT);
            $stmt->bindParam(':ip', $source_ip, PDO::PARAM_STR);
            $result = $stmt->execute();
            if($result === true) {
                return true;
            } else {
                return false;
            }
        }
    }
?>
