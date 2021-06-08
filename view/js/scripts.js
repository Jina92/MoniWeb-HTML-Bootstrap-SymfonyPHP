var SET_TAB = 'home';  /* current tab */ 
var SELECTED_MENU = null; // selectedmenu  -- before modifying 
var myChart = null;

/**************************************************/
/* initialise the screen for the first connection */ 
/**************************************************/
(function() {  /* self invoke function */
    "use strict";   /* strict javascript mode */ 
    
    var savedMode; 

    checkLoggedInFetch();
    /* show default items of sidebar menu before login */ 
    showLoggedOutMenuItems(); 
    // addCommonEventListener(); // add common event listeners of logged in and logged out menus 

    /* initialise the default active menu as Home */
    setMenuActive("home"); 

    // initialise the screen mode as the saved mode in localStorage.
    savedMode = (localStorage.getItem("theme") == 'Dark') ? 'Dark' : 'Light';
    setTheme(savedMode);

    // Add Event Listener considering that the hamburger menu is clicked 
    // version 3 
    document.getElementById('sidebarToggle').addEventListener('click', function(e) { 
        document.getElementsByTagName("BODY")[0].classList.toggle("sb-sidenav-toggled");
    });

    document.getElementById('search').addEventListener('click', showTabHideMenu_search);  
    document.getElementById('mwHelp').addEventListener('click', showHelp);  
})();


/**************************************************/
/* functions for the Navigation sidebar           */ 
/**************************************************/

function setMenuActive(selectedmenu) {
    var elements, tabelements;
    var elem;

    SET_TAB= selectedmenu; /* change the current tab */
    elements=document.querySelectorAll('a.nav-link');

    for (i = 0, len = elements.length; i < len; i++) {
        elem = elements[i];
        if (elem.id === SET_TAB)   /* show where am I */
            elem.classList.add("active");
        else 
            elem.classList.remove("active");
    }

    tabelements=document.querySelectorAll('div.tab');
    for (var i = 0, len = tabelements.length; i < len; i++) {
        if ((selectedmenu+"tab") === tabelements[i].id) {
            tabelements[i].removeAttribute('hidden'); // show 
        }
        else {
            tabelements[i].setAttribute('hidden', 'hidden'); // hide 
        }
    } 
}

function showTabHideMenu(event, selectedmenu) {
/* This shows only the selected tab and toggles the side navigation  */
/* This is implemented for navigation menus */ 
    
    event.preventDefault();

    setMenuActive(selectedmenu); 
    document.getElementsByTagName("BODY")[0].classList.remove("sb-sidenav-toggled");

    if ((selectedmenu == 'home') && (localStorage.getItem('firstname'))) {
        document.getElementById("message").innerHTML = "Welcome "+ localStorage.getItem('firstname');
    }
    if ((selectedmenu == 'setting') && (localStorage.getItem('theme'))) {
        document.getElementById("currentmode").innerHTML = localStorage.getItem('theme');
    }
}

function showTabHideMenu_home(event) {
    event.preventDefault();
    showTabHideMenu(event, 'home');
}
function showTabHideMenu_joinplan(event) {
    event.preventDefault();
    showTabHideMenu(event, 'joinplan');
}
function showTabHideMenu_login(event) {
    event.preventDefault();
    showTabHideMenu(event, 'login');
}
function showTabHideMenu_register(event) {
    event.preventDefault();
    showTabHideMenu(event, 'register');
}
function showTabHideMenu_setting(event) {
    event.preventDefault();
    showTabHideMenu(event, 'setting');
}
function showTabHideMenu_search(event) {
    event.preventDefault();
    showTabHideMenu(event, 'search');
}

function showTab(event, selectedmenu) {
/* This shows only the selected tab */ 
/* This is implemeted for links in tabs */ 
    
    event.preventDefault();
    
    setMenuActive(selectedmenu);
}

