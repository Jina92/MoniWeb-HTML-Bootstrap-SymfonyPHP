var set_tab = 'home';  /* current tab */ 
var temp_elem; 

(function() {  /* self invoke function */
    "use strict";   /* strict javascript mode */ 
    
    var savedMode; 
    
    /* initialise the default active menu as Home */
    setMenuActive("home"); 

    // initialise the screen mode as the saved mode in localStorage.
    savedMode = localStorage.getItem("Dark")? 'Dark' : 'Light';
    setNavMode(savedMode);

    // Toggle the side navigation
    $("#sidebarToggle").on("click", function(e) {
        e.preventDefault();
        document.getElementsByTagName("BODY")[0].classList.toggle("sb-sidenav-toggled");
        // $("body").toggleClass("sb-sidenav-toggled");
    });
})();

function setMenuActive(selectedmenu) {
    var elements, tabelements;
    var elem;

    set_tab= selectedmenu; /* change the current tab */
    elements=document.querySelectorAll('a.nav-link');

    for (i = 0, len = elements.length; i < len; i++) {
        elem = elements[i];
        if (elem.id === set_tab) {  /* show where am i */
        elem.classList.add("active");
        }
        else {
            elem.classList.remove("active");
        }
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

function showTabToggle(event, selectedmenu) {
    /* This shows only the selected tab and toggles the side navigation  */
    /* This is implemented for navigation menus */ 
    
    event.preventDefault();
    
    setMenuActive(selectedmenu); 
    
    document.getElementsByTagName("BODY")[0].classList.toggle("sb-sidenav-toggled");
}

function showTab(event, selectedmenu) {
    /* This shows only the selected tab */ 
    /* This is implemeted for links in tabs */ 
    
    event.preventDefault();
    
    setMenuActive(selectedmenu);
}

function setNavMode(mode) {
    
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
    else {
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
    var toggleMode; 

    toggleMode = localStorage.getItem('Dark')?'Light':'Dark';
    setNavMode(toggleMode);
}



function clearMsg(msgDiv) {
    console.log("clear msg");
    document.getElementById(msgDiv).innerHTML = "";
}

function loginFetch(event) {
    console.log("step 0: login");
    event.preventDefault();
    var loginf = document.getElementById('loginForm');
    var formD = new FormData(loginf); 
    console.log("step 1: login");
    fetch('http://localhost/PROJ2/api/api.php?action=login', 
    {
        method: 'POST', 
        body: formD,   // send formData 
        credentials: 'include' // ??? 
    })
    .then(function(response) {
        console.log("step 2: login");
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
            // localStorage.setItem('csrf', body.Hash);
            localStorage.setItem('firstname', body.firstname);
            localStorage.setItem('theme', body.theme);
        }); 
        console.log("login success, status:"+response.status)
    })
    .catch(error => console.log(error));
}

function registerFetch(event) {
    event.preventDefault();   
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
    formD.append('csrf', localStorage.getItem('csrf'));
    
    fetch('http://localhost/PROJ2/api/api.php?action=register', 
    {
        method: 'POST', 
        body: formD,   // send formData 
        credentials: 'include' // ??? 
    })
    .then(function(response) {
        if(response.status == 400) {
            console.log('register failed');
            return;
        }
        if(response.status == 201) {
            console.log('registration completed');
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

// PUT: idempotent, POST: not idempotent
// How to guarantee PUT idempotent
function checkFetch(event) {
    event.preventDefault();
    fetch('http://localhost/PROJ2/api/api.php?action=check&url='+document.getElementById('inputURL').value, 
    {
        method: 'GET', 
        credentials: 'include' // ??? 
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
                switch(body) {
                    case 200: 
                    case 302: 
                        console.log("The site works well.");
                        break;
                    default: 
                        console.log("The site does not work.");
                        break;
                }
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
    var i=0;
    //event.target
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
        if(response.status == 403) { 
            console.log('You need to login');
            return;
        }
        
        if(response.status == 200) { // 200 OK 
            response.json().then(function(body) {
                // console.log(body.customerplanid);
                document.getElementById('planType').innerHTML = body.plantype +  " Plan";
                body.url.forEach(item => {
                    i++; 
                    document.getElementById('editURL'+i).value = item;
                });
                return ;
            }); 
            
            showTabToggle(event, 'myplan');
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
    //event.target
    event.preventDefault();
    var formD = new FormData();

    formD.append("email", hiddenEmail.value);

    fetch('http://localhost/PROJ2/api/api.php?action=getProfile', 
    {
        method: 'POST',
        body: formD,   // send formData  
        credentials: 'include' // ??? 
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
                editFirstName.value = body.firstname;
                editLastName.value = body.lastname;
                editEmail.value = body.email;
                editPhoneNo.value = body.phoneno;
                editAddress.value = body.address;
                editSuburb.value = body.suburb;
                editState.value = body.state;
                editPostcode.value = body.postcode;
            }); 
            
            showTab(event, 'editprofile')
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
    //event.target
    event.preventDefault();
    updateProfilef= document.getElementById('updateProfileForm')
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
            return;
        }
        if(response.status == 400) { 
            console.log('Error Occurred!!');
            return;
        }
    })
    .catch(error => console.log(error));

}

function editURLFetch(event) {
    var formD = new FormData(document.getElementById('editURLForm')); 
    var urlList;
    var i, numberofURL;

    
    event.preventDefault();   

    numberofURL = 5;
    /* generate a url list as a string type */
    for (i=1; i<=numberofURL; i++) {
        if (i==1) urlList = document.getElementById('editURL'+i).value;
        else urlList = urlList + "_"+document.getElementById('editURL'+i).value;
    }
    console.log(urlList);

    fetch('http://localhost/PROJ2/api/api.php?action=editURL&url='+urlList, 
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
            return;
            // response.json().then(function(body) {
            //     emailMsg.innerHTML = body;
            // });
        } 
        else {
            console.log("status:"+response.status);
        }
    })
    .catch(error => console.log(error));
}

function upgradePlanFetch(event, level) {
    event.preventDefault();  
    
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
            console.log("successfully upgraded to "+level);
            return;
        } else {
            console.log("status:"+response.status);
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
            return;
        } else {
            console.log("error status:"+response.status);
            return;
        }
    })
    .catch(error => console.log(error));
}




