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

function render() {
    gapi.signin2.render("sign-in", {
        'scope': "profile email",
        'onsuccess': signIn,
        'onfailure': function(error) {
            console.log(error); // TODO need better error handling.
        }
    });
}

function signIn(user) {
    var id_token = user.getAuthResponse().id_token;
    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'authorise_user.php'); // I think that the URL in this sense means to which file we want to send the data.
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.send('idtoken=' + id_token);
    
    removeElement("sign-in");
    var logoutButton = addElement("login-item", "a", "sign-out")
    logoutButton.innerHTML = "Sign Out";
    logoutButton.setAttribute("href", "#");
    logoutButton.setAttribute("onclick", "signOut();");
    logoutButton.parentNode.setAttribute("action", "remove_session.php");
    logoutButton.parentNode.removeAttribute("method");
}

function signOut() {
    gapi.auth2.getAuthInstance().disconnect().then(function() {
        console.log("User signed out.");
        
        var xhr = new XMLHttpRequest();
        xhr.open('GET', 'remove_session.php', true);
        xhr.send();

        removeElement("sign-out");
        var loginButton = addElement("login-item", "div", "sign-in");
        loginButton.parentNode.setAttribute("action", "authorise_user.php");
        loginButton.parentNode.setAttribute("method", "post");
        render();
    }).catch(function(error) {
        console.log(error); // TODO need better error handling.
    });
}

function addElement(parentId, elementTag, elementId) {
    var element = document.createElement(elementTag);
    element.setAttribute("id", elementId);
    var parent = document.getElementById(parentId);
    parent.appendChild(element);
    return element;
}

function removeElement(elementId) {
    var element = document.getElementById(elementId);
    element.parentNode.removeChild(element);
}