<?php

require_once (__DIR__ . "/api/device_data_model.php");
require_once (__DIR__ . "/api/device_data_service.php");

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
    <link rel="stylesheet" href="./css/dashboard.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Histórico</title>
    <link rel="icon" href="./src/logo.svg">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">
        <style>
    .table-image {
        max-width: 150px; /* Adjust the width as needed */
        height: auto; /* Maintain aspect ratio */
    }

    .date-cell {
        color: white; /* Set the font color of the date and time to white */
    }

    #imageTable {
        width: 100%; /* Make the table take up the full width */
    }

    #imageTable th, #imageTable td {
        padding: 10px; /* Add some padding for better readability */
        text-align: center; /* Center-align text in the cells */
    }

    #imageTable th {
        background-color: #343a40; /* Set a background color for the table header */
        color: white; /* Set the font color for the header text */
    }

    #imageTable td {
        background-color: #6c757d; /* Set a background color for the table cells */
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
            <div class="menu-item">
                <a href="camera.php">Segurança</a>
            </div>
        </div>
        <div id="user" class="d-flex align-items-center">
            <div class="menu-item d-none d-sm-block me-3">
                <a href="logout.php">Logout</a>
            </div>
            <div class="menu-item dropdown">
                <a href="#" class="d-flex align-items-center text-decoration-none dropdown-toggle" id="dropdownUser"
                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
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
            <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown"
                aria-expanded="true">
                <img src="./src/person.svg" id="dropdown-userLogo" alt="UserLogo dropdown">
            </button>
            <ul class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                <li><a class="dropdown-item" href="#"><?php echo $_SESSION['username'] ?></a></li>
                <li><a class="dropdown-item" href="logout.php">Logout</a></li>
            </ul>
        </div>
    </nav>

    <div class="container">
        <h1 class="section-title  text-center">Images de Segurança</h1>
        <table id="imageTable">
            <thead>
                <tr>
                    <th>Imagem</th>
                    <th>Data de Gravação</th>
                </tr>
            </thead>
            <tbody id="imageList">
                <!-- Images will be dynamically added here -->
            </tbody>
        </table>
    </div>

    <script>
        const ajaxUrl = 'list_images.php'; // URL to fetch images

        function fetchImages() {
            $.ajax({
                url: ajaxUrl,
                method: 'GET',
                success: function (data) {
                    $('#imageList').empty(); // Clear existing images

                    // Loop through each image data and create elements
                    data.forEach(function (image) {
                        // const imgElement = `<div class="col-md-3 my-2">
                        //                         <img src="./api/security/${image.fileName}" alt="Security Image" style="max-width: 100%; height: auto;">
                        //                         <p>${image.dateTime}</p>
                        //                     </div>`;
                        const imgElement = `<img src="./api/security/${image.fileName}" alt="Security Image" style="max-width: 100%; height: auto;">`;
                        const row = `<tr>
                                        <td>${imgElement}</td>
                                        <td>${image.dateTime}</td>
                                    </tr>`;
                        $('#imageList').append(row);
                    });
                },
                error: function (xhr, status, error) {
                    console.error('Error fetching images:', error);
                }
            });
        }

        // Fetch images every second
        setInterval(fetchImages, 1000);

        // Initial fetch when the page loads
        fetchImages();
    </script>


</body>


</html>