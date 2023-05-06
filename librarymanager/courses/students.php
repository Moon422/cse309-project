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
                <h1>Course Enrollments</h1>
                <table class="w-100">
                        <thead>
                            <tr>
                                <th>
                                    Student Name
                                </th>
                                <th>
                                    Student ID
                                </th>
                            </tr>
                        </thead>
                        <tbody>
<?php
            $sql = "select * from Enrollments as e inner join Profiles as p on e.StudentId=p.id where e.CourseId=$courseId;";
            $enrollmentResult = mysqli_query($link, $sql);

            if (mysqli_num_rows($enrollmentResult) > 0) {
                while ($enrollmentRow = mysqli_fetch_assoc($enrollmentResult)) {
                    $studentName = $enrollmentRow["FirstName"]." ".$enrollmentRow["LastName"];
                    $studentId = $enrollmentRow["OrgId"];
?>
                            <tr>
                                <td><?php echo $studentName; ?></td>
                                <td><?php echo $studentId; ?></td>
                            </tr>
<?php
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