function setTheme(mode) {
    
    navElem = document.getElementsByTagName("NAV")[0];
    navvarElem = document.getElementById("sidenavAccordion");
    currentModeElem = document.getElementById("currentmode");
    changeModeElem = document.getElementById("changemodeEnv");

    if (mode == 'Light') {

        /* remove */ 
        localStorage.removeItem('Dark'); 
        navElem.classList.remove('navbar-dark'); /* top menu */ 
        navElem.classList.remove('bg-dark');
        navvarElem.classList.remove('sb-sidenav-dark'); /* side bar */ 
        navvarElem.classList.remove('bg-dark'); 
        changeModeElem.classList.remove('btn-dark');  /* setting: 'change mode' icon */
        changeModeElem.classList.remove('text-white'); 
        
        /* add */
        currentModeElem.innerHTML = mode;
        navElem.classList.add('navbar-light');
        navElem.classList.add('bg-white');
        navvarElem.classList.add('sb-sidenav-light');
        navvarElem.classList.add('bg-white');
    }
    else { //  'Dark' 
        /* remove */
        navElem.classList.remove('navbar-light');
        navElem.classList.remove('bg-white');
        navvarElem.classList.remove('sb-sidenav-light');
        navvarElem.classList.remove('bg-white');
        
        /* add */
        localStorage.setItem('Dark', 'true'); 
        currentModeElem.innerHTML = mode;
        navElem.classList.add('navbar-dark');
        navElem.classList.add('bg-dark'); 
        navvarElem.classList.add('sb-sidenav-dark');
        navvarElem.classList.add('bg-dark');
        changeModeElem.classList.add('btn-dark');  /* setting: 'change mode' icon */
        changeModeElem.classList.add('text-white'); 
    }
}

function toggleNavMode(event) {

    event.preventDefault();

    var toggledTheme; 

    toggledTheme = (localStorage.getItem('theme') == 'Dark')?'Light':'Dark';
    localStorage.setItem('theme', toggledTheme);
    setTheme(toggledTheme);
}


function addLoggedOutEventListener() {

/* Common  menu of logged in status and logged out status ******************************************************/
/* However these are duplicate because the event listener also is reset when a menu is reset  *****************/
    /* NAVIGATION: For the side navigation menu */ 
    document.getElementById('home').addEventListener('click', showTabHideMenu_home);   
    /* home tab */ 
    document.getElementById('inputURL').addEventListener('click', clearMessageCheckURL);

/* unique menu of logged out status*************************************************************************/ 
    /* NAVIGATION: For the side navigation menu */ 
    document.getElementById('joinplan').addEventListener('click', showTabHideMenu_joinplan);  
    document.getElementById('login').addEventListener('click', showTabHideMenu_login);
    document.getElementById('register').addEventListener('click', showTabHideMenu_register); 

    /* JoinPlan tab: For links of the join plan tab */
    document.getElementById('registerForJoinFree').addEventListener('click', function(e) { showTab(e, 'register')});
    document.getElementById('registerForJoinStandard').addEventListener('click', function(e) { showTab(e, 'register')});  
    document.getElementById('registerForJoinPremium').addEventListener('click', function(e) { showTab(e, 'register')}); 

    /* User Register tab: For forms of the register tab */
    document.getElementById('registerForm').addEventListener('submit', registerFetch);
    document.getElementById('loginForm').addEventListener('submit', loginFetch);
    document.getElementById('checkForm').addEventListener('submit', checkFetch);
}

function addLoggedInEventLister() {

/* Common  menu of logged in status and logged out status ******************************************************/
/* However these are duplicate because the event listener also is reset when a menu is reset  *****************/
    /* NAVIGATION: For the side navigation menu */ 
    document.getElementById('home').addEventListener('click', showTabHideMenu_home);   
    
    /* home tab */ 
    document.getElementById('inputURL').addEventListener('click', clearMessageCheckURL); 

/* unique menu of the logged in status*************************************************************************/  
    /* NAVIGATION: For the side navigation menu */ 
    document.getElementById('setting').addEventListener('click', showTabHideMenu_setting); 
    document.getElementById('myplan').addEventListener('click', showMyPlanFetch); // it also calls showTab()
    document.getElementById('logout').addEventListener('click', logoutFetch); // it also calls showTab()
    document.getElementById('report').addEventListener('click', reportFetch);

    /* My Plan tab */ 
    document.getElementById('upgradeButton').addEventListener('click', function(e) { showTab(e, 'upgradeplan')});

    /*  Upgrade Plan tab */ 
    document.getElementById('upgradeStandardButton').addEventListener('click', upgradePlanStandardFetch);
    document.getElementById('upgradePremiumButton').addEventListener('click', upgradePlanPremiumFetch);

    /* Setting tab: For forms and links of the setting tab */
    document.getElementById('updateprofile').addEventListener('click', showProfileFetch);   
    document.getElementById('changepassword').addEventListener('click', function(e) { showTab(e, 'changepassword')});
    document.getElementById('changemodeEnv').addEventListener('click', toggleNavMode); 
    document.getElementById('updateProfileForm').addEventListener('submit', updateProfileFetch);
    document.getElementById('changePasswordForm').addEventListener('submit', changePasswordFetch);

    /* Website URL Register tab: links of the registerURL tab */
    document.getElementById('updateURLForm').addEventListener('submit', updateURLFetch);
}

