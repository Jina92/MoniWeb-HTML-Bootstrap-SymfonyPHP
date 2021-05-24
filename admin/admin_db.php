<?php

    class mwAdminModel {

        private $dbconn;

        public function __construct() {
            /* establish a connection to the mySQL database */ 
            $dbURI = 'mysql:host=' . $_ENV['DBHOST'] . ';port='.$_ENV['PORT'].';dbname=' . $_ENV['DATABASE'];
            $this->dbconn = new PDO($dbURI, $_ENV['DBUSER'], $_ENV['DBPASSWORD']);
            $this->dbconn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }

        function checkLoginAdmin($email, $password) {
            // check user_id(email), password correct
            $sql = "SELECT AdminId, Email, Password, FirstName, LastName 
                    FROM adminuser
                    WHERE Email = :email";
            $stmt = $this->dbconn->prepare($sql);
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt->execute();
            if($stmt->rowCount() > 0) {  
                $result = $stmt->fetch(PDO::FETCH_ASSOC);
                if(strlen($result['Email']) > 0) {
                        if (password_verify($password, $result['Password'])) {// true: verified  
                            return Array('adminid'=>$result['AdminId'],
                                'email'=>$result['Email'],
                                'firstname'=>$result['FirstName'],
                                'lastname'=>$result['LastName']);
                        }
                        else return false;
                } else {
                    return false;
                }
            } else {
                return false;
            }
        }

        function emailExist($email) {
            $sql = "SELECT AdminId, Email FROM adminuser WHERE Email = :email"; 
            $stmt = $this->dbconn->prepare($sql);
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);  // varchar: PDO::PARAM_STR 
            $stmt->execute();
            if ($stmt->rowCount() > 0) {
                return true;
            } else {
                return false;
            }
        }

        function registerUserAdmin($fname, $lname, $email, $pass) {
            $adminid = 0;
            $hpass = password_hash($pass, PASSWORD_DEFAULT );

            // Retister user into system, assume validation has happened.
            $sql = "INSERT INTO adminuser (Email, Password, FirstName, LastName, RegisterDate) VALUES (:fname, :lname, :email, :pass, CURRENT_DATE)"; 
            $stmt = $this->dbconn->prepare($sql);
            $stmt->bindParam(':fname', $fname, PDO::PARAM_STR);
            $stmt->bindParam(':lname', $lname, PDO::PARAM_STR);
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt->bindParam(':pass', $hpass, PDO::PARAM_STR);
            $result = $stmt->execute();
            if($result == true) 
                $adminid = $this->dbconn->lastInsertId(); 
            return $adminid;
        } 
   
        function displayAllCustomers() {
            $resultArray = [];
            // check user_id(email), password correct
            $sql = "SELECT CustomerId, Email, Password, FirstName, LastName, Theme, RegisterDate, Active
                    FROM customer";
            $stmt = $this->dbconn->prepare($sql);
            $stmt->execute();
            if ($stmt->rowCount() > 0) {  
                $result = $stmt->fetchAll();  // fetch all Customers
                if ($result) {
                    foreach ($result as $row) { // create an array of Customers
                        $temp = Array('customerid'=>$row['CustomerId'],
                        'email'=>$row['Email'],
                        'name'=>$row['FirstName'].' '.$row['LastName'],
                        'theme'=>$row['Theme'],
                        'registerdate'=>$row['RegisterDate'],
                        'active'=>$row['Active']); 
                        array_push($resultArray, $temp);
                    }
                }
                return $resultArray;
            } 
            elseif ($stmt->rowCount() == 0) {
                return 0;
            }
            else return false; 
        }

        function displayCustomer($customerid) {
            // check user_id(email), password correct
            $sql = "SELECT CustomerId, Email, FirstName, LastName, PhoneNo, Address, Suburb, 
                    State, Postcode, Country, Theme, RegisterDate, Active, CancelDate
                    FROM customer WHERE CustomerId = :cid";
            $stmt = $this->dbconn->prepare($sql);
            $stmt->bindParam(':cid', $customerid, PDO::PARAM_STR);
            $stmt->execute();
            if ($stmt->rowCount() > 0) {  
                $result = $stmt->fetch(PDO::FETCH_ASSOC);  // fetch a customer
                if (isset($result)) { 
                    return Array(
                        'customerid'=>$result['CustomerId'],
                        'email'=>$result['Email'],
                        'name'=>$result['FirstName'].' '.$result['LastName'],
                        'phoneno'=>$result['PhoneNo'],
                        'address'=>$result['Address'].' '.$result['Suburb'].' '.$result['State'].' '.$result['Postcode'].' '.$result['Country'],
                        'theme'=>$result['Theme'],
                        'registerdate'=>$result['RegisterDate'], 
                        'active'=>$result['Active'],
                        'canceldate'=>$result['CancelDate']); 
                }
            } 
            elseif ($stmt->rowCount() == 0) {
                return 0;
            }
            else return false; 
        }

        function cancelCustomer($customerid) {

            $sql = "UPDATE customer SET ACTIVE = 0, CancelDate = CURRENT_DATE 
                    WHERE CustomerId = :cid";
            $stmt = $this->dbconn->prepare($sql);
            $stmt->bindParam(':cid', $customerid, PDO::PARAM_STR);
            $result = $stmt->execute();
            return $result;
        }

        function displayLogs() {
             $sql = "SELECT LogId, ClientIP, SessionId, Username, PlanType, LogTime, Action, ResponseCode 
                    FROM actionlog
                    ORDER BY LogTime DESC
                    LIMIT 50 ";
            $stmt = $this->dbconn->prepare($sql);
            $stmt->execute();
            if ($stmt->rowCount() > 0) {  
                $result = $stmt->fetchAll();  // fetch all Customers
                if ($result) {
                    $resultArray = [];
                    foreach ($result as $row) { // create an array of Customers
                        $temp = Array('logid'=>$row['LogId'],
                        'clientip'=>$row['ClientIP'],
                        'sessionid'=>$row['SessionId'],
                        'username'=>$row['Username'],
                        'plantype'=>$row['PlanType'],
                        'action'=>$row['Action'],
                        'responsecode'=>$row['ResponseCode'],
                        'logtime'=>$row['LogTime']); 
                        array_push($resultArray, $temp);
                    }
                    return $resultArray;
                }
                return false;
            } 
            elseif ($stmt->rowCount() == 0) {
                return 0;
            }
            else return false; 
        }
    } // end of class
?>
