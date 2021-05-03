var set_tab = 'home';  /* current tab */ 
var temp_elem; 

/**************************************************/
/* initialise the screen for the first connection */ 
/**************************************************/
(function() {  /* self invoke function */
    "use strict";   /* strict javascript mode */ 
    
    var savedMode; 

    console.log("start");
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

        // version 2 
        // $("#sidebarToggle").on("click", function(e) {
        //     e.preventDefault();
        //     document.getElementsByTagName("BODY")[0].classList.toggle("sb-sidenav-toggled");
        // });

        // version 1 
        // $("body").toggleClass("sb-sidenav-toggled");

    document.getElementById('search').addEventListener('click', function(e) { 
        // console.log("event listener Search");
        // document.getElementsByTagName("BODY")[0].classList.remove("sb-sidenav-toggled"); // remove the sidebar menu 
        showTabHideMenu(e, 'search')
    });  
    
})();

//window.addEventListener('load', function(e) { console.log("load"); checkLoggedInFetch(e)});

/**************************************************/
/* functions for the Navigation sidebar           */ 
/**************************************************/

function setMenuActive(selectedmenu) {
    var elements, tabelements;
    var elem;

    set_tab= selectedmenu; /* change the current tab */
    elements=document.querySelectorAll('a.nav-link');

    for (i = 0, len = elements.length; i < len; i++) {
        elem = elements[i];
        if (elem.id === set_tab)   /* show where am I */
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
    changeMode = document.getElementById("changemode");
    
    if (mode == 'Light') {
        
        /* remove */ 
        localStorage.removeItem('Dark'); 
        navElem.classList.remove('navbar-dark'); /* top menu */ 
        navElem.classList.remove('bg-dark');
        navvarElem.classList.remove('sb-sidenav-dark'); /* side bar */ 
        navvarElem.classList.remove('bg-dark'); 
        changeMode.classList.remove('btn-dark');  /* setting: 'change mode' icon */
        changeMode.classList.remove('text-white'); 
        
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
        changeMode.classList.add('btn-dark');  /* setting: 'change mode' icon */
        changeMode.classList.add('text-white'); 
    }
}

function toggleNavMode(event) {
    var toggledTheme; 

    toggledTheme = (localStorage.getItem('theme') == 'Dark')?'Light':'Dark';
    setTheme(toggledTheme);
}


// function createMenu() {
//     var menuField = new array();

//     var container = document.getElementById("sidenavContainer"); 
//     while (container.hasChildNodes()) {
//         container.removeChild(container.lastChild);
//     }
//     // id, class, href 
//     menuField.push(new array('myplan', 'nav-link', '#myplantab'));
//     <a id="myplan" class="nav-link" href="#myplantab" hidden="hidden">My Plan</a>
//     var menu = document.createElement("A");
//     menu.id = "myplan";
//     input.name = "member" + i;
//     container.appendChild(input);
    
//     container.appendChild(document.createElement("br"));
// }

function addLoggedOutEventListener() {

/* Common of logged in and logged out *************************************************************************/
/* However these are duplicate because the event listener also is reset when a menu is reset  *****************/
    /* NAVIGATION: For the side navigation menu */ 
    document.getElementById('home').addEventListener('click', function(e) { showTabHideMenu(e, 'home')});   
    // document.getElementById('check').addEventListener('click', function(e) { showTabHideMenu(e, 'home')});
    /* home tab */ 
    //document.getElementById('inputURL').addEventListener('click', function(e) { clearMessage('checkMessage'); resetSpinner();});  // clearMessage and reset spinner
    document.getElementById('inputURL').addEventListener('click', function(e) { clearMessage('checkMessage');});

/* unique of logged out *************************************************************************/ 
    /* NAVIGATION: For the side navigation menu */ 
    document.getElementById('joinplan').addEventListener('click', function(e) { showTabHideMenu(e, 'joinplan')});  
    document.getElementById('login').addEventListener('click', function(e) { showTabHideMenu(e, 'login')});
    document.getElementById('register').addEventListener('click', function(e) { showTabHideMenu(e, 'register')}); 

    /* JoinPlan tab: For links of the join plan tab */
    document.getElementById('registerForJoinFree').addEventListener('click', function(e) { showTab(e, 'register')});
    document.getElementById('registerForJoinStandard').addEventListener('click', function(e) { showTab(e, 'register')});  
    document.getElementById('registerForJoinPremium').addEventListener('click', function(e) { showTab(e, 'register')}); 

    /* User Register tab: For forms of the register tab */
    document.getElementById('registerForm').addEventListener('submit', function(e) { registerFetch(e)});
    //document.getElementById('registerButton').addEventListener('click', function(e) { registerFetch(e)});
    document.getElementById('loginForm').addEventListener('submit', function(e) { loginFetch(e)});
    document.getElementById('checkForm').addEventListener('submit', function(e) { checkFetch(e)});
}

function addLoggedInEventLister() {

/* Common of logged in and logged out *************************************************************************/
/* However these are duplicate because the event listener also is reset when a menu is reset  *****************/
    /* NAVIGATION: For the side navigation menu */ 
    document.getElementById('home').addEventListener('click', function(e) { showTabHideMenu(e, 'home')});   
    // document.getElementById('check').addEventListener('click', function(e) { showTabHideMenu(e, 'home')});
    /* home tab */ 
    document.getElementById('inputURL').addEventListener('click', function(e) { clearMessage('checkMessage')});

/* unique of logged out *************************************************************************/  
    /* NAVIGATION: For the side navigation menu */ 
    document.getElementById('setting').addEventListener('click', function(e) { showTabHideMenu(e, 'setting')}); 
    document.getElementById('myplan').addEventListener('click', function(e) { showMyPlanFetch(e)}); // it also calls showTab()
    document.getElementById('logout').addEventListener('click', function(e) { logoutFetch(e)}); // it also calls showTab()

    /* My Plan tab */ 
    document.getElementById('upgradeButton').addEventListener('click', function(e) { showTab(e, 'upgradeplan')});

    /*  Upgrade Plan tab */ 
    document.getElementById('upgradeStandardButton').addEventListener('click', function(e) { upgradePlanFetch(e, 'Standard')});
    document.getElementById('upgradePremiumButton').addEventListener('click', function(e) { upgradePlanFetch(e, 'Premium')});

    /* Setting tab: For forms and links of the setting tab */
    document.getElementById('updateprofile').addEventListener('click', function(e) { showProfileFetch(e)});   
    document.getElementById('changepassword').addEventListener('click', function(e) { showTab(e, 'changepassword')});
    document.getElementById('changemode').addEventListener('click', function(e) { toggleNavMode(e)}); 
    document.getElementById('updateProfileForm').addEventListener('submit', function(e) { updateProfileFetch(e)});
    document.getElementById('changePasswordForm').addEventListener('submit', function(e) { changePasswordFetch(e)});

    /* Website URL Register tab: links of the registerURL tab */
    document.getElementById('updateURLForm').addEventListener('submit', function(e) { updateURLFetch(e)});
}

function showLoggedOutMenuItems() {
    document.getElementById("sidenavContainer").innerHTML = `
    <a id="home" class="nav-link" href="#hometab"><i class="fas fa-home mr-1"></i> Home</a>
    <a id="joinplan" class="nav-link" href="#joinplantab"><i class="far fa-handshake mr-1"></i> Join a Plan</a>
    <a id="login" class="nav-link" href="#logintab"><i class="fas fa-sign-in-alt mr-1"></i> Login</a>
    <a id="register" class="nav-link" href="#registertab"><i class="fas fa-registered mr-1"></i> Register</a>
    `; 

    // <a id="check" class="nav-link" href="#hometab"><i class="fas fa-check-square mr-1"></i> Check a Website</a> 
    
    addLoggedOutEventListener();
}

function showLoggedInMenuItems() {
    document.getElementById("sidenavContainer").innerHTML = `
    <a id="home" class="nav-link" href="#hometab"><i class="fas fa-home mr-1"></i> Home </a>
    <a id="myplan" class="nav-link" href="#myplantab"><i class="fas fa-poll-h mr-1"></i> <div>My Plan</div></a>
    <a id="setting" class="nav-link" href="#settingtab"><i class="fas fa-cog mr-1"></i> Setting</a>
    <a id="check" class="nav-link" href="#hometab"><i class="fas fa-check-square mr-1"></i> Check a Website</a>    
    <a id="logout" class="nav-link" href="#logout"><i class="fas fa-sign-out-alt mr-1"></i> Logout</a>
    `;

    addLoggedInEventLister();
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

    showSpinner();
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
        hideSpinner();
        if(response.status == 401) {
            console.log('login failed');
            // you need to clean localStorage.
            //localStorage.removeItem('csrf');
            return;
        }
        if(response.status == 203) {
            console.log('registration required');
            return;
        }
        if(response.status == 400) {
            console.log('Sorry. System Error occurs.\n Please contact to MoniWeb Administration');
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
        //console.log(document.getElementById('messageModal').getAttribute('aria-hidden'));
    })
    .catch(error => console.log(error));
}

