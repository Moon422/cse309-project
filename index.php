<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login/Registration Page</title>

    <!-- bootstrap -->
    <link rel="stylesheet" href="/libraries/bootstrap/css/bootstrap.min.css">

</head>
<body>
    <h1 class="text-center bg-primary text-white py-5">Welcome to XYZ digital library</h1>
    <div class="container mt-5">
        <div class="row">
            <div class="col border-end">
                <h3 class="text-center">Login</h3>
                <form action="/login.php" method="post">
                    <div class="mb-2">
                        <label for="username">Username</label><br>
                        <input class="w-100" type="text" name="username" id="username" placeholder="Username" required><br>
                    </div>
                    <div class="mb-2">
                        <label for="password">Password</label><br>
                        <input class="w-100" type="password" name="password" id="password" placeholder="Password" required><br>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
            <div class="col border-start">
                <h3 class="text-center">Register</h3>
            </div>
        </div>
    </div>
    
    <script src="/libraries/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>