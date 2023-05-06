<?php
session_start();

$id = $_SESSION["id"];
$firstname = $_SESSION["FirstName"];
$lastname = $_SESSION["LastName"];
$profileType = $_SESSION["ProfileType"];

if ($_SERVER["REQUEST_METHOD"] === "GET" && isset($_GET["course"])) {
    $courseId = $_GET["course"];

    $link = mysqli_connect("localhost", "web_app", "hola", "webapp_db");

    if (!$link) {
        die("ERROR: Could not connect. ". mysqli_connect_error());
    }

    $sql = "update Courses set InstructorId=NULL where id=$courseId;";
    $result = mysqli_query($link, $sql);

    header("Location: /dashboard.php");
}
?>