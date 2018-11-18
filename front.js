window.mdc.autoInit();
mdc.textField.MDCTextField.attachTo(document.querySelector('.mdc-text-field'));

var selected_doc = 0;
var selected_list = 'highlight';
var doc_type = 0;

document.addEventListener("DOMContentLoaded", function () {
    if (is_mobile) {
        document.getElementById('open_drawer').addEventListener('click', function () {
            toggle_mobile_drawer();
        }, false);
    }
    else {
        document.getElementById('open_drawer').addEventListener('click', function () {
            toggle_fixed_drawer();
        }, false);
    }

    document.getElementById('login_button').addEventListener('click', function (event) {
        submit_login(event);
    }, false);

    document.getElementById('signup_button').addEventListener('click', function (event) {
        signup(event);
    }, false);

    document.getElementById('req_button').addEventListener('click', function (event) {
        request_password(event);
    }, false);

    document.getElementById('closereq').addEventListener('click', function (event) {
        show_sign_menu(event, 'reqpwd', 320);
    }, false);

    document.getElementById('newpwd').addEventListener('click', function (event) {
        fade('login', 'out', 200, 0);
        show_sign_menu(event, 'reqpwd', 320);
    }, false);
    document.getElementById('content').addEventListener('contextmenu', function (ev) {
        ev.preventDefault();
        clear_context_menu(ev, 'doc_context_menu');
        if (selected_doc !== 0) {
            if (selected_list === 'highlight') {
                document.getElementById('item'+selected_doc).classList.remove('selected_doc');
            }
            else {
                document.getElementById('sbitem'+selected_doc).classList.remove('selected_doc');
            }
        }
        return false;
    });
    document.getElementById('content').addEventListener('click', function (ev) {
        ev.preventDefault();
        clear_context_menu(ev, 'doc_context_menu');
        if (selected_doc !== 0) {
            if (selected_list === 'highlight') {
                document.getElementById('item'+selected_doc).classList.remove('selected_doc');
            }
            else {
                document.getElementById('sbitem'+selected_doc).classList.remove('selected_doc');
            }
        }
        return false;
    });
    document.getElementById('show_doc').addEventListener('click', function (ev) {
        clear_context_menu(ev, 'doc_context_menu');
        getFileName(selected_doc, 'open_in_browser', '');
    });
    document.getElementById('down_doc').addEventListener('click', download_item);
    document.getElementById('det_doc').addEventListener('click', function (ev) {
        clear_context_menu(ev, 'doc_context_menu');
        document.location.href = 'document_info.php?did='+selected_doc+'&req=info&back=index.php';
    });
    document.getElementById('stat_doc').addEventListener('click', function (ev) {
        clear_context_menu(ev, 'doc_context_menu');
        document.location.href = 'document_info.php?did='+selected_doc+'&req=stats&back=index.php';
    });
    var ends = document.querySelectorAll('.file-card');
    for (i = 0; i < ends.length; i++) {
        ends[i].addEventListener('click', function (event) {
            event.preventDefault();
            event.stopImmediatePropagation();
            clear_context_menu(event, 'doc_context_menu');
            if (selected_doc !== 0) {
                if (selected_list === 'highlight') {
                    document.getElementById('item'+selected_doc).classList.remove('selected_doc');
                }
                else {
                    document.getElementById('sbitem'+selected_doc).classList.remove('selected_doc');
                }
            }
            event.currentTarget.classList.add('selected_doc');
            selected_doc = event.currentTarget.getAttribute("data-id");
            selected_list = event.currentTarget.getAttribute("data-list");
        });
        ends[i].addEventListener('contextmenu', function (event) {
            event.preventDefault();
            event.stopImmediatePropagation();
            if (selected_doc !== 0) {
                if (selected_list === 'highlight') {
                    document.getElementById('item'+selected_doc).classList.remove('selected_doc');
                }
                else {
                    document.getElementById('sbitem'+selected_doc).classList.remove('selected_doc');
                }
            }
            event.currentTarget.classList.add('selected_doc');
            current_target_id = event.currentTarget.getAttribute("data-id");
            current_target_list = event.currentTarget.getAttribute("data-list");
            doc_type = event.currentTarget.getAttribute("data-type");
            if (doc_type === '2') {
                document.getElementById('down_doc').classList.add('disabled_menu_item');
                document.getElementById('down_doc').removeEventListener('click', download_item);
                document.getElementById('down_doc').addEventListener('click', do_nothing);
            }
            else {
                document.getElementById('down_doc').classList.remove('disabled_menu_item');
                document.getElementById('down_doc').removeEventListener('click', do_nothing);
                document.getElementById('down_doc').addEventListener('click', download_item);
            }
            show_context_menu(event, null, 0, 'doc_context_menu');
            selected_doc = event.currentTarget.getAttribute("data-id");
            selected_list = current_target_list;
        });
    }

    var collapsables = document.querySelectorAll('.collapsable');
    for (i = 0; i < collapsables.length; i++) {
        collapsables[i].addEventListener('click', function (event) {
            var element = document.getElementById(event.currentTarget.getAttribute("data-collapse"));
            if (element.style.display !== 'block') {
                element.style.opacity = 0;
                element.style.display = 'block';
                fade(event.currentTarget.getAttribute("data-collapse"), 'in', 400, 1);
                event.currentTarget.innerText = 'arrow_drop_up';
            }
            else {
                element.style.display = 'none';
                event.currentTarget.innerText = 'arrow_drop_down';
            }

            //element.style.display = 'block';
        });
    }
});

