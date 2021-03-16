var set_tab = 'home';  /* current tab */ 
var temp_elem; 

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

function clearMsg(msgDiv) {
    console.log("clear msg");
    document.getElementById(msgDiv).innerHTML = "";
}

function registerFetch(event) {
    console.log("step 1");
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
    console.log("step 2");
    // console.log('firstname', inputFirstName.value);
    // console.log('lastname', inputLastName.value);
    // console.log('email', inputEmail.value);
    // console.log('password', inputPassword.value);
    // console.log('confirmpassword', inputConfirmPassword.value);
    // console.log('phoneno', inputPhoneNo.value);
    // console.log('address', inputAddress.value);
    // console.log('suburb', inputSuburb.value);
    // console.log('state', inputState.value);
    // console.log('postcode', inputState.value);
    
    fetch('http://localhost/PROJ2/api/api.php?action=register', 
    {
        method: 'POST', 
        body: formD,   // send formData 
        credentials: 'include' // ??? 
    })
    .then(function(response) {
        console.log("step 3");
        if(response.status == 400) {
            console.log('register failed');
            return;
        }
        if(response.status == 201) {
            console.log('registration completed');
            return;
        }
        if(response.status == 200) {
            response.json().then(function(body) {
                emailMsg.innerHTML = body;
                console.log(body);
            });
        }
        console.log("status:"+response.status)
    })
    .catch(error => console.log(error));
}

function registerFetch(event) {
    console.log("step 1");
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
    console.log("step 2");
    // console.log('firstname', inputFirstName.value);
    // console.log('lastname', inputLastName.value);
    // console.log('email', inputEmail.value);
    // console.log('password', inputPassword.value);
    // console.log('confirmpassword', inputConfirmPassword.value);
    // console.log('phoneno', inputPhoneNo.value);
    // console.log('address', inputAddress.value);
    // console.log('suburb', inputSuburb.value);
    // console.log('state', inputState.value);
    // console.log('postcode', inputState.value);
    
    fetch('http://localhost/PROJ2/api/api.php?action=register', 
    {
        method: 'POST', 
        body: formD,   // send formData 
        credentials: 'include' // ??? 
    })
    .then(function(response) {
        console.log("step 3");
        if(response.status == 400) {
            console.log('register failed');
            return;
        }
        if(response.status == 201) {
            console.log('registration completed');
            return;
        }
        if(response.status == 200) {
            response.json().then(function(body) {
                emailMsg.innerHTML = body;
            });
        }
        console.log("status:"+response.status)
    })
    .catch(error => console.log(error));
}
/* add event listeners to the navigation menu */ 
document.getElementById('home').addEventListener('click', function(e) { showTabToggle(e, 'home')});   
document.getElementById('search').addEventListener('click', function(e) { showTabToggle(e, 'search')});  
document.getElementById('check').addEventListener('click', function(e) { showTabToggle(e, 'check')});
document.getElementById('joinplan').addEventListener('click', function(e) { showTabToggle(e, 'joinplan')});  
document.getElementById('login').addEventListener('click', function(e) { showTabToggle(e, 'login')});
document.getElementById('register').addEventListener('click', function(e) { showTabToggle(e, 'register')}); 
document.getElementById('setting').addEventListener('click', function(e) { showTabToggle(e, 'setting')});  
/* add event listeners to links of the setting tab */
document.getElementById('editprofile').addEventListener('click', function(e) { showTab(e, 'editprofile')});   
document.getElementById('changepassword').addEventListener('click', function(e) { showTab(e, 'changepassword')});
document.getElementById('changemode').addEventListener('click', function(e) { toggleNavMode(e)}); 
/* add event listeners to links of the register tab */
//document.getElementById('registerAccountButton').addEventListener('submit', function(e) { registerFetch(e)}); // doesn't work
document.getElementById('registerForm').addEventListener('submit', function(e) { registerFetch(e)});
document.getElementById('loginForm').addEventListener('submit', function(e) { loginFetch(e)});



