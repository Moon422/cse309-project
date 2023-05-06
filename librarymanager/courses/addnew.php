<?php
    echo "hello";

    $courseName = $_POST["course-name"];
    $roomNumber = $_POST["room-number"];
    $dayOfWeek = $_POST['day-of-week'];
    $startTime  = $_POST["start-time"].":00";
    $duration = ((int)$_POST["duration"]) * 60;
    $instructorId = $_POST["instructor"];
    
    $link = mysqli_connect("localhost", "web_app", "hola", "webapp_db");

    if (!$link) {
        die("ERROR: Could not connect. ". mysqli_connect_error());
    }

    if (!$instructorId) {
        $sql = "insert into `Courses`(`Name`, `RoomNumber`, `DayOfWeek`, `StartTime`, `Duration`) values ('$courseName', '$roomNumber', '$dayOfWeek', '$startTime', $duration);";
        $query = mysqli_query($link, $sql);

        if ($query) {
            echo "Course Created";
        } else {
            echo "Course Creation Failed";
        }
    } else {
        $sql = "insert into `Courses`(`Name`, `RoomNumber`, `DayOfWeek`, `StartTime`, `Duration`, `InstructorId`) values ('$courseName', '$roomNumber', '$dayOfWeek', '$startTime', $duration, $instructorId);";
        $query = mysqli_query($link, $sql);

        if ($query) {
            echo "Course Created";
        } else {
            echo "Course Creation Failed";
        }
    }

    mysqli_close($link);

    sleep(3);

    header("Location: /librarymanager/courses.php");
?>