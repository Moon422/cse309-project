<?php
    session_start();

    $id = (int)$_SESSION["id"];
    $firstname = $_SESSION["FirstName"];
    $lastname = $_SESSION["LastName"];
    $profileType = $_SESSION["ProfileType"];

    $dayToKey = array("Sunday" => 'sun', "Monday" => 'mon', "Tuesday" => 'tues', "Wednesday" => 'wed', "Thursday" => 'thurs', "Friday" => 'fri', "Saturday" => 'sat');
    $keyToDay = array("sun" => "Sunday", "mon" => "Monday", "tues" => "Tuesday", "wed" => "Wednesday", "thurs" => "Thursday");
    $today = date("l");

    $link = mysqli_connect("localhost", "web_app", "hola", "webapp_db");

    if (!$link) {
        die("ERROR: Could not connect. ". mysqli_connect_error());
    }

    $sql = "SELECT * FROM `Courses` AS c INNER JOIN `Enrollments` AS e ON c.id=e.CourseId WHERE e.StudentId=$id;";
    $result = mysqli_query($link, $sql);

    $numberOfEnrolledCourses = mysqli_num_rows($result);
?>

<div class="row mb-4">
    <div class="mt-3 col-12 col-md-6 col-lg-4">
        <div class="card p-5">Registered Courses: <?php echo $numberOfEnrolledCourses; ?></div>
    </div>
</div>
<h1>Today's Schedule</h1>
<div class="row">
<?php 
    $todayKey = "sun";
    $sql = "SELECT p.FirstName, p.LastName, c.Name, c.StartTime, c.Duration, c.DayOfWeek, c.RoomNumber FROM `Courses` AS c INNER JOIN `Enrollments` AS e ON c.id=e.CourseId INNER JOIN `Profiles` as p ON c.InstructorId=p.id WHERE e.StudentId=$id AND c.DayOfWeek='$todayKey';";
    $result = mysqli_query($link, $sql);

    if (mysqli_num_rows($result)) {
        while ($row = mysqli_fetch_assoc($result)) {
            $courseName = $row["Name"];
            $instructorName = $row["FirstName"]." ".$row["LastName"];
            $roomNumber = $row["RoomNumber"];
            $startTime = strtotime($row["StartTime"]);
            $endTime = $startTime + $row["Duration"];
?>
<div class="mt-3 col-12 col-md-6 col-lg-4">
    <div class="card">
        <div class="card-header">
            <?php echo $courseName ?>
        </div>
        <div class="p-2">
            <p>Room No: <?php echo $roomNumber ?></p>
            <p>Instructor: <?php echo $instructorName ?></p>
            <p>Schedule: <?php echo date("h:i a", $startTime); ?> - <?php echo date("h:i a", $endTime); ?></p>
            <p>Day: <?php echo $keyToDay[$row["DayOfWeek"]]; ?></p>
        </div>
    </div>
</div>
<?php
        }
    }
?>
</div>