<?php
    // echo $_POST["username"];
    $username = $_POST["username"];
    $password = $_POST["password"];

    $link = mysqli_connect("localhost", "web_app", "hola", "webapp_db");

    if (!$link) {
        die("ERROR: Could not connect. ". mysqli_connect_error());
    }

    $sql = "select `UserName`, `Password`, `ProfileId` from Authentications where `UserName`='$username';";
    $result = mysqli_query($link, $sql);

    if (mysqli_num_rows($result) === 1) {
        // username matched
        $row = mysqli_fetch_assoc($result);

        if ($row["Password"] === $password) {
            // password matched
            $profileid = $row["ProfileId"];
            $sql = "select id, FirstName, LastName, ProfileType from Profiles where id='$profileid';";
            $result = mysqli_query($link, $sql);

            if (mysqli_num_rows($result) === 1) {
                // profile found
                $row = mysqli_fetch_assoc($result);

                echo $row["FirstName"]. " " . $row["LastName"];

                session_start();

                $_SESSION["id"] = $row["id"];
                $_SESSION["FirstName"] = $row["FirstName"];
                $_SESSION["LastName"] = $row["LastName"];
                $_SESSION["ProfileType"] = $row["ProfileType"];

                mysqli_close($link);
                header("Location: /dashboard.php");
            } else {
                mysqli_close($link);
                header("Location: /index.php");
            }
        } else {
            mysqli_close($link);
            header("Location: /index.php");
        }
    } else {
        mysqli_close($link);
        header("Location: /index.php");
    }
?>