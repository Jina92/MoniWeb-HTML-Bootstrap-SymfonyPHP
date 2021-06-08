# Setup Procedure of MoniWeb, a web service monitory system. 

WAMP envirionment assumed 

1.  installation 

    - PHP 
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
    DBPORT=your database port (same as above) 
    DBUSER=your database user name
    DBPASSWORD=password 
    API=you API path 
    ORIGIN=your origin URL 
    SMTP_USERNAME=your user name for SMTP server
    SMTP_PASSWORD=your password for SMTP server
   ```
    * Example 
    ```DBHOST=localhost
    DATABASE=moniweb
    PORT=3306
    DBPORT=3306
    DBUSER=root
    DBPASSWORD=
    API=http://localhost/api/api.php
    ORIGIN=http://localhost
    SMTP_USERNAME=
    SMTP_PASSWORD=
    ```


4. Connect your web site 
    for example,  http://localhost/PROJ2/ 


# API File Structure of Web Service Monitoring System

1. MoniWeb Web Application
 - api/api.php --> the main application interface for the MoniWeb website 
 - se.php --> the session class 
 - db.php --> The database class, which has all methods to connect to database. 
     The methods of the session object call the database object methods.     
 - ft.php --> other functions used in api.php
 

2. MoniWeb check server 
  - checkserver.php --> a monitoring server to check status of customers' website . This will be registerd in CRON. 
  - db_svr.php  --> all database functions related the monitoring server, which connect to database. 

### Notes
  api.php has instantiation of database and session objects at its first part. 
  At the next, it calls session_start to check session pre-exist and start a new session. 


# Used Technics 

### This application uses for the Front End

- Start Bootstrap v6.0.2 of MIT, which based on bootstrap 4.5.3. 
- Chars.js 3.3.2 for generating a report
- Font Awesome 5.15.1 
- The index.html file includes Bootstrap 4.5.3 and JQuery 3.5.1, Chart.js 3.3.2 and Font Awesome 5.15.1  using CDN resources. 

### This application uses for the Back End
- Symfony 5.2.8 including Dotenv and PhpMailer
- You can install this with composer specified in the Installation part of this README.md

### You can use later versions of aboves, however, the same versions give you the best result. 

