<?php
    $link = mysqli_connect("localhost", "web_app", "hola", "webapp_db");

    if (!$link) {
        die("ERROR: Could not connect. ". mysqli_connect_error());
    }

    $sql = "select * from Courses;";
    $result = mysqli_query($link, $sql);
    
    $courseCount = mysqli_num_rows($result);

    $sql = "select * from Profiles where ProfileType='sod';";
    $result = mysqli_query($link, $sql);
    
    $sodCount = mysqli_num_rows($result);

    $sql = "select * from Requests where Completed=0;";
    $result = mysqli_query($link, $sql);
    
    $requestCount = mysqli_num_rows($result);
?>
<div class="row">
    <div class="mt-3 col-12 col-md-6 col-lg-4">
        <div class="card p-5">Total Courses: <?php echo $courseCount; ?></div>
    </div>
    <div class="mt-3 col-12 col-md-6 col-lg-4">
        <div class="card p-5">Total SODs: <?php echo $sodCount; ?></div>
    </div>
    <div class="mt-3 col-12 col-md-6 col-lg-4">
        <div class="card p-5">New Requests: <?php echo $requestCount; ?></div>
    </div>
</div>
<?php
    mysqli_close($link);
?>