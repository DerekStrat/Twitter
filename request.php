<?php
include('login_person.php');

if (isset($_GET["type"])) {
    echo json_encode("get method");
}

if (isset($_POST["function"])) {
    $UserObj = new LogIn();
    switch($_POST["function"]) {
        case "login":
            $ResultObj = $UserObj->checkLogin($_POST["user"], $_POST["password"]);
            echo json_encode($ResultObj);
        break;
        case "signup":
            $ResultObj = $UserObj->checkSignUp($_POST["firstName"], $_POST["lastName"], $_POST["email"], $_POST["username"], $_POST["password"]);
            echo json_encode($ResultObj);
        break;
    }
}

?>