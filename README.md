# Suppose WAMP envirionment. 

1. Installation 
    d Wamp-installed-directory/www 
    composer create-project symfony/website-skeleton PROJ2
    composer require symfony/dotenv
    composer install phpmailer/phpmailer 

2. download the API and web resources 
    git clone "your remote repository" 

3. setup .env  
    DBHOST=your host for database 
    DATABASE=your database name 
    PORT=your database port 
    DBUSER=your database user name
    DBPASSWORD=password 
    API=you API path 
    ORIGIN=your origin URL 
    SMTP_USERNAME=your user name for SMTP server
    SMTP_PASSWORD=your password for SMTP server

4. Connect your web site 
    for example,  http://localhost/PROJ2/ 


# API File Structure of Web Service Monitoring System

api/api.php --> MoniWeb Web Application Interfaces 
 - db.php --> all database functions, which connect to database. 
 - se.php --> session class definition 
 - ft.php --> functions called from api.php

checkserver.php --> MoniWeb check server. This will be registerd in CRON. 
  - db_svr.php 