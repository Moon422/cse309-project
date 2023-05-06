<?php 
    session_start();

    $id = $_SESSION["id"];
    $firstname = $_SESSION["FirstName"];
    $lastname = $_SESSION["LastName"];
    $profileType = $_SESSION["ProfileType"];

    $link = mysqli_connect("localhost", "web_app", "hola", "webapp_db");

    if (!$link) {
        die("ERROR: Could not connect. ". mysqli_connect_error());
    }

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $title = $_POST["title"];
        $message = $_POST["message"];

        $sql = "insert into `Requests` (`Message`, `StudentId`, `Title`) values ('$message', $id, '$title');";
        $query = mysqli_query($link, $sql);

        if ($query) {
            header("Location: /dashboard.php");
        } else {
            echo "<script>Alert('Failed to register course');</script>";
        }
    }
?>

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
    <div class="container-fluid h-100">
        <div class="row h-100">
            <div class="col-2 bg-primary">
                <?php
                    include "sidebar.php";
                ?>
            </div>
            <div class="col py-4">
                <h1>Request for a Course</h1>
                <form method="post" action="requestcourse.php">
                    <label for="title">Title</label><br>
                    <input type="text" name="title" id="title"><br>
                    <label for="message">Request Body</label><br>
                    <textarea name="message" id="message" cols="30" rows="10"></textarea><br>
                    <input type="submit" value="Submit" class="btn btn-primary mt-2">
                </form>
            </div>
        </div>
    </div>

    <script src="/libraries/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>