/* NAVIGATION: For the side navigation menu */ 
document.getElementById('home').addEventListener('click', function(e) { showTabToggle(e, 'home')});   
document.getElementById('search').addEventListener('click', function(e) { showTabToggle(e, 'search')});  
document.getElementById('check').addEventListener('click', function(e) { showTabToggle(e, 'home')});
document.getElementById('joinplan').addEventListener('click', function(e) { showTabToggle(e, 'joinplan')});  
document.getElementById('login').addEventListener('click', function(e) { showTabToggle(e, 'login')});
document.getElementById('register').addEventListener('click', function(e) { showTabToggle(e, 'register')}); 
document.getElementById('setting').addEventListener('click', function(e) { showTabToggle(e, 'setting')}); 
document.getElementById('myplan').addEventListener('click', function(e) { showMyPlanFetch(e)}); // it also calls showTab()
document.getElementById('logout').addEventListener('click', function(e) { logoutFetch(e)}); // it also calls showTab()

/* My Plan tab */ 


document.getElementById('upgradeButton').addEventListener('click', function(e) { showTab(e, 'upgradeplan')});

/*  Upgrade Plan tab */ 
document.getElementById('upgradeStandardButton').addEventListener('click', function(e) { upgradePlanFetch(e, 'Standard')});
document.getElementById('upgradePremiumButton').addEventListener('click', function(e) { upgradePlanFetch(e, 'Premium')});


/* Setting tab: For forms and links of the setting tab */
document.getElementById('editprofile').addEventListener('click', function(e) { showProfileFetch(e)});   
document.getElementById('changepassword').addEventListener('click', function(e) { showTab(e, 'changepassword')});
document.getElementById('changemode').addEventListener('click', function(e) { toggleNavMode(e)}); 
document.getElementById('updateProfileForm').addEventListener('submit', function(e) { updateProfileFetch(e)});
/* JoinPlan tab: For links of the join plan tab */
document.getElementById('registerForJoinFree').addEventListener('click', function(e) { showTab(e, 'register')});
document.getElementById('registerForJoinStandard').addEventListener('click', function(e) { showTab(e, 'register')});  
document.getElementById('registerForJoinPremium').addEventListener('click', function(e) { showTab(e, 'register')}); 
/* User Register tab: For forms of the register tab */
document.getElementById('registerForm').addEventListener('submit', function(e) { registerFetch(e)});
document.getElementById('loginForm').addEventListener('submit', function(e) { loginFetch(e)});
document.getElementById('checkForm').addEventListener('submit', function(e) { checkFetch(e)});
/* Website URL Register tab: links of the registerURL tab */
document.getElementById('editURLForm').addEventListener('submit', function(e) { editURLFetch(e)});