function showLoggedOutMenuItems() {
    document.getElementById("sidenavContainer").innerHTML = `
    <a id="home" class="nav-link" href="#hometab"><i class="fas fa-home mr-1"></i> Home</a>
    <a id="joinplan" class="nav-link" href="#joinplantab"><i class="far fa-handshake mr-1"></i> Join a Plan</a>
    <a id="login" class="nav-link" href="#logintab"><i class="fas fa-sign-in-alt mr-1"></i> Login</a>
    <a id="register" class="nav-link" href="#registertab"><i class="fas fa-registered mr-1"></i> Register</a>
    `; 

    addLoggedOutEventListener();
}

function showLoggedInMenuItems() {
    document.getElementById("sidenavContainer").innerHTML = `
    <a id="home" class="nav-link" href="#hometab"><i class="fas fa-home mr-1"></i> Home </a>
    <a id="myplan" class="nav-link" href="#myplantab"><i class="fas fa-poll-h mr-1"></i> <div>My Plan</div></a>
    <a id="setting" class="nav-link" href="#settingtab"><i class="fas fa-cog mr-1"></i> Setting</a>
    <a id="report" class="nav-link" href="#reporttab"><i class="fas fa-chart-bar mr-1"></i> Report</a>
    <a id="logout" class="nav-link" href="#logout"><i class="fas fa-sign-out-alt mr-1"></i> Logout</a>
    `;

    addLoggedInEventLister();
}

function showHelp(event) {
    event.preventDefault();

    var helpContents = ` 
         <p> When you registered, you automatically joined the Free plan for monitoring service 
        and can use our website monitoring service for free. </p>
        <ul> 
        <li>After login, you can see MyPlan, Setting and Report menus in the side bar. 
        <img src=./img/helpmenu.png></img> 
        </li>
        <li> You can check and upgrade your plan and add URLs to monitor in MyPlan.  
        <img src=./img/help1.png></img> 
        </li>  
        <li> You can change your password and screen mode in Setting. 
        <img src=./img/help2.png></img>
        </li> 
        <li>You can see your monitoring status report in Report.  
        <img src=./img/help3.png></img>
        </li>
        </ul>
    `;
    $('#messageModal').modal('show');
    document.getElementById('messageModal-body').innerHTML = helpContents;
}

function loggedInInit() {
    // initialize the screen when you logged in 
    showLoggedInMenuItems();
    setMenuActive("home"); 
    document.getElementById("message").innerHTML = "Welcome "+localStorage.getItem('firstname');
}
function loggedOutInit() {
    // initialise the screen when you logged out 
    showLoggedOutMenuItems();
    setMenuActive("home"); 
    document.getElementsByTagName("BODY")[0].classList.remove("sb-sidenav-toggled");
    document.getElementById("message").innerHTML = "Wonderful Website Monitoring Service"; 
    
}

/**************************************************/
/* Fetch functions                                */ 
/**************************************************/

