<?php
    // Defined for MoniWeb monitoring server (Cron)
    class mwModelServer {

        private $dbconn;

        public function __construct() {
            /* establish a connection to the mySQL database */ 
            $dbURI = 'mysql:host=' . $_ENV['DBHOST'] . ';port='.$_ENV['DBPORT'].';dbname=' . $_ENV['DATABASE'];
            $this->dbconn = new PDO($dbURI, $_ENV['DBUSER'], $_ENV['DBPASSWORD']);
            $this->dbconn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }

        function getURL($plantype) {
            $url_list = [];  // a list of customer plan id and url 
              

            $sql = "SELECT u.UrlId as UrlId, u.URL as URL
            FROM Plan p INNER JOIN customerplan cp INNER JOIN customerplanurl u
            ON p.PlanId = cp.PlanId AND cp.CustomerPlanId = u.CustomerPlanId
            WHERE p.Type = :plantype AND u.URL IS NOT NULL " ; 
            $stmt = $this->dbconn->prepare($sql);
            $stmt->bindParam(':plantype', $plantype, PDO::PARAM_INT); 
            $stmt->execute();
            if($stmt->rowCount() > 0) {
                $result = $stmt->fetchAll();  // fetch all URLs 
                if ($result) {
                    foreach ($result as $row) { // create an array of URLs 
                        array_push($url_list, array($row['UrlId'], $row['URL']));
                    }
                }
            }
            return $url_list;
        }

        function getEmail($urlid) {

            $sql = "SELECT c.Email as Email, FirstName, LastName
            FROM Customer c INNER JOIN customerplan p INNER JOIN customerplanurl u
            ON c.CustomerId = p.CustomerId AND p.CustomerPlanId = u.CustomerPlanId
            WHERE u.UrlId = :urlid"; 
            $stmt = $this->dbconn->prepare($sql);
            $stmt->bindParam(':urlid', $urlid, PDO::PARAM_INT);
            $result = $stmt->execute();
            if ($stmt->rowCount() > 0 ) {
                $result = $stmt->fetch(PDO::FETCH_ASSOC);  
                return Array('email'=>$result['Email'], 
                             'name'=>$result['FirstName']." ".$result['LastName']);
            } 
            else return false;
        }
        
        
        // function logStatus($urlid, $errnum, $errmsg) {

        //     $sql = "INSERT INTO monitorstatus(UrlId, MonitorTime, ResultStatus, Description) VALUES (:urlid, CURRENT_TIMESTAMP, :errnum, :errmsg)"; 
        //     $stmt = $this->dbconn->prepare($sql);
        //     $stmt->bindParam(':urlid', $urlid, PDO::PARAM_INT);
        //     $stmt->bindParam(':errnum', $errnum, PDO::PARAM_INT);
        //     $stmt->bindParam(':errmsg', $errmsg, PDO::PARAM_STR);
        //     $result = $stmt->execute();
        //     echo "rowcount: ".($stmt->rowCount()); 
        //     if ($stmt->rowCount() < 1 ) return false;
        //     else return true;
        // } 

        function logStatus($urlid, $httpcode) {

            $sql = "INSERT INTO monitorstatus(UrlId, MonitorTime, ResultStatus) VALUES (:urlid, CURRENT_TIMESTAMP, :httpcode)"; 
            $stmt = $this->dbconn->prepare($sql);
            $stmt->bindParam(':urlid', $urlid, PDO::PARAM_INT);
            $stmt->bindParam(':httpcode', $httpcode, PDO::PARAM_INT);
            //$stmt->bindParam(':errmsg', $errmsg, PDO::PARAM_STR);
            $result = $stmt->execute();
            echo "rowcount: ".($stmt->rowCount()); 
            if ($stmt->rowCount() < 1 ) return false;
            else return true;
        } 
    }
?>
