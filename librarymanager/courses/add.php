<?php
    $link = mysqli_connect("localhost", "web_app", "hola", "webapp_db");

    if (!$link) {
        die("ERROR: Could not connect. ". mysqli_connect_error());
    }

    $sql = "select * from Profiles where ProfileType='sod';";
    $instructorResult = mysqli_query($link, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Course</title>

    <!-- bootstrap -->
    <link rel="stylesheet" href="/libraries/bootstrap/css/bootstrap.min.css">

    <!-- style.css -->
    <link rel="stylesheet" href="/style.css">
</head>
<body>
    <?php 
        session_start();

        $id = $_SESSION["id"];
        $firstname = $_SESSION["FirstName"];
        $lastname = $_SESSION["LastName"];
        $profileType = $_SESSION["ProfileType"];
    ?>

    <div class="container-fluid h-100">
        <div class="row h-100">
            <div class="col-2 bg-primary">
                <?php
                    include("../sidebar.php");

                ?>
            </div>
            <div class="col py-4">
                <h1>Add New Course</h1>
                <form action="addnew.php" method="post">
                    <label for="course-name">Course Name</label><br>
                    <input type="text" name="course-name" id="course-name" required><br>
                    <label for="room-number">Room Number</label><br>
                    <input type="text" name="room-number" id="room-number" required><br>
                    <label for="day-of-week">Day of Week</label><br>
                    <select id="day-of-week" name="day-of-week">
                        <option value="sun">Sunday</option>
                        <option value="mon">Monday</option>
                        <option value="tues">Tuesday</option>
                        <option value="wed">Wednesday</option>
                        <option value="thurs">Thursday</option>
                    </select><br>
                    <label for="start-time">Start Time</label><br>
                    <input type="time" name="start-time" id="start-time" required><br>
                    <label for="duration">Duration (in minutes)</label><br>
                    <input type="number" name="duration" id="duration" required><br>
                    <label for="instructor">Instructor</label><br>
                    <!-- <input type="text" name="instructor" id="instructor"><br> -->
                    <select name="instructor" id="instructor">
                        <option value="">N/A</option>
                        <?php
                            if (mysqli_num_rows($instructorResult) > 0) {
                                while ($instructorRow = mysqli_fetch_assoc($instructorResult)) {
                                    $instructorName = $instructorRow["FirstName"]. " ". $instructorRow["LastName"];
                                    $instructorId = $instructorRow["id"];
                        ?>
                            <option value="<?php echo $instructorId; ?>">
                                <?php echo $instructorName; ?>
                            </option>
                        <?php
                                }
                            }
                        ?>
                    </select><br>
                    <button class="btn btn-primary mt-2">Save</button>
                </form>
            </div>
        </div>
    </div>

    <script src="/libraries/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
    mysqli_close($link);
?>