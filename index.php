<?php

session_start();


require("../TI-Project/helpers/users_authentication.php");
$userVerification = new UserAuthentication(); 
$users = $userVerification->readUsers();

?>



<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="./css/loginpage.css">
    <meta http-equiv="refresh" content="5">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
</head>

<body>
    <div class="container">
        <div>
            <img class="logoImg" src="./src/logo.svg">
        </div>
    </div>
    <!-- Form -->
    <form action="" method="post">
        <div class="mb-3">
            <label for="usernameInput" class="form-label">Username:</label>
            <input type="text" placeholder="Insert your username" class="form-control" id="username" name="username" required>
        </div>
        <div class="mb-4">
            <label for="passwordInput" class="form-label">Password:</label>
            <input type="password" placeholder="Insert your password" class="form-control" id="password" aria-describedby="passwordHelp" name="password" required>
        </div>
        <div class="d-flex justify-content-center">
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
        <?php if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['username']) && isset($_POST['password'])) {
            if (password_verify($_POST['password'], $users[$_POST['username']]) && isset($users[$_POST['username']])) {
                $_SESSION['username'] = $_POST['username'];
                header("Location: dashboard.php");
                exit;
            } else {
                echo "Username ou Password incorretos.";
            }
        }
        ?>
    </form>
</body>
<script src=" https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

</html>