function registerFetch(event) {
/* register a user account */ 

    showSpinner();
    event.preventDefault();   

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
        hideSpinner();
        if(response.status == 400) {
            console.log('register failed');
            return;
        }
        if(response.status == 201) {
            console.log('registration completed');
            $('#messageModal').modal('show');
            document.getElementById('messageModal-body').innerHTML = "Registration Success";
            return;
        }
        if(response.status == 200) { // Succcess but Error could have been set. 
            response.json().then(function(body) {
                emailMsg.innerHTML = body;
            });
        }
        console.log("status:"+response.status)

    })
    .catch(error => console.log(error));
}


function checkFetch(event) {
/* Check a given IP address work */ 
/* PUT: idempotent, POST: not idempotent */ 

    showSpinner();
    event.preventDefault();
    fetch('http://localhost/PROJ2/api/api.php?action=check&url='+document.getElementById('inputURL').value, 
    {
        method: 'GET', 
        credentials: 'include' 
    })
    .then(function(response) {
        hideSpinner();
        
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

    showSpinner();
    event.preventDefault();
    
    fetch('http://localhost/PROJ2/api/api.php?action=myplan', 
    {
        method: 'GET',
        credentials: 'include' 
    })
    .then(function(response) {
        hideSpinner();
        if(response.status == 404) { // 404 Not Found
            console.log('URL is not found');
            return;
        }
        if(response.status == 403) { 
            console.log('You need to login');
            return;
        }
        
        if(response.status == 200) { // 200 OK 
            response.json().then(function(body) {
                // console.log(body.customerplanid);
                document.getElementById('planType').innerHTML = body.plantype + " Plan";
                body.url.forEach(item => {
                    i++; 
                    document.getElementById('updateURL'+i).value = item;
                });
                return ;
            }); 
            
            showTabHideMenu(event, 'myplan');
            console.log("success");
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

    showSpinner();
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
        hideSpinner();
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

    showSpinner();
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
        hideSpinner();
        if(response.status == 404) { // 404 Not Found
            console.log('URL is not found');
            // you need to clean localStorage.
            //localStorage.removeItem('csrf');
            return;
        }
        if(response.status == 200) { // 200 OK 
            console.log("profile updated");
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

    showSpinner();
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
        hideSpinner();
        if(response.status == 400) {
            console.log('register failed');
            return;
        }
        if(response.status == 200) {
            console.log("successfully updated");
            return;
        } 
        else {
            console.log("status:"+response.status);
        }
    })
    .catch(error => console.log(error));
}

function upgradePlanFetch(event, level) {
/* Upgrade the user's plan to the higher, premium plan */

    showSpinner();
    event.preventDefault();  
    
    fetch('http://localhost/PROJ2/api/api.php?action=upgrade&level='+level, 
    {
        method: 'GET', 
        credentials: 'include' 
    })
    .then(function(response) {
        hideSpinner();
        if(response.status == 400) {
            console.log('upgrade failed');
            return;
        }
        if(response.status == 200) {
            console.log("successfully upgraded to "+level);
            return;
        } else {
            console.log("status:"+response.status);
        }
    })
    .catch(error => console.log(error));
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
            console.log("Password updated");
            return;
        }
        if(response.status == 400) { 
            console.log('Error Occurred!!');
            return;
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
            console.log("in checkLoggedInFetch");
            response.json().then(function(body) { 
                console.log(body.loggedin);
                if (body.loggedin == 'true') {
                    console.log("It is logged in");
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
function clearMessage(messageId) {
    document.getElementById(messageId).innerHTML = "";
}

function showSpinner() {
    console.log("show Spinner");
    document.getElementById('spinner').removeAttribute("hidden");
} 

function hideSpinner() {
    console.log("hide Spinner");
    document.getElementById('spinner').setAttribute("hidden", "hidden");
} 
