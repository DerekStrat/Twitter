<?php
// We need to use sessions, so you should always start sessions using the below code.
session_start();
// If the user is not logged in redirect to the login page...
if (!isset($_SESSION['loggedin'])) {
	header('Location: login.html');
	exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Sweet Alert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" id="theme-styles">
    <!-- end -->

    <!-- <script src="script.js"></script> -->

    <title>Home Page</title>

    <style>
    .material-symbols-outlined {
        vertical-align: top;
    }
    </style>
</head>
<body>
<!-- Left Side Panel -->
    <div class="container-fluid bg-dark">
        <div class="row justify-content-md-center">

            <div class="col-auto py-3 col-md-3 col-xl-2 px-sm-2 text-light bg-dark border-end">
                <div class="d-flex flex-column align-items-center align-items-sm-start px-3 pt-2 text-white min-vh-100">
                    <a href="/" class="h-25 d-flex align-items-center pb-3 mb-md-0 me-md-auto text-white text-decoration-none">
                        <span class="fs-5 d-none d-lg-block"><i class="fab fa-twitter"></i></span>
                    </a>
                    
                    <h2 class="p-2 text-white">Menu</h2>

                    <ul class="nav nav-pills flex-column mb-sm-auto mb-0 align-items-center align-items-sm-start text-light" id="menu">
                        <li class="nav-item">
                            <a href="#" class="nav-link align-middle px-0">
                                <span class="material-symbols-outlined">home</span> <span class="ms-1 d-none d-sm-inline">Home</span>
                            </a>
                        </li>
                        <li>
                            <a href="#" class="nav-link px-0 align-middle">
                                <span class="material-symbols-outlined">search</span> <span class="ms-1 d-none d-sm-inline">Explore</span> </a>
                        </li>
                        <li class="w-100">
                            <a href="#" class="nav-link px-0 position-relative">
                                <span class="material-symbols-outlined">notifications</span> 
                                <span class="d-none d-sm-inline">Notifications</span>
                                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                    99+
                                    <span class="visually-hidden">unread messages</span>
                                </span>
                            </a>
                        </li>
                        <li>
                            <a href="#" class="nav-link px-0 position-relative"> 
                                <span class="material-symbols-outlined">mail</span>
                                <span class="d-none d-sm-inline">Messages</span>
                                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                    99+
                                    <span class="visually-hidden">unread messages</span>
                                </span>
                            </a>
                        </li>
                    
                        <li>
                            <a href="#" class="nav-link px-0 align-middle">
                                <i class="material-symbols-outlined">person</i> <span class="ms-1 d-none d-sm-inline">Profile</span></a>
                        </li>
                    </ul>
                    <hr>
                    <div class="dropdown pb-4">
                        <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle" id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
                            <img src="person_google.png" alt="hugenerd" width="30" height="30" class="rounded-circle bg-light">
                            <span class="d-none d-sm-inline mx-1">User</span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-dark text-small shadow">
                            <li><a class="dropdown-item" href="#">New project...</a></li>
                            <li><a class="dropdown-item" href="#">Settings</a></li>
                            <li><a class="dropdown-item" href="#">Profile</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item" href="#">Sign out</a></li>
                        </ul>
                    </div>
                </div>
            </div>

<!-- Center Panel -->
            <div class="col col-4 py-3">
                <h2 class="p-2 text-light">Posts</h2>
                <div id="content">
                    <table class="table table-dark table-hover">
                        <tr>
                            <td>Mark</td>
                        </tr>
                    </table>    
                </div>
                
            </div>

<!-- Right Side Panel -->
            <div class="d-flex flex-column align-items-stretch flex-shrink-0 text-light bg-dark border-start" style="width: 380px;">
                <a href="/" class="d-flex align-items-center flex-shrink-0 p-3 text-decoration-none border-bottom">
                    <svg class="bi me-2" width="30" height="24"><use xlink:href="#bootstrap"></use></svg>
                    <span class="fs-6 fw-semibold"><i class="material-symbols-outlined">list_alt</i>&nbsp;List group</span>
                </a>
                <div class="list-group list-group-flush border-bottom scrollarea">
                    <a href="#" class="list-group-item list-group-item-action active py-3 lh-tight" aria-current="true">
                        <div class="d-flex w-100 align-items-center justify-content-between">
                            <strong class="mb-1">List group item heading</strong>
                            <small>Wed</small>
                        </div>
                        <div class="col-10 mb-1 small">Some placeholder content in a paragraph below the heading and date.</div>
                    </a>
                    <a href="#" class="list-group-item list-group-item-action py-3  lh-tight text-light bg-dark">
                        <div class="d-flex w-100 align-items-center justify-content-between">
                            <strong class="mb-1">List group item heading</strong>
                            <small class="text-muted">Tues</small>
                        </div>
                        <div class="col-10 mb-1 small">Some placeholder content in a paragraph below the heading and date.</div>
                    </a>
                </div>
            </div>

        </div>
        
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>