<?php
    $courseId = $_GET["course"];

    $courseName = $_POST["course-name"];
    $roomNumber = $_POST["room-number"];
    $dayOfWeek = $_POST['day-of-week'];
    $startTime  = $_POST["start-time"];
    $duration = ((int)$_POST["duration"]) * 60;
    $instructorId = $_POST["instructor"];

    $link = mysqli_connect("localhost", "web_app", "hola", "webapp_db");

    if (!$link) {
        die("ERROR: Could not connect. ". mysqli_connect_error());
    }

    if (!$instructorId) {
        $sql = "update `Courses` set `Name`='$courseName', `RoomNumber`='$roomNumber', `DayOfWeek`='$dayOfWeek', `StartTime`='$startTime', `Duration`=$duration where id=$courseId;";
        $query = mysqli_query($link, $sql);

        if ($query) {
            echo "Course Update";
        } else {
            echo "Course Update Failed";
        }
    } else {
        echo "hello";
        echo $courseId;
        $sql = "update `Courses` set `Name`='$courseName', `RoomNumber`='$roomNumber', `DayOfWeek`='$dayOfWeek', `StartTime`='$startTime', `Duration`=$duration, `InstructorId`=$instructorId where id=$courseId;";
        $query = mysqli_query($link, $sql);

        if ($query) {
            echo "Course Update";
        } else {
            echo "Course Update Failed";
        }
    }

    mysqli_close($link);

    sleep(3);

    header("Location: /librarymanager/courses.php");
?>