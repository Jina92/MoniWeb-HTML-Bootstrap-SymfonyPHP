<?php

    class mwModel {

        private $dbconn;

        public function __construct() {
            /* establish a connection to the mySQL database */ 
            $dbURI = 'mysql:host=' . $_ENV['DBHOST'] . ';port='.$_ENV['PORT'].';dbname=' . $_ENV['DATABASE'];
            $this->dbconn = new PDO($dbURI, $_ENV['DBUSER'], $_ENV['DBPASSWORD']);
            $this->dbconn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }

        function checkLogin($email, $password) {
            // check user_id(email), password correct
            $sql = "SELECT c.CustomerId as CustomerId, Email, Password, Firstname, Theme, p.Type as PlanType
                    FROM customer c INNER JOIN customerplan cp INNER JOIN plan p 
                    ON c.CustomerId = cp.CustomerId and cp.PlanId = p.PlanId
                    WHERE Email = :email";
            $stmt = $this->dbconn->prepare($sql);
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            //$stmt->bindParam(':password', $hpass, PDO::PARAM_STR);
            // If you use PDO::PARAM_INT, the where condition is always true. Why?? 
            $stmt->execute();
            if($stmt->rowCount() > 0) {  // password is correct
                $result = $stmt->fetch(PDO::FETCH_ASSOC);
                if(strlen($result['Email']) > 0) {
                        if (password_verify($password, $result['Password'])) {// true: verified  
                            return Array('customerid'=>$result['CustomerId'],
                                'email'=>$result['Email'],
                                'firstname'=>$result['Firstname'],
                                'theme'=>$result['Theme'], 
                                'plantype'=>$result['PlanType']);
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
            $sql = "SELECT CustomerId FROM Customer WHERE Email = :email"; 
            $stmt = $this->dbconn->prepare($sql);
            $stmt->bindParam(':email', $email, PDO::PARAM_STR); //3rd: Explicit data type for the parameter (related to SQL data type) 
            $stmt->execute();
            if($stmt->rowCount() > 0) {
                return true;
            } else {
                return false;
            }
        }

        function getProfile($email) {
            $sql = "SELECT * FROM customer WHERE Email = :email"; 
            $stmt = $this->dbconn->prepare($sql);
            $stmt->bindParam(':email', $email, PDO::PARAM_STR); //3rd: Explicit data type for the parameter (related to SQL data type) 
            $stmt->execute();
            if($stmt->rowCount() > 0) {
                $result = $stmt->fetch(PDO::FETCH_ASSOC);
                if(strlen($result['Email']) > 0) {
                    return Array('customerid'=>$result['CustomerId'],
                            'firstname'=>$result['FirstName'],
                            'lastname'=>$result['LastName'],
                            'email'=>$result['Email'],
                            'phoneno'=>$result['PhoneNo'],
                            'address'=>$result['Address'],
                            'suburb'=>$result['Suburb'],
                            'state'=>$result['State'],
                            'postcode'=>$result['Postcode'],
                            'country'=>$result['Country']);
                } else {
                    return false;
                }
            } else {
                return false;
            }
        }

        function updateProfile($orgEmail, $fname, $lname, $newEmail, $phone, $add, $suburb, $state, $postcode) {
            $country = "Australia";
            // update user info, assume validation has happened.
            $sql = "UPDATE Customer SET FirstName=:fname,LastName=:lname,Email=:newemail,PhoneNo=:phone,
                    Address=:add,Suburb=:suburb,State=:state,Postcode=:postcode WHERE Email = :email"; 
            $stmt = $this->dbconn->prepare($sql);
            $stmt->bindParam(':fname', $fname, PDO::PARAM_STR);
            $stmt->bindParam(':lname', $lname, PDO::PARAM_STR);
            $stmt->bindParam(':newemail', $newEmail, PDO::PARAM_STR);
            $stmt->bindParam(':phone', $phone, PDO::PARAM_STR);
            $stmt->bindParam(':add', $add, PDO::PARAM_STR);
            $stmt->bindParam(':suburb', $suburb, PDO::PARAM_STR);
            $stmt->bindParam(':state', $state, PDO::PARAM_STR);
            $stmt->bindParam(':postcode', $postcode, PDO::PARAM_STR);
            $stmt->bindParam(':email', $orgEmail, PDO::PARAM_STR);
            $result = $stmt->execute();
            return $result; // true: success false: failure 
            
        }

        private function initURLs($customerplanid, $maxNumURL) {
            // populate initial empty urls for a registered customer
            // INSERT blank records as many as the number of URL, which is specified in  maxNumURL of Free plan
            
            for ($i=0; $i < $maxNumURL; $i++) {
                
                $sql = "INSERT INTO customerplanurl(URL,IPaddress, CustomerPlanId) VALUES (NULL, NULL, :cplanid)"; 
                $stmt = $this->dbconn->prepare($sql);
                $stmt->bindParam(':cplanid', $customerplanid, PDO::PARAM_INT);
                $result = $stmt->execute();
                if ($stmt->rowCount() < 1) {
                    return false;
                }
            }
            return true;
        }

        function registerUser($fname, $lname, $email, $pass, $phone, $add, $suburb, $state, $postcode) {
            $country = "Australia";
            $customerid = 0;
            $customerplanid = 0;
            $hpass = password_hash($pass, PASSWORD_DEFAULT );

            $this->dbconn->beginTransaction();
            // Retister user into system, assume validation has happened.
            $sql = "INSERT INTO customer(FirstName, LastName, Email, Password, PhoneNo, Address, Suburb, State, Postcode, Country, RegisterDate) 
            VALUES (:fname, :lname, :email, :pass, :phone, :add, :suburb, :state, :postcode, :country,  CURRENT_DATE)";
            $stmt = $this->dbconn->prepare($sql);
            $stmt->bindParam(':fname', $fname, PDO::PARAM_STR);
            $stmt->bindParam(':lname', $lname, PDO::PARAM_STR);
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt->bindParam(':pass', $hpass, PDO::PARAM_STR);
            $stmt->bindParam(':phone', $phone, PDO::PARAM_STR);
            $stmt->bindParam(':add', $add, PDO::PARAM_STR);
            $stmt->bindParam(':suburb', $suburb, PDO::PARAM_STR);
            $stmt->bindParam(':state', $state, PDO::PARAM_STR);
            $stmt->bindParam(':postcode', $postcode, PDO::PARAM_STR);
            $stmt->bindParam(':country', $country, PDO::PARAM_STR);
            $result = $stmt->execute();

            if($result == true) {
                $customerid = $this->dbconn->lastInsertId();  // save generated customer Id for an new user
                // 001: Free plan, default
                $sql = "INSERT INTO customerplan(CustomerId, StartDate, PlanId) VALUES (:custid, CURRENT_DATE, 001)"; 

                $stmt = $this->dbconn->prepare($sql);
                $stmt->bindParam(':custid', $customerid, PDO::PARAM_INT);
                $result = $stmt->execute();
                if ($stmt->rowCount() < 1) {
                    $this->dbconn->rollBack();
                    return false;
                }
                $customerplanid = $this->dbconn->lastInsertId(); // save generated plan id for free plan
                $initResult = $this->initURLs($customerplanid, 5 );  // you need to add SELECT statment for Plan table
                if ($initResult == true ) {
                    $this->dbconn->commit();
                    return $customerid;
                } 
                else {
                    $this->dbconn->rollback();
                    return false;
                }
            } else {
                $this->dbconn->rollBack();
                return false;
            }
        }

        function getPlan($customerid) {
            $allURLs = [];
            $customerplanid = 0; 
            $startdate = '';
            $enddate = '';
            $planid = 0;
            $plantype= '';
            
            $this->dbconn->beginTransaction();
            $sql = "SELECT CustomerPlanId,  StartDate, EndDate, c.PlanId as PlanId, Type
            FROM customerplan c INNER JOIN Plan p ON c.PlanId = p.PlanId WHERE CustomerId = :cid " ; 
            $stmt = $this->dbconn->prepare($sql);
            $stmt->bindParam(':cid', $customerid, PDO::PARAM_INT); 
            $stmt->execute();
            if($stmt->rowCount() > 0) {
                $result = $stmt->fetch(PDO::FETCH_ASSOC);
                if($result['CustomerPlanId'] > 0) {
                    $customerplanid = $result['CustomerPlanId'];
                    $startdate = $result['StartDate'];
                    $enddate = $result['EndDate'];
                    $planid = $result['PlanId'];
                    $plantype = $result['Type']; 
    
                    // retrieve all URLs 
                    $sql = "SELECT URL FROM customerplanurl WHERE CustomerPlanId = :custplanid"; 
                    $stmt = $this->dbconn->prepare($sql);
                    $stmt->bindParam(':custplanid', $customerplanid, PDO::PARAM_INT); 
                    $stmt->execute();
                    if($stmt->rowCount() > 0) { // At least one URL is registered 
                        $result = $stmt->fetchAll();  // fetch all URLs 
                        if ($result) {
                            foreach ($result as $row) { // create an array of URLs 
                                array_push($allURLs, $row['URL']);
                            }
                        }
                    }
                    $this->dbconn->commit();
                    return Array('customerplanid'=>$customerplanid,
                    'startdate'=>$startdate,
                    'enddate'=>$enddate,
                    'planid'=>$planid,
                    'plantype'=>$plantype, 
                    'url'=>$allURLs);
                } 
                else {
                    $this->dbconn->rollback();
                    return false;
                }
            } 
            $this->dbconn->rollback();
            return false;
        }

        private function updateSingleURL($urlid, $newURL) {

            $sql = "UPDATE customerplanurl SET URL=:newUrl WHERE UrlId = :urlid;"; 
            $stmt = $this->dbconn->prepare($sql);
            $stmt->bindParam(':newUrl', $newURL, PDO::PARAM_STR);
            $stmt->bindParam(':urlid', $urlid, PDO::PARAM_INT);
            $result = $stmt->execute();
            // update a value into the same data,  the result is true but the affected row count is 0 
            return ($result);
        } 

        function editURL($customerid, $array_url) {
            $customerplanid = 0;
            $this->dbconn->beginTransaction(); 
            //get plan id for the customer 
            $sql = "SELECT CustomerPlanId, PlanId FROM customerplan WHERE CustomerId = :cid"; 
            $stmt = $this->dbconn->prepare($sql);
            $stmt->bindParam(':cid', $customerid, PDO::PARAM_INT);
            $result = $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if ($stmt->rowCount() > 0 ) {
                $customerplanid = $result['CustomerPlanId'];

            } else {
                $this->dbconn->rollback();
                return false;
            }

            //get all URLs for the customer   
            $sql = "SELECT UrlId, URL FROM Customerplanurl WHERE CustomerPlanId = :cplanid"; 
            $stmt = $this->dbconn->prepare($sql);
            $stmt->bindParam(':cplanid', $customerplanid, PDO::PARAM_INT);
            $result = $stmt->execute();
            $result = $stmt->fetchAll();  // fetch all URLs 
            if ($result) {
                // update all urls, empty urls (saved as NULL in the database) are updated too. 
                // delete does not exist,  an update with blank data will delete an URL
                foreach ($result as $row) { // create an array of URLs 
                    // for each row of registered URLS, update it with each item of the given array as parameter 
                    $urlid = $row['UrlId']; // registered URL 
                    $newURL = array_shift($array_url);

                    $updateResult = $this->updateSingleURL($urlid, $newURL);   // update an url into the database
                    if (!$updateResult) {  // false
                        $this->dbconn->rollback();
                        return false;
                    }  
                }
                $this->dbconn->commit();
                return true;
            }
            else { 
                $this->dbconn->rollback();
                return false; 
            }
        }

        function upgradePlan($customerid, $newplantype) {

            /* $level matches the plan id(plan code) in database: 
                free: 001
                standard: 002
                premium: 003 
             */ 
            
            $this->dbconn->beginTransaction();
            /* SELECT Plan Type Code */ 
            $sql = "SELECT PlanId, Type, MaxNumURL FROM plan WHERE Type = :plantype";
            $stmt = $this->dbconn->prepare($sql);
            $stmt->bindParam(':plantype', $newplantype, PDO::PARAM_STR);
            $stmt->execute();
            if($stmt->rowCount() < 1) {
                $this->dbconn->rollback();
                return false;
            }
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            if (!$result) {
                $this->dbconn->rollback();
                return false;
            }

            $newplanid = $result['PlanId'];
            $maxNumURL = $result['MaxNumURL'];

            /* SELECT Customer Plan ID */ 
            $sql = "SELECT CustomerPlanId, CustomerId, PlanId FROM customerplan WHERE CustomerId = :custid"; 
            $stmt = $this->dbconn->prepare($sql);
            $stmt->bindParam(':custid', $customerid, PDO::PARAM_INT);
            $stmt->execute();
            if($stmt->rowCount() < 1) {
                $this->dbconn->rollback();
                return false;
            }
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            if (!$result) {
                $this->dbconn->rollback();
                return false;
            }
            $customerplanid = $result['CustomerPlanId'];

            /* UPDATE PLAN to upgrade */
            $sql = "UPDATE customerplan SET StartDate=CURRENT_DATE,PlanId=:planid WHERE CustomerPlanId = :custplanid"; 
            $stmt = $this->dbconn->prepare($sql);
            $stmt->bindParam(':custplanid', $customerplanid, PDO::PARAM_INT);
            $stmt->bindParam(':planid', $newplanid, PDO::PARAM_INT);
            $result = $stmt->execute();
            if (!$result) {
                $this->dbconn->rollBack();
                return false;
            }

            /* Count registered URLs.  */  
            $sql = "SELECT COUNT(UrlId) as CountUrl FROM customerplanurl WHERE CustomerPlanId = :custplanid"; 
            $stmt = $this->dbconn->prepare($sql);
            $stmt->bindParam(':custplanid', $customerplanid, PDO::PARAM_INT);
            $stmt->execute();
            if($stmt->rowCount() < 1) {
                $this->dbconn->rollback();
                return false;
            }
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            if (!$result) {
                $this->dbconn->rollback();
                return false;
            }
            $counturl = $result['CountUrl'];

            // Add blank urls as many as the max number minus the count of existing urls  
            $initResult = $this->initURLs($customerplanid, ($maxNumURL-$counturl));
            if ($initResult == true ) {
                $this->dbconn->commit();
                return true;
            } 
            else {
                $this->dbconn->rollback();
                return false;
            }
        } 

        function logEvent($clientip, $sid, $email, $plantype, $action, $responsecode) {
            $sql = "INSERT INTO actionlog(ClientIP, SessionId, Username, PlanType, LogTime, Action, ResponseCode) 
            VALUES (:cip, :sessid, :uname, :ptype, CURRENT_TIMESTAMP, :act, :rcode)";
            $stmt = $this->dbconn->prepare($sql);
            $stmt->bindParam(':cip', $clientip, PDO::PARAM_STR);
            $stmt->bindParam(':sessid', $sid, PDO::PARAM_STR);
            $stmt->bindParam(':uname', $email, PDO::PARAM_STR);
            $stmt->bindParam(':ptype', $plantype, PDO::PARAM_STR);
            $stmt->bindParam(':act', $action, PDO::PARAM_STR);
            $stmt->bindParam(':rcode', $responsecode, PDO::PARAM_INT);
            $result = $stmt->execute();
            if($result == true) {
                return true;
            } else {
                return false;
            }
        }
    }
?>
