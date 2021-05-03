# Setup Procedure of MoniWeb, a web service monitory system. 

WAMP envirionment assumed 

1.  installation
    cd Wamp-installed-directory/www 
    composer create-project symfony/website-skeleton PROJ2
    composer require symfony/dotenv
    composer install phpmailer/phpmailer 

2. download the API and web resources 
    git clone https://github.com/Jina92/jina92.github.io.git

3. setup .env  
    ```DBHOST=your host for database 
    DATABASE=your database name 
    PORT=your database port 
    DBUSER=your database user name
    DBPASSWORD=password 
    API=you API path 
    ORIGIN=your origin URL 
    SMTP_USERNAME=your user name for SMTP server
    SMTP_PASSWORD=your password for SMTP server
   ```

4. Connect your web site 
    for example,  http://localhost/PROJ2/ 


# API File Structure of Web Service Monitoring System

1. MoniWeb Web Application
 - api/api.php --> MoniWeb Web Application Main Interfaces 
 - db.php --> The database object, which has all methods to connect to database. 
     The methods of the session objesct call the database object methods.     
 - se.php --> the session object ( class definition )
 - ft.php --> other functions called in api.php
 

2. MoniWeb check server 
  - checkserver.php --> MoniWeb check server. This will be registerd in CRON. 
  - db_svr.php  --> all database functions, which connect to database. 

# Notes
  api.php has instantiation of database and session objects at its first part. 
  At the next, it calls session_start to check session pre-exist and start a new session. 
