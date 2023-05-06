<?php 
    session_start();

    $id = $_SESSION["id"];
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

    $sql = "select * from Courses where InstructorId=$id";
    $result = mysqli_query($link, $sql);
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
                <h1>Select a Courses</h1>
                <div class="row mb-4">
<?php
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $courseId = $row["id"];
            $courseName = $row["Name"];
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
                                    <p>Schedule: <?php echo date("h:i a", $startTime); ?> - <?php echo date("h:i a", $endTime); ?></p>
                                    <p>Day: <?php echo $keyToDay[$row["DayOfWeek"]]; ?></p>
                                </div>
                                <a href="/sods/attendance/take.php?course=<?php echo $courseId?>" class="btn btn-primary">Take Attendance</a>
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