function loginFetch(event) {
/* login with email and password */ 

    event.preventDefault();
    var loginf = document.getElementById('loginForm');
    var formD = new FormData(loginf); 
    fetch('http://localhost/PROJ2/api/api.php?action=login', 
    {
        method: 'POST', 
        body: formD,   // send formData 
        credentials: 'include' 
    })
    .then(function(response) {
        
        if(response.status == 401) {
            console.log('login failed');
            $('#messageModal').modal('show');
            document.getElementById('messageModal-body').innerHTML = "Login failed. Please try again.";
            return;
        }
        if(response.status == 429) {
            console.log('Too many request.');
            $('#messageModal').modal('show');
            document.getElementById('messageModal-body').innerHTML = "Too many request. Please try later.";
            return;
        }
        if(response.status == 203) {
            console.log('registration required');
            $('#messageModal').modal('show');
            document.getElementById('messageModal-body').innerHTML = "Registration required";
            return;
        }
        if(response.status == 400) {
            console.log('Sorry. System Error occurs.\n Please contact to MoniWeb Administration');
            $('#messageModal').modal('show');
            document.getElementById('messageModal-body').innerHTML = "Sorry. System Error occurs.\n Please contact to MoniWeb Administration";
            return;
        }
        // Login succeed, setting should be saved in localStroage. 
        response.json().then(function(body) {
            localStorage.setItem('firstname', body.firstname);
            localStorage.setItem('email', body.email);
            localStorage.setItem('theme', body.theme);
            loggedInInit(); 

        }); 
        console.log("login success, status:"+ response.status)
    })
    .catch(error => console.log(error));
}

function registerFetch(event) {
/* register a user account */ 
    event.preventDefault();   
    showSpinner('register');

    // check validity
    if (inputPassword.value !== inputConfirmPassword.value)  
        alert("Input password and confirmed password should be same.");


    var formD = new FormData(); 
    // FormData lets you compile a set of key/value pairs to send using XMLHttpRequest
    // A network methods, such as fetch, can accept a FormData object as a body
    // It’s encoded and sent out with Content-Type: multipart/form-data
    formD.append('firstname', inputFirstName.value);
    formD.append('lastname', inputLastName.value); 
    formD.append('email', inputEmail.value);
    formD.append('password', inputPassword.value);
    formD.append('confirmpassword', inputConfirmPassword.value);
    formD.append('phoneno', inputPhoneNo.value);
    formD.append('address', inputAddress.value);
    formD.append('suburb', inputSuburb.value);
    formD.append('state', inputState.value);
    formD.append('postcode', inputState.value);
    
    fetch('http://localhost/PROJ2/api/api.php?action=register', 
    {
        method: 'POST', 
        body: formD,   // send formData 
        credentials: 'include' 
    })
    .then(function(response) {
        hideSpinner('register');
        if(response.status == 400) {
            console.log('register failed');
            return;
        }
        if(response.status == 201) {
            console.log('registration completed');
            $('#messageModal').modal('show');
            document.getElementById('messageModal-body').innerHTML = "User Registration Success";
            localStorage.setItem('firstname', inputFirstName.value);
            localStorage.setItem('email', inputEmail.value);
            localStorage.setItem('theme', 'Light'); // default Light
            loggedInInit(); 
            return;
        }
        if((response.status == 206) || (response.status == 200)) { //  Succcess but Error could have been set.
            // 206 means email already used  
            response.json().then(function(body) {
                $('#messageModal').modal('show');
                document.getElementById('messageModal-body').innerHTML = body;
            
            });
        }
        console.log("status:"+response.status)

    })
    .catch(error => console.log(error));
}


function checkFetch(event) {
/* Check a given IP address work */ 
/* PUT: idempotent, POST: not idempotent */ 

    showSpinner('check');
    event.preventDefault();
    fetch('http://localhost/PROJ2/api/api.php?action=check&url='+document.getElementById('inputURL').value, 
    {
        method: 'GET', 
        credentials: 'include' 
    })
    .then(function(response) {
        hideSpinner('check');
        
        if(response.status == 404) { // 404 Not Found
            console.log('URL is not found');
            // you need to clean localStorage.
            //localStorage.removeItem('csrf');
            return;
        }
        if(response.status == 200) { // 200 OK 
            response.json().then(function(body) {
                console.log(body);
                document.getElementById("checkMessage").innerHTML = body;
                document.getElementById("checkMessage").removeAttribute("hidden");
            }); 
        }
        if(response.status == 408) { // 408 Request Timeout 
            console.log('Request Timeout');
            return;
        }
        if(response.status == 400) { 
            console.log('Error Occurred');
            return;
        }
    })
    .catch(error => console.log(error));
}


