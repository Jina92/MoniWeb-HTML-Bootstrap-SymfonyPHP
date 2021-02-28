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

(function() {  /* self invoke function */
    "use strict";   /* strict javascript mode */ 

    setMenuActive("home"); 
    // Toggle the side navigation
    $("#sidebarToggle").on("click", function(e) {
        e.preventDefault();
        $("body").toggleClass("sb-sidenav-toggled");
    });
})();

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