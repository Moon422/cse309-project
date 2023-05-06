<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>

    <!-- bootstrap -->
    <link rel="stylesheet" href="/libraries/bootstrap/css/bootstrap.min.css">

    <!-- style.css -->
    <link rel="stylesheet" href="/style.css">
</head>
<body>
    <?php 
        session_start();

        $id = $_SESSION["id"];
        $firstname = $_SESSION["FirstName"];
        $lastname = $_SESSION["LastName"];
        $profileType = $_SESSION["ProfileType"];
    ?>

    <div class="container-fluid h-100">
        <div class="row h-100">
            <div class="col-2 bg-primary">
                <?php
                    if ($profileType === "admin") {
                        // load admin sidebar
                    } else if ($profileType === "librarymanager") {
                        // load librarymanager sidebar
                        include "librarymanager/sidebar.php";
                    } else if ($profileType === "sod") {
                        // load sod sidebar
                        include "sods/sidebar.php";
                    } else {
                        // load student sidebar
                        include("students/sidebar.php");
                    }
                ?>
            </div>
            <div class="col">
                <?php
                    if ($profileType === "admin") {
                        // load admin content
                    } else if ($profileType === "librarymanager") {
                        // load librarymanager content
                        include "librarymanager/index.php";
                    } else if ($profileType === "sod") {
                        // load sod content
                        include "sods/index.php";
                    } else {
                        // load student content
                        include "students/index.php";
                    }
                ?>
            </div>
        </div>
    </div>

    <script src="/libraries/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>