function showMyPlanFetch(event) {
/* display the user's plan details */

    var i=0;

    
    event.preventDefault();
    
    fetch('http://localhost/PROJ2/api/api.php?action=myplan', 
    {
        method: 'GET',
        credentials: 'include' 
    })
    .then(function(response) {
        
        if(response.status == 404) { // 404 Not Found
            console.log('URL is not found');
            return;
        }
        if((response.status == 403) || (response.status == 401 )) { 
            console.log('You need to login');
            return;
        }
        
        if(response.status == 200) { // 200 OK 
            response.json().then(function(body) {
                document.getElementById('planType').innerHTML = body.plantype + " Plan";
                body.url.forEach(item => {
                    i++; 
                    if (item) document.getElementById('updateURL'+i).value = item;
                });
                return ;
            }); 
            
            showTabHideMenu(event, 'myplan');
        }
        if(response.status == 400) { 
            console.log('Error Occurred');
            return;
        }
    })
    .catch(error => console.log(error));

}
function showProfileFetch(event) {
/* Display the user profile details */

    event.preventDefault();

    var formD = new FormData();
    formD.append("email", hiddenEmail.value);

    fetch('http://localhost/PROJ2/api/api.php?action=getProfile', 
    {
        method: 'POST',
        body: formD,   // send formData  
        credentials: 'include' 
    })
    .then(function(response) {
        
        if(response.status == 404) { // 404 Not Found
            console.log('URL is not found');
            // you need to clean localStorage.
            //localStorage.removeItem('csrf');
            return;
        }
        if(response.status == 200) { // 200 OK 
            response.json().then(function(body) {
                updateFirstName.value = body.firstname;
                updateLastName.value = body.lastname;
                updateEmail.value = body.email;
                updatePhoneNo.value = body.phoneno;
                updateAddress.value = body.address;
                updateSuburb.value = body.suburb;
                updateState.value = body.state;
                updatePostcode.value = body.postcode;
            }); 
            
            showTab(event, 'updateprofile')
            console.log("success");
        }
        if(response.status == 400) { 
            console.log('Error Occurred');
            return;
        }
    })
    .catch(error => console.log(error));

}

function updateProfileFetch(event) {
/* Update the user profile details */

    
    event.preventDefault();
    updateProfilef= document.getElementById('updateProfileForm');
    var formD = new FormData(updateProfilef);

    fetch('http://localhost/PROJ2/api/api.php?action=updateProfile', 
    {
        method: 'POST',
        body: formD,   // send formData  
        credentials: 'include' 
    })
    .then(function(response) {
        
        if(response.status == 404) { // 404 Not Found
            console.log('URL is not found');
            // you need to clean localStorage.
            //localStorage.removeItem('csrf');
            return;
        }
        if(response.status == 200) { // 200 OK 
            console.log("profile updated");
            $('#messageModal').modal('show');
            document.getElementById('messageModal-body').innerHTML = "Profile updated";
            return;
        }
        if(response.status == 400) { 
            console.log('Error Occurred!!');
            return;
        }
    })
    .catch(error => console.log(error));

}

function updateURLFetch(event) {
/* Update the registered URLs in the user's plan */

    var formD = new FormData(document.getElementById('updateURLForm')); 
    var urlList;
    var i, numberofURL;

    
    event.preventDefault();   
    numberofURL = 5;
    /* generate a url list as a string type */
    for (i=1; i<=numberofURL; i++) {
        if (i==1) urlList = document.getElementById('updateURL'+i).value;
        else urlList = urlList + "_"+document.getElementById('updateURL'+i).value;
    }
 
    /* It should be changed to From method, becuase of the data size limitation in GET method */
    fetch('http://localhost/PROJ2/api/api.php?action=updateURL&url='+urlList, 
    {
        method: 'GET', 
        credentials: 'include' 
    })
    .then(function(response) {
        
        if(response.status == 400) {
            console.log('register failed');
            return;
        }
        if(response.status == 200) {
            console.log("successfully updated");
            $('#messageModal').modal('show');
            document.getElementById('messageModal-body').innerHTML = "Successfully updated.";

            return;
        } 
        else {
            console.log("status:"+response.status);
        }
    })
    .catch(error => console.log(error));
}

