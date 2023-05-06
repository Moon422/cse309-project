<?php 
    session_start();

    $id = (int)$_SESSION["id"];
    $firstname = $_SESSION["FirstName"];
    $lastname = $_SESSION["LastName"];
    $profileType = $_SESSION["ProfileType"];

    $dayToKey = array("Sunday" => 'sun', "Monday" => 'mon', "Tuesday" => 'tues', "Wednesday" => 'wed', "Thursday" => 'thurs', "Friday" => 'fri', "Saturday" => 'sat');
    $keyToDay = array("sun" => "Sunday", "mon" => "Monday", "tues" => "Tuesday", "wed" => "Wednesday", "thurs" => "Thursday");

    $link = mysqli_connect("localhost", "web_app", "hola", "webapp_db");

    if (!$link) {
        die("ERROR: Could not connect. ". mysqli_connect_error());
    }

    if (isset($_GET["course"])) {
        $courseId = (int)$_GET["course"];

        $sql = "INSERT INTO Enrollments (`StudentId`, `CourseId`) VALUES ($id, $courseId);";
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
                <h1>Book a Course</h1>
                <div class="row">
<?php
    $sql = "select p.FirstName, p.LastName, c.id, c.InstructorId, c.Name, c.StartTime, c.Duration, c.DayOfWeek, c.RoomNumber from Courses as c left join Profiles as p on c.InstructorId=p.id where c.id not in (select e.CourseId from Enrollments as e where e.StudentId=4);";
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
                            <p>Instructor: <?php echo $row["InstructorId"] ? $instructorName : "N/A" ?></p>
                            <p>Schedule: <?php echo date("h:i a", $startTime); ?> - <?php echo date("h:i a", $endTime); ?></p>
                            <p>Day: <?php echo $keyToDay[$row["DayOfWeek"]]; ?></p>
                        </div>
                        <a href="bookcourse.php?course=<?php echo $row["id"]; ?>" class="btn btn-primary w-100">Register</a>
                    </div>
                </div>
<?php
        }
    }
?>                   
                </div>
            </div>
        </div>
    </div>

    <script src="/libraries/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>