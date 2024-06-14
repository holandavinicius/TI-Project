<?php

require_once(__DIR__ ."/api/device_data_model.php");
require_once(__DIR__ ."/api/device_data_service.php");

$device = $_GET['nome'];

session_start();



if (!isset($_SESSION['username'])) {
    header("refresh:60;url=index.php");
    die("Access denied.");
}

?>


<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Histórico</title>
    <link rel="icon" href="./src/logo.svg">
    <link rel="stylesheet" href="./css/dashboard.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <style>
        .card {
            width: 100%;
            max-width: 400px; /* Adjust based on your layout */
            margin: 20px auto;
        }
        .card-body {
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        #webcam {
            width: 100%;
            height: auto;
        }
    </style>
</head>

<body>
<nav class="d-flex">
        <div class="menu-item" id="logo">
            <a href="dashboard.php">
                <img id="img" src="./src/logo.svg" alt="Logo">
            </a>
        </div>
        <div id="menu">
            <div class="menu-item">
                <a href="dashboard.php">Home</a>
            </div>
            <div class="menu-item" >
                <a href="camera.php">Segurança</a>
            </div>
        </div>
        <div id="user" class="d-flex align-items-center">
        <div class="menu-item d-none d-sm-block me-3">
            <a href="logout.php">Logout</a>
        </div>
        <div class="menu-item dropdown">
            <a href="#" class="d-flex align-items-center text-decoration-none dropdown-toggle" id="dropdownUser" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <img src="./src/person.svg" id="userLogo" alt="UserLogo" class="me-2">
                <p class="d-none d-sm-block m-0"><?php echo $_SESSION['username'] ?></p>
            </a>
            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownUser">
                <a class="dropdown-item" href="#"><?php echo $_SESSION['username'] ?></a>
                <a class="dropdown-item" href="logout.php">Logout</a>
            </div>
        </div>
    </div>

    <!-- Mobile View -->
    <div class="dropdown d-sm-none mt-2">
        <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-expanded="true">
            <img src="./src/person.svg" id="dropdown-userLogo" alt="UserLogo dropdown">
        </button>
        <ul class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
            <li><a class="dropdown-item" href="#"><?php echo $_SESSION['username'] ?></a></li>
            <li><a class="dropdown-item" href="logout.php">Logout</a></li>
        </ul>
    </div>
</nav>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6 col-md-8 col-sm-12">
                <div class="card">
                    <div class="card-header text-center">
                        Webcam Feed
                    </div>
                    <div class="card-body">
                        <div class="video-container">
                            <video id="webcam" autoplay></video>
                        </div>
                    </div>
                    <div class="card-footer text-center">
                        <button id="startButton" class="btn btn-primary">Start Webcam</button>
                        <button id="stopButton" class="btn btn-danger">Stop Webcam</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <script>
        const startButton = document.getElementById('startButton');
        const stopButton = document.getElementById('stopButton');
        const video = document.getElementById('webcam');
        let stream;

        startButton.addEventListener('click', async () => {
            try {
                stream = await navigator.mediaDevices.getUserMedia({ video: true });
                video.srcObject = stream;
            } catch (err) {
                console.error('Error accessing webcam: ', err);
            }
        });

        stopButton.addEventListener('click', () => {
            if (stream) {
                stream.getTracks().forEach(track => track.stop());
                video.srcObject = null;
            }
        });
    </script>
     
</body>


</html>