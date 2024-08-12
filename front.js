

var selected_doc = 0;
var selected_list = 'highlight';
var doc_type = 0;

document.addEventListener("DOMContentLoaded", function () {
    document.getElementById('login_button').addEventListener('click', function (event) {
        submit_login(event);
    }, false);

    document.getElementById('req_button').addEventListener('click', function (event) {
        request_password(event);
    }, false);

    document.getElementById('closereq').addEventListener('click', function (event) {
        show_sign_menu(event, 'reqpwd', 320);
    }, false);
});
var submit_login = function (ev) {
    ev.preventDefault();
    var xhr = new XMLHttpRequest();
    var formElement = document.getElementById('signinform');
    var formData = new FormData(formElement);

    xhr.open('post', 'do_login.php');
    xhr.responseType = 'json';
    xhr.send(formData);
    xhr.onreadystatechange = function () {
        var DONE = 4; // readyState 4 means the request is done.
        var OK = 200; // status 200 is a successful return.
        if (xhr.readyState === DONE) {
            if (xhr.response.status !== 'ok') {
                j_alert("error", xhr.response.message);
                return false;
            }
            if (xhr.status === OK) {
                document.location.href = 'welcome.php';
            }
        }
    }
};

var request_password = function(){
    var mail = document.getElementById('my-email').value;

    var url = "password_manager.php";

    var xhr = new XMLHttpRequest();
    var formData = new FormData();

    xhr.open('post', 'password_manager.php');
    var action = 'sendmail';

    formData.append('email', mail);
    formData.append('action', action);
    xhr.responseType = 'json';
    xhr.send(formData);
    xhr.onreadystatechange = function () {
        var DONE = 4; // readyState 4 means the request is done.
        var OK = 200; // status 200 is a successful return.
        if (xhr.readyState === DONE) {
            if (xhr.status === OK) {
                if (xhr.response.status === 'ok') {
                    j_alert('alert', xhr.response.message);
                }
                else if (xhr.response.status === "nomail" || xhr.response.status === "olduser") {
                    j_alert("error", xhr.response.message);
                }
                else if (xhr.response.status === "kosql") {
                    j_alert("error", xhr.response.message);
                }
                fade('reqpwd', 'out', 200, 0);
            }
        } else {
            console.log('Error: ' + xhr.status);
        }
    }
};
