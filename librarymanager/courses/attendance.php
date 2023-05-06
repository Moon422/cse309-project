<?php
    $courseId = $_GET["course"];

    $link = mysqli_connect("localhost", "web_app", "hola", "webapp_db");

    if (!$link) {
        die("ERROR: Could not connect. ". mysqli_connect_error());
    }

    $sql = "select * from Courses where id=$courseId;";
    $result = mysqli_query($link, $sql);

    if (mysqli_num_rows($result) === 1) {
        $courseRow = mysqli_fetch_assoc($result);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $courseRow["Name"]." Student List" ?></title>

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
                    include "../sidebar.php";
                ?>
            </div>
            <div class="col py-2">
                <h1>Course Attendance</h1>
                <form action="attendance.php" method="get">
                    <input type="hidden" name="course" value="<?php echo $courseId; ?>">
                    <label for="session">Choose Session</label>
                    <select name="session" id="session">
                        <option value="">Select a Date</option>
<?php
            $sql = "Select Schedule from Attendances group by Schedule;";
            $scheduleResult = mysqli_query($link, $sql);

            if (mysqli_num_rows($scheduleResult) > 0) {
                while ($scheduleRow = mysqli_fetch_assoc($scheduleResult)) {
?>
                    <option value="<?php echo $scheduleRow["Schedule"] ?>"><?php echo $scheduleRow["Schedule"] ?></option>
<?php
                }
            } else {
?>
                    <option value="">N/A</option>
<?php
            }
?>
                    </select>
                    <input type="submit" value="Submit" class="btn btn-primary">
                </form>
<?php
            if (isset($_GET["session"])) {
                $sessionDate = $_GET["session"];
                
                $sql = "select p.FirstName, p.LastName, p.OrgId, a.Present from Attendances as a inner join Enrollments as e on a.StudentId=e.StudentId and a.CourseId=e.CourseId inner join Profiles as p on a.StudentId=p.id where a.CourseId=$courseId and a.Schedule='$sessionDate';";
                $attendanceResult = mysqli_query($link, $sql);

                if (mysqli_num_rows($attendanceResult) > 0) {
?>
                <table class="w-100">
                    <thead>
                        <tr>
                            <th>
                                Student Name
                            </th>
                            <th>
                                Student ID
                            </th>
                            <th>
                                Present/Absent
                            </th>
                        </tr>
                    </thead>
                    <tbody class="text-white">
<?php                    
                    while($attendanceRow = mysqli_fetch_assoc($attendanceResult)) {
                        $studentName = $attendanceRow["FirstName"]." ".$attendanceRow["LastName"];
                        $studentId = $attendanceRow["OrgId"];
                        $present = (int)$attendanceRow["Present"];
?>
                        <tr class="<?php if ($present) echo "bg-success"; else echo "bg-danger"; ?>">
                            <td><?php echo $studentName; ?></td>
                            <td><?php echo $studentId; ?></td>
                            <td><?php if ($present) echo "Present"; else echo "Absent"; ?></td>
                        </tr>
<?php
                    }
                }
            }
?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="/libraries/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
    } else {
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Course Does Not Exists</title>
</head>
<body>
    <h1>404! Course Not Found!</h1>
</body>
</html>

<?php
    }
?>