function upgradePlanFetch(level) {
/* Upgrade the user's plan to the higher, premium plan */

    fetch('http://localhost/PROJ2/api/api.php?action=upgrade&level='+level, 
    {
        method: 'GET', 
        credentials: 'include' 
    })
    .then(function(response) {
        
        if(response.status == 400) {
            console.log('upgrade failed');
            return;
        }
        if(response.status == 200) {
            console.log("successfully upgrade to "+level);
            $('#messageModal').modal('show');
            document.getElementById('messageModal-body').innerHTML = "Successfully upgrade to "+level;
            showMyPlanFetch(event);
            return;
        } else {
            console.log("status:"+response.status);
        }
    })
    .catch(error => console.log(error));
}

function upgradePlanStandardFetch(event) {
    event.preventDefault();  
    upgradePlanFetch('Standard');
}

function upgradePlanPremiumFetch(event) {
    event.preventDefault();  
    upgradePlanFetch('Premium');
}

function changePasswordFetch(event, level) {

    event.preventDefault();  
    var formD = new FormData(document.getElementById('changePasswordForm'));
    
    fetch('http://localhost/PROJ2/api/api.php?action=changePassword', 
    {
        method: 'POST',
        body: formD,   // send formData  
        credentials: 'include' 
    })
    .then(function(response) {
        if(response.status == 200) { // 200 OK 
            console.log("Password updated.");
            $('#messageModal').modal('show');
            document.getElementById('messageModal-body').innerHTML = "Password updated.";
            return;
        }
        if(response.status == 400) { 
            console.log('Error Occurred!!');
            return;
        }
    })
    .catch(error => console.log(error));
}

function displayGraph(urlLabel, countData) { 

    console.log(urlLabel);
    console.log(countData);
    var ctx = document.getElementById('statusChart').getContext('2d');
    if (myChart != null) myChart.destroy();
        myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: urlLabel,
            datasets: [{
                label: 'Service down number in last 24 hours  ',
                data: countData,
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)',
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(153, 102, 255, 0.2)'
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
}

function reportFetch(event) {
    event.preventDefault();

    showTabHideMenu(event, 'report');
    document.getElementById("reportmessage").innerHTML = null; 

    var i=0;

    fetch('http://localhost/PROJ2/api/api.php?action=report', 
    {
        method: 'GET',
        credentials: 'include' 
    })
    .then(function(response) {
        if((response.status == 403) || (response.status == 401 )) { 
            console.log('You need to login');
            return;
        }
        if(response.status == 200) { // 200 OK 
            response.json().then(function(body) {
                console.log("reportFetch");
                displayGraph(body.URL, body.numOfDown);
                return ;
            }); 
        }
        if(response.status == 400) { 
            response.json().then(function(body) {
                document.getElementById("reportmessage").innerHTML = body;
                return;
            });
        }
    })
    .catch(error => console.log(error));
}

function logoutFetch(event, level) {
    event.preventDefault();  
    
    fetch('http://localhost/PROJ2/api/api.php?action=logout', 
    {
        method: 'GET', 
        credentials: 'include' 
    })
    .then(function(response) {
        if(response.status == 200) {
            localStorage.removeItem('firstname');
            localStorage.removeItem('email');
            localStorage.removeItem('theme');
            console.log("successfully logged out");
            loggedOutInit();
            return;
            
        } else {
            console.log("error status:"+response.status);
            return;
        }
    })
    .catch(error => console.log(error));
}
function checkLoggedInFetch() { 
    
    fetch('http://localhost/PROJ2/api/api.php?action=isloggedin', 
    {
        method: 'GET', 
        credentials: 'include' 
    })
    .then(function(response) {
        if(response.status == 200) {
            response.json().then(function(body) { 
                if (body.loggedin == 'true') {
                    console.log("logged in");
                    showLoggedInMenuItems();
                    return;
                }
            }); 
        } 
        console.log("not logged in:"+response.status);
        showLoggedOutMenuItems();
        return;
    })
    .catch(error => console.log(error));
}

/**************************************************/
/* Other functions                                */ 
/**************************************************/
function clearMessageCheckURL() {
    document.getElementById("checkMessage").innerHTML = "";
}

function showSpinner(tab) {
    spinnerid = 'spinner'+tab; 
    document.getElementById(spinnerid).removeAttribute("hidden");
} 

function hideSpinner(tab) {
    spinnerid = 'spinner'+tab; 
    document.getElementById(spinnerid).setAttribute("hidden", "hidden");
} 
