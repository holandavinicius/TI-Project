<?php



require_once (__DIR__ . "/api/device_data_model.php");
require_once (__DIR__ . "/api/device_data_service.php");

session_start();



if (!isset($_SESSION['username'])) {
    header("refresh:60;url=index.php");
    die("Access denied.");
}


function ReturnFirstImageFileOfADirectory($directory)
{

    // Search for PNG files in the directory
    $files = glob($directory . '/*.{png,svg}', GLOB_BRACE);

    // Check if there are any PNG files
    if (count($files) > 0) {
        // Get the first PNG file
        $firstPngFile = $files[0];

        // Output the file name or do something else with it
        return basename($firstPngFile);
    } else {
        return null;
    }

}




?>


<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <script src=" https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
        </script>
    <!-- <meta http-equiv="refresh" content="5"> -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="icon" href="./src/logo.svg">
    <link rel="stylesheet" href="./css/dashboard.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">

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
        </div>
        <div id="user">
            <div class="menu-item d-none d-sm-block">
                <a href="logout.php" class="me-5">
                    Logout
                </a>
            </div>
            <div class="menu-item d-sm-flex align-items-center">
                <a href="#" class="d-none d-sm-flex align-items-center text-decoration-none">
                    <img src="./src/person.svg" id="userLogo" alt="UserLogo">
                    <p class="d-none d-sm-block m-0"><?php echo $_SESSION['username'] ?></p>
                </a>
            </div>
            <div class="dropdown d-sm-none align-items-center mt-2">
                <button data-mdb-button-init data-mdb-ripple-init data-mdb-dropdown-init
                    class="btn btn-primary-outline dropdown-toggle" type="button" id="dropdownMenuButton"
                    data-mdb-toggle="dropdown" aria-expanded="true">
                    <img src="./src/person.svg" id="dropdown-userLogo" alt="UserLogo dropdown">
                </button>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton">
                    <li><a class="dropdown-item" href="#"><?php echo $_SESSION['username'] ?></a></li>
                    <li><a class="dropdown-item" href="logout.php">Logout</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container d-flex justify-content-around align-items-center" id="title">
        <div style="color: white; margin-top: 2rem;">
            <h1>Servidor IoT</h1>
        </div>
    </div>


    <div class="container">
        <div class="row">
            <?php

            function reloadData()
            {
                // Define the directories
                $iterator = new DirectoryIterator("api/files/");
                $directories = array();
                foreach ($iterator as $fileinfo) {
            
                    if ($fileinfo->isDir() && !$fileinfo->isDot()) {
                        $directories[] = strtolower($fileinfo->getFilename());
                        }
                    }

                $deviceService = new DeviceDataService();    
                // Loop through each directory
                $id = 1;
                foreach ($directories as $directory) {
                    // Read the contents of each file
            
                    $formattedDir = __DIR__ . "/api/files/" . $directory;

                    $hora = file_get_contents($formattedDir . "/hora.txt");
                    $nome = file_get_contents($formattedDir . "/nome.txt");
                    $valor = file_get_contents($formattedDir . "/valor.txt");
                    $imagefileName = ReturnFirstImageFileOfADirectory($formattedDir);


                    //Events 
                    switch ($nome) {
                        case 'temperatura':
                            //Event for temperature
                            
                            // $data = new DateTime('now');
                            if ($valor > 10) {
                                // Data: 2024-04-21 08:51:38pm
                                // Todo: set a fixed format for data to entire application.
                                // .date("Y-m-d")." ".date("h:i:sa").
                                $deviceData = new DeviceDataModel('luminosidade', date("Y-m-d h:i:sa"), 1);
                                $deviceService->ProcessDataPost($deviceData);
                            }
                            break;
                        case 'luminosidade':
                            if ($valor == 1) {
                                $valor = "Ligado";
                                $imagefileName = "light-on.png";
                            } else {
                                $valor = "Desligado";
                                $imagefileName = "light-off.png";
                            }
                            break;
                    }

                    $formattedDirImage = "./api/files/" . $directory . "/" . $imagefileName;

                    // Generate the card HTML
                    echo "
                            <div  class='col-lg-4 col-md-6 col-sm-12 d-flex justify-content-center'>
                            <div class='card text-center' id={$id}>
                            <img class='imgDashboard' src='{$formattedDirImage}' alt='dashboard img'>
                            <div class='card-body border-0'>
                                <div class='card-title'>{$nome}</div>
                                <span class='badge rounded-pill text-bg-warning mb-10'>{$valor}</span>
                                <p class='mt-3'>{$hora}</p>
                                <a class='btn btn-primary' href='historico.php?nome={$formattedDir}'>Histórico</a>
                            </div>
                        </div>
                    </div>
                    ";

                    $id = $id + 1;
                }

            }

            reloadData();
            ?>
        </div>
    </div>
</body>

<script>
    // async function fetchData() {
    //     try {
    //         const response = await fetch('/api/api.php?nome={}');
    //         const data = await response.json();
    //         document.getElementById('data1').textContent = data.value1;
    //         document.getElementById('data2').textContent = data.value2;
    //     } catch (error) {
    //         console.error('Error fetching data:', error);
    //     }
    // }

    // foreach()
    // Initial data fetch
    // fetchData();
    reloadData();
    // Set interval to auto-refresh every 5 seconds
    setInterval(reloadData, 5000);
</script>

</html>