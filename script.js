//



///////////////////////////// Collapse //////////////////////
function redBorder(id) { // activate red border w/ id
    let elem = document.getElementById(id);
    elem.removeAttribute("class");
    elem.setAttribute("class", "form-control border-danger");
}

function removeRedBorder(id) { // remove red border w/ id
    let elem = document.getElementById(id);
    elem.removeAttribute("class");
    elem.setAttribute("class", "form-control");
}

function showMsg(id) { // show collapse msg w/ id
    let elementCol = document.getElementById(id);
    let myCollapse = new bootstrap.Collapse(elementCol);

    myCollapse.show();
}

function hideMsg(id) { // hide collapsed messages
    let element = document.getElementById(id);
    let myCollapse = new bootstrap.Collapse(element);

    myCollapse.hide();
}

function fillAllFieldsLogin() {
    hideSpinner("mySpinner");
    redBorder("login-user");
    redBorder("login-password");
    if(!$('#user-collapse').is('.collapse.show')) {
            showMsg("user-collapse");
    }
    if(!$('#pass-collapse').is('.collapse.show')) {
        showMsg("pass-collapse");
    }
}

function clearAllFields() {
    removeRedBorder("login-user");
    removeRedBorder("login-password");
    // hideMsg("user-collapse");
    // hideMsg("pass-collapse");
}



//////////////////////////// log in ////////////////////////////////
function signUp() {
    $("#myModal").modal('hide');
    $("#myModal2").modal('show');
}

function showModal() {
    $(document).ready(function(){
        $("#myModal").modal('show');
    });
}

function checkResponse(data) {
    // console.log(data);
    switch (data) {
        case "userErr":
            hideSpinner("mySpinner");
            redBorder("login-user");
            showMsg("user-collapse");
            document.getElementById("btn-login").removeAttribute("disabled");
            // console.log("userErr");
        break;
        case "passErr":
            hideSpinner("mySpinner");
            redBorder("login-password");
            showMsg("pass-collapse");
            document.getElementById("btn-login").removeAttribute("disabled");
            // console.log("passErr");
        break;
        case "Successful":
            loginSuccessSweetAlert();
            document.getElementById("login-user").setAttribute("disabled", "");
            document.getElementById("login-password").setAttribute("disabled", "");
            document.getElementById("login-checkbox").setAttribute("disabled", "");
            document.getElementById("signup-link").setAttribute("style", "pointer-events: none;");
        break;
        case false:
            console.log("No response.");
        break;
    }
}

function loadUser() {
    let userIn = document.getElementById("login-user").value
    let passIn = document.getElementById("login-password").value

    const postParameters =  new URLSearchParams();
    postParameters.append("function", "login");
    postParameters.append("user", userIn);
    postParameters.append("password", passIn);

    $.ajax({
        url: "http://localhost:3000/final/request.php",
        type: "POST",
        data: postParameters.toString(),
        success: function(result) {
            const newResult = JSON.parse(result);
            checkResponse(newResult);
            // console.log(newResult);
        },
        error: function(xhr, status, error) {
            console.log("Error: " + error);
        },
    });
}

function showSpinner(id) {
    let spinner = document.getElementById(id);
    spinner.removeAttribute("hidden");
}
function hideSpinner(id) {
    let spinner = document.getElementById(id);
    spinner.setAttribute("hidden", "");
}

function logIn() {
    showSpinner("mySpinner");
    clearAllFields();
    if (document.getElementById("login-user").value == "" && document.getElementById("login-password").value == "") {
        fillAllFieldsLogin();
    } else {
        if($('#user-collapse').is('.collapse.show')) {
            showMsg("user-collapse");
        }
        if($('#pass-collapse').is('.collapse.show')) {
            showMsg("pass-collapse");
        }
        document.getElementById("btn-login").setAttribute("disabled", "");
        loadUser();
    }
}

function showPassword(id) {
    var elem = document.getElementById(id);
    if (elem.type === "password") {
        elem.type = "text";
    } else {
        elem.type = "password";
    }
}



//////////////// Sign up //////////////////////////////
function clearAllSignUpFields() {
    removeRedBorder("signup-firstName");
    removeRedBorder("signup-lastName");
    removeRedBorder("signup-mail");
    removeRedBorder("signup-username");
    removeRedBorder("signup-password");
}

