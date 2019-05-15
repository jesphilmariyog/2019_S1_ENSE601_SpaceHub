function onloadInit() {
    init();
    render();
}

function init() {
    gapi.load("auth2", function() {
        auth2 = gapi.auth2.init({
            client_id: "804162525436-8o6ih6qhd45vt7u7haud9ijs2ulhh2b4.apps.googleusercontent.com",
            cookiepolicy: "single_host_origin"
        });
    });
}

/*function attachSignIn(element) {
    auth2.attachClientHandler(element, {},
        function() {

        })
}*/

function signIn(user) {
    var profile = user.getBasicProfile(); // XXX Test
    console.log(profile.getId() + "\n" + profile.getName() + "\n" + profile.getEmail());
    /*document.getElementById("profile").innerHTML = profile.getId() +
        "<br>Full Name: " + profile.getName() +
        '<br><img src="' + profile.getImageUrl() + '">'
        "<br>Email: " + profile.getEmail();*/
    
    removeElement("sign-in");
    var loginButton = addElement("login-item", "a", "sign-out")
    loginButton.innerHTML = "Sign Out";
    loginButton.setAttribute("href", "#");
    loginButton.setAttribute("onclick", "signOut();");
}

function signOut() {
    gapi.auth2.getAuthInstance().disconnect().then(function() {
        console.log("User signed out.");
        /*document.getElementById("profile").innerHTML = ""; // XXX Test*/
        
        removeElement("sign-out");
        addElement("login-item", "div", "sign-in");
        render();
    }).catch(function(error) {
        console.log(error);
    });
}

function render() {
    gapi.signin2.render("sign-in", {
        'scope': "profile email",
        /*'width': 240,
        'height': 50,
        'longtitle': true,*/
        'onsuccess': signIn,
        'onfailure': function(error) {
            console.log(error);
        }
    });
}

function addElement(parentId, elementTag, elementId) {
    var parent = document.getElementById(parentId);
    var element = document.createElement(elementTag);
    element.setAttribute("id", elementId);
    parent.appendChild(element);
    return element;
}

function removeElement(elementId) {
    var element = document.getElementById(elementId);
    element.parentNode.removeChild(element);
}