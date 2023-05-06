<?php
    $courseId = $_GET["course"];

    $link = mysqli_connect("localhost", "web_app", "hola", "webapp_db");

    if (!$link) {
        die("ERROR: Could not connect. ". mysqli_connect_error());
    }

    $sql = "DELETE FROM `Courses` WHERE id=$courseId;";
    $query = mysqli_query($link, $sql);

    mysqli_close($link);

    header("Location: /librarymanager/courses.php");
?>