function fillAllSignUp() {
    hideSpinner("mySpinner2");
    redBorder("signup-firstName");
    redBorder("signup-lastName");
    redBorder("signup-mail");
    redBorder("signup-username");
    redBorder("signup-password");
    if(!$('#fname-collapse').is('.collapse.show')) {
            showMsg("fname-collapse");
    }
    if(!$('#lname-collapse').is('.collapse.show')) {
        showMsg("lname-collapse");
    }
    if(!$('#email-collapse').is('.collapse.show')) {
            showMsg("email-collapse");
    }
    if(!$('#username-collapse').is('.collapse.show')) {
        showMsg("username-collapse");
    }
    if(!$('#pass2-collapse').is('.collapse.show')) {
        showMsg("pass2-collapse");
    }
}

function checkSignUpResponse(data) {
    // console.log(data);
    switch (data) {
        case "nameErr":
            hideSpinner("mySpinner2");
            redBorder("signup-firstName");
            showMsg("fname-collapse");
            document.getElementById("btn-signup").removeAttribute("disabled");
        break;
        case "surnameErr":
            hideSpinner("mySpinner2");
            redBorder("signup-lastName");
            showMsg("lname-collapse");
            document.getElementById("btn-signup").removeAttribute("disabled");
        break;
        case "emailErr":
            hideSpinner("mySpinner2");
            redBorder("signup-mail");
            showMsg("email-collapse");
            document.getElementById("btn-signup").removeAttribute("disabled");
        break;
        case "This E-mail is already in use.":
            hideSpinner("mySpinner2");
            redBorder("signup-mail");
            showMsg("email-collapse");
            document.getElementById("btn-signup").removeAttribute("disabled");
            errPopup(data);
        break;
        case "passErr":
            hideSpinner("mySpinner2");
            redBorder("signup-password");
            showMsg("pass2-collapse");
            document.getElementById("btn-signup").removeAttribute("disabled");
        break;
        case "userErr":
            hideSpinner("mySpinner2");
            redBorder("signup-username");
            showMsg("username-collapse");
            document.getElementById("btn-signup").removeAttribute("disabled");
        break;
        case "This username already exists.":
            hideSpinner("mySpinner2");
            redBorder("signup-username");
            showMsg("username-collapse");
            document.getElementById("btn-signup").removeAttribute("disabled");
            errPopup(data);
        break;
        case 1:
            loginSuccessSweetAlert();
            document.getElementById("signup-firstName").setAttribute("disabled", "");
            document.getElementById("signup-lastName").setAttribute("disabled", "");
            document.getElementById("signup-mail").setAttribute("disabled", "");
            document.getElementById("signup-username").setAttribute("disabled", "");
            document.getElementById("signup-password").setAttribute("disabled", "");
            document.getElementById("signup-checkbox").setAttribute("disabled", "");
            // document.getElementById("btn-back").setAttribute("style", "pointer-events: none;");
        break;
    }
}

function saveUser() {
    let fname = document.getElementById("signup-firstName").value
    let lname = document.getElementById("signup-lastName").value
    let email = document.getElementById("signup-mail").value
    let username = document.getElementById("signup-username").value
    let password = document.getElementById("signup-password").value

    const postParameters =  new URLSearchParams();
    postParameters.append("function", "signup");
    postParameters.append("firstName", fname);
    postParameters.append("lastName", lname);
    postParameters.append("email", email);
    postParameters.append("username", username);
    postParameters.append("password", password);

    $.ajax({
        url: "http://localhost:3000/final/request.php",
        type: "POST",
        data: postParameters.toString(),
        success: function(result) {
            const newResult = JSON.parse(result);
            checkSignUpResponse(newResult);
            // console.log(newResult);
        },
        error: function(xhr, status, error) {
            console.log("Error: " + error);
        },
    });
}

function signUpForm() {
    showSpinner("mySpinner2");
    clearAllSignUpFields();
    if (document.getElementById("signup-firstName").value == "" && document.getElementById("signup-lastName").value == "" && document.getElementById("signup-mail").value == "" && document.getElementById("signup-username").value == "" && document.getElementById("signup-password").value == "") {
        fillAllSignUp();
    } else {
        if($('#fname-collapse').is('.collapse.show')) {
            showMsg("fname-collapse");
        }
        if($('#lname-collapse').is('.collapse.show')) { 
            showMsg("lname-collapse");
        }
        if($('#email-collapse').is('.collapse.show')) { 
            showMsg("email-collapse");
        }
        if($('#username-collapse').is('.collapse.show')) {
            showMsg("username-collapse");
        }
        if($('#pass2-collapse').is('.collapse.show')) {
            showMsg("pass2-collapse");
        }
        document.getElementById("btn-signup").setAttribute("disabled", "");
        saveUser();
    }
}