var download_item = function (ev) {
    clear_context_menu(ev, 'doc_context_menu');
    if (selected_list === 'highlight') {
        document.getElementById('item'+selected_doc).classList.remove('selected_doc');
    }
    else {
        document.getElementById('sbitem'+selected_doc).classList.remove('selected_doc');
    }
    document.location.href = 'share/download_manager.php?register=1&did='+selected_doc;
};

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
                alert(xhr.response.status);
                j_alert("error", xhr.response.message);
                return false;
            }
            if (xhr.status === OK) {
                if (xhr.response.role == 3) {
                    //document.location.href = 'admin/index.php';
                }
                var div = document.getElementById('sc_secondrow');
                div.innerHTML = '<i class="material-icons" style="position: relative; top: 1px">person</i>\n' +
                    '<span style="position: relative; margin-left: 5px; bottom: 5px">\n' +
                    '                <a href="#" onclick="show_user_menu(event, \'access_menu\', 200)">\n' + xhr.response.name +
                    '                    <i id="arrow" class="material-icons" style="position: relative; top: 8px">arrow_drop_down</i>\n' +
                    '                </a>\n' +
                    '            </span>\n';
                fade('login', 'out', 500, 0);
                document.getElementById('user_space').style.display = 'block';
                if (xhr.response.role == 3) {
                    var first_a = document.getElementById('access_menu').querySelector('a');
                    first_a.setAttribute('href', 'admin/index.php');
                }
            }
        }
    }
};

var signup = function (ev) {
    ev.preventDefault();
    var xhr = new XMLHttpRequest();
    var formElement = document.getElementById('signupform');
    var formData = new FormData(formElement);

    xhr.open('post', 'do_signup.php');
    xhr.responseType = 'json';
    xhr.send(formData);
    xhr.onreadystatechange = function () {
        var DONE = 4; // readyState 4 means the request is done.
        var OK = 200; // status 200 is a successful return.
        if (xhr.readyState === DONE) {
            if (xhr.response.status !== 'ok') {
                alert(xhr.response.status);
                j_alert("error", xhr.response.message);
                return false;
            }
            if (xhr.status === OK) {
                var div = document.getElementById('sc_secondrow');
                div.innerHTML = '<i class="material-icons" style="position: relative; top: 1px">person</i>\n' +
                    '<span style="position: relative; margin-left: 5px; bottom: 5px">\n' +
                    '                <a href="#" onclick="show_user_menu(event, \'access_menu\', 200)">\n' + xhr.response.name +
                    '                    <i id="arrow" class="material-icons" style="position: relative; top: 8px">arrow_drop_down</i>\n' +
                    '                </a>\n' +
                    '            </span>\n';
                fade('login', 'out', 500, 0);
                document.getElementById('user_space').style.display = 'block';

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
