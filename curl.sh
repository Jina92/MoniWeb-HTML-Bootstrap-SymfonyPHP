########################################################
# Setting Test data you need to change two things 
######################################################## 
### CHANGE 1, email in this file #######################
# For test, you need to change email for login 
# Currently test0011@email.com is set as a login email. 
# You need another email which is not registered yet for registration testing. 
# All tests will be done using the new registered email 
######################################################## 
### CHANGE 2, whitelist in api/api.php #################
# Checking whitelist in api/api.php will prevent you access using php command 
# You will get 403 error. 
# You need to comment out the whitelist checking part 
########################################################
# Curl options
#-o: output 
#-s, --silent : Silent or quiet mode. Don't show progress meter or error messages.
#-b, --cookie: cookie
#-c, --cookie-jar <filename>: Write cookies to <filename> after operation
#-w "%{http_code}": write value 

# Grep options
#-q, --quiet, --silent:     suppress all normal output
#-E, --extended-regexp:     PATTERN is an extended regular expression

# Check of a website and the connection works well  
# OK: www.google.com works well 
# ERR: ohter results
curl  "http://localhost/PROJ2/api/api.php?action=check&url=www.google.com" \
-s  -w "%{json}" \
| grep -q "works well" && echo 'Check Website works well: OK' || echo 'Check Website works well: ERR'

# Check a website and the connection works failed 
# OK: www.kf134123412341234.com  does not work 
# ERR: other results
curl  "http://localhost/PROJ2/api/api.php?action=check&url=www.kf134123412341234.com" \
-s  -w "%{json}" \
| grep -q "does not work" && echo 'Check Website does not work: OK' || echo 'Check Website does not work: ERR'


# Logout 
# curl  "http://localhost/PROJ2/api/api.php?action=logout" \
# -s -o /dev/null -w "%{http_code}" --cookie cookie.txt \
# | grep -q 200 && echo 'Logout: OK' || echo 'Logout: ERR'
# sleep 1s

# Register profile
curl  "http://localhost/PROJ2/api/api.php?action=register" \
--data "firstname=test" \
--data "lastname=test" \
--data "email=test0011@email.com"  \
--data "password=Test1234!@#$" \
--data "confirmpassword=Test1234!@#$" \
--data "phoneno=0110111222" \
--data "address=12 south street" \
--data "suburb=SouthBank" \
--data "state=QLD" \
--data "postcode=4112" \
-s -o /dev/null -w "%{http_code}" --cookie cookie.txt --cookie-jar cookie.txt \
| grep -q 201 && echo 'Registration: OK' || echo 'Registration: ERR'
sleep 1s

# Diplay myPlan, Success expected. 
curl "http://localhost/PROJ2/api/api.php?action=myplan" \
-s -o /dev/null -w "%{http_code}" \
--cookie cookie.txt \
| grep -q 200 && echo 'Display MyPlan: OK' || echo 'Display MyPlan: ERR'

# Logout 
curl  "http://localhost/PROJ2/api/api.php?action=logout" \
-s -o /dev/null -w "%{http_code}" --cookie cookie.txt \
| grep -q 200 && echo 'Logout: OK' || echo 'Logout: ERR'
sleep 1s

# Failed Login with wrong password
curl  http://localhost/PROJ2/api/api.php?action=login \
--data "loginEmailAddress=test0011@email.com" \
--data "loginPassword=tttt" \
-s -o /dev/null -w "%{http_code}" \
| grep -q 401 && echo 'Failed Login: OK' || echo 'Failed Login: ERR'


# Successful Login
curl "http://localhost/PROJ2/api/api.php?action=login" \
--data "loginEmailAddress=test0011@email.com" \
--data "loginPassword=Test1234!@#$" \
-s -o /dev/null -w "%{http_code}" --cookie-jar cookie.txt \
|grep -q 200 && echo 'Successful Login: OK' || echo 'Successful Login: ERR'


# Display MyPlan
curl "http://localhost/PROJ2/api/api.php?action=myplan" \
-s -o /dev/null -w "%{http_code}" --cookie cookie.txt \
| grep -q 200 && echo 'MyPlan Display: OK' || echo 'MyPlan Display: ERR'

# Get Profile
curl 'http://localhost/PROJ2/api/api.php?action=getProfile' \
-s --request POST -w "%{http_code}" --cookie cookie.txt \
| grep -q customerid && echo 'Get Profile: OK' || echo 'Get Profile: ERR'

# Update Profile
curl 'http://localhost/PROJ2/api/api.php?action=updateProfile' \
--data "editFirstName=pppp" \
--data "editLastName=pppp" \
--data "editEmail=test0011@email.com" \
--data "editPhoneNo=0110111222" \
--data "editAddress=12 south street" \
--data "editSuburb=EastPark" \
--data "editState=NSW" \
--data "editPostcode=5111" \
-s -o /dev/null -w "%{http_code}" --cookie  cookie.txt \
| grep -q 200 && echo 'Update Profile: OK' || echo 'Update Profile: ERR'

# Edit URL 
curl 'http://localhost/PROJ2/api/api.php?action=editURL&url=www.google.com_www.hp.com_tafe.edu.au' \
-s -o /dev/null -w "%{http_code}" --cookie cookie.txt \
| grep -q 200 && echo 'Edit URL: OK' || echo 'Edit URL: ERR'

# Logout 
curl  "http://localhost/PROJ2/api/api.php?action=logout" \
-s -o /dev/null -w "%{http_code}" --cookie cookie.txt \
| grep -q 200 && echo 'Logout: OK' || echo 'Logout: ERR'
