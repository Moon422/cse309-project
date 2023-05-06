<?php
    $days = array("sun" => "sunday", "mon" => "monday", "tues" => "tuesday", "wed" => "wednesday", "thurs" => "thursday");

    $link = mysqli_connect("localhost", "web_app", "hola", "webapp_db");

    if (!$link) {
        die("ERROR: Could not connect. ". mysqli_connect_error());
    }

    $sql = "select * from Courses;";
    $courseResult = mysqli_query($link, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Courses</title>

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
            <div class="col">
                <div class="d-flex flex-column justify-content-between h-100">
                    <div class="row">
                        <?php
                            if (mysqli_num_rows($courseResult) > 0) {
                                while ($courseRow = mysqli_fetch_assoc($courseResult)) {
                                    $instructorId = $courseRow["InstructorId"];

                                    $sql = "select * from Profiles where `id`='$instructorId';";
                                    $instructorResult = mysqli_query($link, $sql);

                                    $startTime = strtotime($courseRow["StartTime"]);
                                    $endTime = $startTime + $courseRow["Duration"];
                                    

                                    if (mysqli_num_rows($instructorResult) === 1) {
                                        $instructorRow = mysqli_fetch_assoc($instructorResult);
                                        $instructorName = $instructorRow["FirstName"]. " ". $instructorRow["LastName"];
                        ?>
                            <div class="mt-3 col-12 col-md-6 col-lg-4">
                                <div class="card">
                                    <div class="card-header">
                                        <?php echo $courseRow["Name"]; ?>
                                    </div>
                                    <div class="p-2">
                                        <p>Room No: <?php echo $courseRow["RoomNumber"] ?></p>
                                        <p>Instructor: <?php echo $instructorName ?></p>
                                        <p>Schedule: <?php echo date("h:i a", $startTime); ?> - <?php echo date("h:i a", $endTime); ?></p>
                                        <p>Day: <?php echo ucwords($days[$courseRow["DayOfWeek"]]); ?></p>
                                    </div>
                                    <div class="btn-group" role="group" aria-label="Basic example">
                                        <a href="./courses/attendance.php?course=<?php echo $courseRow["id"]?>"
                                            class="btn btn-primary">Attendance</a>
                                        <a href="./courses/edit.php?course=<?php echo $courseRow["id"]?>" class="btn btn-primary">Edit</a>
                                        <a href="./courses/students.php?course=<?php echo $courseRow["id"]?>"
                                            class="btn btn-primary">Students</a>
                                        <!-- <button type="button" class="btn btn-primary">Remove</button> -->
                                        <a href="./courses/remove.php?course=<?php echo $courseRow["id"]?>" class="btn btn-primary">Remove</a>
                                    </div>
                                </div>
                            </div>
                        <?php
                                    } else {
                        ?>
                            <div class="mt-3 col-12 col-md-6 col-lg-4">
                                <div class="card">
                                    <div class="card-header">
                                        <?php echo $courseRow["Name"]; ?>
                                    </div>
                                    <div class="p-2">
                                        <p>Room No: <?php echo $courseRow["RoomNumber"] ?></p>
                                        <p>Instructor: N/A</p>
                                        <p>Schedule: <?php echo date("h:i a", $startTime); ?> - <?php echo date("h:i a", $endTime); ?></p>
                                        <p>Day: <?php echo ucwords($days[$courseRow["DayOfWeek"]]); ?></p>
                                    </div>
                                    <div class="btn-group" role="group" aria-label="Basic example">
                                        <a href="./courses/attendance.php?course=<?php echo $courseRow["id"]?>"
                                            class="btn btn-primary">Attendance</a>
                                        <a href="./courses/edit.php?course=<?php echo $courseRow["id"]?>" class="btn btn-primary">Edit</a>
                                        <a href="./courses/students.php?course=<?php echo $courseRow["id"]?>"
                                            class="btn btn-primary">Students</a>
                                        <!-- <button type="button" class="btn btn-primary">Remove</button> -->
                                        <a href="./courses/remove.php?course=<?php echo $courseRow["id"]?>" class="btn btn-primary">Remove</a>
                                    </div>
                                </div>
                            </div>
                        <?php
                                    }
                                }
                            }
                        ?>
                    </div>
                    <a href="./courses/add.php" class="btn btn-primary mb-2">
                        Add New Class
                    </a>
                </div>
            </div>
        </div>
    </div>

    <script src="/libraries/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php
    mysqli_close($link);
?>