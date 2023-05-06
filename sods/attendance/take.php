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

    if ($_SERVER["REQUEST_METHOD"] === "GET" && isset($_GET["course"])) {
        $courseId = $_GET["course"];

        $sql = "select p.id, p.FirstName, p.LastName, p.OrgId from Enrollments as e inner join Profiles as p on e.StudentId=p.Id where e.CourseId=$courseId;";
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
                    include "../sidebar.php";
                ?>
            </div>
            <div class="col py-4">
                <h1>Take Attendance</h1>
                <form method="post">
                    <table class="w-100">
                        <thead>
                            <tr>
                                <th>Student Name</th>
                                <th>Student ID</th>
                                <th>Present/Absent</th>
                            </tr>
                        </thead>
                        <tbody>
<?php
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $studentId = $row["id"];
            $studentName = $row["FirstName"]." ".$row["LastName"];
            $studentOrgId = $row["OrgId"];
?>
                            <tr>
                                <td><?php echo $studentName; ?></td>
                                <td><?php echo $studentOrgId; ?></td>
                                <!-- <input type="checkbox" id="vehicle3" name="vehicle3" value="Boat"> -->
                                <td>
                                    <input type="checkbox" name="<?php echo $studentId; ?>" id="<?php echo $studentId; ?>">
                                </td>
                            </tr>
<?php
        }
    }
?>                            
                        </tbody>
                    </table>
                    <input type="submit" value="Submit" class="btn btn-primary mt-2">
                </form>
            </div>
        </div>
    </div>

    <script src="/libraries/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php
    } else if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_GET["course"])) {
        $courseId = $_GET["course"];
        $presentId = array();
        
        foreach ($_POST as $key => $value) {
            array_push($presentId, $key);
        }

        $sql = "select StudentId from Enrollments where CourseId=$courseId;";
        $result = mysqli_query($link, $sql);

        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $studentId = $row["StudentId"];

                print_r($studentId);

                if (in_array($studentId, $presentId)) {
                    $attendanceDate = date("Y-m-d");
                    echo $attendanceDate;
                    $sql = "Insert into Attendances (StudentId, CourseId, Present, `Schedule`) values ($studentId, $courseId, 1, '$attendanceDate');";
                    $query = mysqli_query($link, $sql);
                } else {
                    $attendanceDate = date("Y-m-d");
                    echo $attendanceDate;
                    $sql = "Insert into Attendances (StudentId, CourseId, Present, `Schedule`) values ($studentId, $courseId, 0, '$attendanceDate');";
                    $query = mysqli_query($link, $sql);
                }
            }
        }

        header("Location: /sods/attendance.php");
    }

?>
