<?php 
    session_start();

    $id = $_SESSION["id"];
    $firstname = $_SESSION["FirstName"];
    $lastname = $_SESSION["LastName"];
    $profileType = $_SESSION["ProfileType"];
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
                <h1>New SOD Applications</h1>
                <div class="row mb-4">
<?php
    $link = mysqli_connect("localhost", "web_app", "hola", "webapp_db");

    if (!$link) {
        die("ERROR: Could not connect. ". mysqli_connect_error());
    }

    $sql = "SELECT sa.id, p.FirstName, p.LastName, p.Cgpa, c.Name FROM `SodApplications` AS sa INNER JOIN `Profiles` AS p ON sa.SodId=p.id INNER JOIN `Courses` as c ON sa.DesiredCourse=c.id WHERE sa.Approved=0;";
    $result = mysqli_query($link, $sql);
    
    if(mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $applicationId = $row["id"];
            $sodName = $row["FirstName"]." ".$row["LastName"];
            $sodCgpa = $row["Cgpa"];
            $courseName = $row["Name"];
?>
                <div class="mt-3 col-12 col-md-6 col-lg-4">
                    <div class="card">
                        <div class="card-header">
                            <?php echo $sodName; ?>
                        </div>
                        <div class="p-2">
                            <p>CGPA: <?php echo $sodCgpa; ?></p>
                            <p>Desired Course: <?php echo $courseName; ?></p>
                        </div>
                        <div class="btn-group" role="group" aria-label="Basic example">
                            <button type="button" class="btn btn-success">Approve</button>
                            <button type="button" class="btn btn-danger">Reject</button>
                        </div>
                    </div>
                </div>
<?php
        }
    }
?>
                </div>
                <h1>Current SODs</h1>
                <div class="row">
<?php
    $sql = "SELECT p.id, p.FirstName, p.LastName, p.Cgpa, c.Name FROM `Profiles` AS p INNER JOIN `Courses` as c ON p.id=c.InstructorId;";
    $result = mysqli_query($link, $sql);

    if (mysqli_num_rows($result) > 0) {
        $onDutySods = array();

        while ($row = mysqli_fetch_assoc($result)) {
            $sodId = $row["id"];
            $sodName = $row["FirstName"]." ".$row["LastName"];
            $courseName = $row["Name"];
            $sodCgpa = $row["Cgpa"];

            if (array_key_exists($sodId, $onDutySods)) {
                array_push($onDutySods[$sodId]["courses"], $courseName);
            } else {
                $arr = array("name" => $sodName, "cgpa" => $sodCgpa, "courses" => array($courseName));
                $onDutySods[$sodId] = $arr;
            }
        }

        foreach ($onDutySods as $id => $value) {
?>
                    <div class="mt-3 col-12 col-md-6 col-lg-4">
                        <div class="card">
                            <div class="card-header">
                                <?php echo $value["name"] ?>
                            </div>
                            <div class="p-2">
                                <p>CGPA: <?php echo $value["cgpa"] ?></p>
                                <p>Assigned Course: <?php
                                    $coursesName = "";
                                    for ($i=0; $i < count($value["courses"]) - 1; $i++) { 
                                        echo $value["courses"][$i].", ";
                                    }
                                    echo $value["courses"][$i];
                                ?></p>
                            </div>
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