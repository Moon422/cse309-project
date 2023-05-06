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

    if (isset($_GET["rid"]) && isset($_GET["status"])) {
        $rid = $_GET["rid"];
        $status = $_GET["status"];

        if ($status === "complete") {
            $sql = "UPDATE `Requests` SET `Completed`=1 where `id`=$rid;";
            $query = mysqli_query($link, $sql);

            if ($query) {
                header("Location: /librarymanager/requests.php");
            } else {
                echo "Failed to mark request complete";
            }
        }
        else {
            $sql = "UPDATE `Requests` SET `Completed`=0 where `id`=$rid;";
            $query = mysqli_query($link, $sql);

            if ($query) {
                header("Location: /librarymanager/requests.php");
            } else {
                echo "Failed to mark request incomplete";
            }
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
            <div class="col">
                <div class="row">
<?php
    $sql = "SELECT r.id, r.Title, p.FirstName, p.LastName, r.Message, r.Completed FROM `Requests` AS r INNER JOIN `Profiles` AS p ON r.StudentId=p.id;";
    $result = mysqli_query($link, $sql);

    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $requestId = $row["id"];
            $title = $row["Title"];
            $studentName = $row["FirstName"]." ".$row["LastName"];
            $message = $row["Message"];
            $isComplete = (bool)$row["Completed"];
?>
                    <div class="mt-3 col-12 col-md-6 col-lg-4">
                        <div class="card">
                            <div class="card-header">
                                <?php
                                    echo $title;
                                ?>
                            </div>
                            <div class="p-2">
                                <p>Requester Name: <?php echo $studentName; ?></p>
                                <p>Request Body: <?php echo $message; ?></p>
                                <p>Status: <?php echo $isComplete ? "Complete" : "Incomplete" ?></p>
                            </div>
<?php
            if ($isComplete) {
?> 
                            <a href="requests.php?rid=<?php echo $requestId ?>&status=incomplete" class="btn btn-danger w-100">Mark as Incomplete</a>
<?php
            } else {
?>
                            <a href="requests.php?rid=<?php echo $requestId ?>&status=complete" class="btn btn-primary w-100">Mark as Complete</a>
<?php                
            }
?>                        
                        </div>
                    </div>
<?php
        }
    }

    mysqli_close($link);
?>                    
                </div>
            </div>
        </div>
    </div>

    <script src="/libraries/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>