///////////////// posts ///////////////////////////////
/**
 * fetches all rows for table
 */
function loadAllPosts() {
    $.ajax({
        url: 'http://localhost:3000/foundation_tasks/task(6)/request.php?type=all',
        success: function(data) {
            document.getElementById("content").replaceWith(createTableFromObjects(JSON.parse(data)));
        },
        error: function(xhr, status, error) {
            console.log("Error: " + error);
        }
    });
}


/**
 * 
 * @param {*} Row 
 * @param {string} id 
 * @returns 
 */
function createEditBtn(Row, id) {
    btnCell = document.createElement("button");
    btnCell.setAttribute("id", id);

    textBtn = document.createElement("span");
    textBtn.setAttribute("class", "material-symbols-outlined");
    textSpan = document.createTextNode("edit");
    textBtn.appendChild(textSpan);

    btnCell.appendChild(textBtn);
    btnCell.setAttribute("class", "btn btn-primary btn-sm rounded-pill");
    btnCell.setAttribute("data-toggle", "modal");
    btnCell.setAttribute("data-target", "#exampleModal");
    btnCell.setAttribute("onclick", "editOnclick(this.id)");
    Row.appendChild(btnCell);
    return Row;
}


/**
 * Create an edit button for createTableFromObjects() row
 * @param {*} Row
 * @param {string} id
 * @param {string} fname
 * @param {string} lname
 * @returns 
 */
function createDeleteBtn(Row, id, fname, lname) {
    personText = fname.concat(" ", lname);

    btnCell = document.createElement("button");
    btnCell.setAttribute("id", id);

    textBtn = document.createElement("span");
    textBtn.setAttribute("class", "material-symbols-outlined");
    textSpan = document.createTextNode("delete");
    textBtn.appendChild(textSpan);

    btnCell.appendChild(textBtn);
    att1 = document.createAttribute("class");
    att1.value = "btn btn-danger btn-sm rounded-pill";
    btnCell.setAttributeNode(att1);
    att2 = document.createAttribute("onclick");
    att2.value = "delSweetAlert(this.id, this.name)";
    btnCell.setAttributeNode(att2);
    btnCell.setAttribute("name", personText);
    Row.appendChild(btnCell);
    return Row;
}


/**
 * returns a table
 * @param {Array} data 
 * @returns 
 */
function createTableFromObjects(data) {
    table = document.createElement('table');
    table.setAttribute("id", "person");
    att = document.createAttribute("class");
    att.value = "table table-dark table-hover";
    table.setAttributeNode(att);
    tableBody = document.createElement('tbody');
    headerRow = document.createElement('tr');
    headerRow.setAttribute("id", "headerRow");

    // Create table data rows
    if (Array.isArray(data) && data.length) {
        keys = Object.keys(data[0]);
        keys = keys.slice(1);
        for (obj of data) {
            dataRow = document.createElement('tr');
            for (key of keys) {
                dataCell = document.createElement('td');
                dataCell.textContent = obj[key];
                dataRow.appendChild(dataCell);
            }
            dataCell = document.createElement('td');
            createEditBtn(dataCell, obj["ID"]);
            createDeleteBtn(dataCell, obj["ID"], obj["FirstName"], obj["LastName"]);
            dataRow.appendChild(dataCell);
            tableBody.appendChild(dataRow);
        }
    } else {
        dataRow = document.createElement('tr');
        dataCell = document.createElement('td');
        dataCell.textContent = "Empty";
        dataCell.setAttribute("colspan","6");
        dataRow.appendChild(dataCell);
        tableBody.appendChild(dataRow);
    }

    table.appendChild(tableBody);
    return table;
}



///////////////////////////// sweet alert //////////////////////////
function loginSuccessSweetAlert() {
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 2000,
        timerProgressBar: true,
        didOpen: (toast) => {
          toast.addEventListener('mouseenter', Swal.stopTimer)
          toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
      })
      
      Toast.fire({
        icon: 'success',
        title: 'Welcome!'
      })
}

function errPopup(msg) {
    text = "Sorry, ";
    newMsg = text.concat(msg);
    Swal.fire({
        icon: 'error',
        title: newMsg
      })
}