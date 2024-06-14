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
    $files = glob($directory . '/*.{png,svg,jpg}', GLOB_BRACE);

    // Check if there are any PNG files
    if (count($files) > 0) {
        // Get the first PNG file
        $firstImage = $files[0];

        // Output the file name or do something else with it
        return basename($firstImage);
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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        .card.webcam {
            width: 100%;
            max-width: 1200px;
            /* Adjust based on your layout */
            margin: 20px auto;
        }

        .card-body.webcam {
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 20px;
        }

        .video-container {
            width: 100%;
            position: relative;
            overflow: hidden;
            padding-top: 56.25%;
            /* 16:9 Aspect Ratio (divide 9 by 16 = 0.5625) */
        }

        .video-container video {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
        }

        .card-footer.webcam {
            text-align: center;
            padding: 10px;
        }
    </style>
    <script>
        function updateDashboard() {
            $.ajax({
                url: 'fetch_data.php',
                method: 'GET',
                success: function (data) {
                    data.forEach(function (sensor) {
                        $(`#${sensor.id} .sensor-value`).text(sensor.valor);
                        $(`#${sensor.id} .sensor-time`).text(sensor.hora);
                        $(`#${sensor.id} .sensor-image`).attr('src', sensor.image);
                    });
                }
            });
        }

        $(document).ready(function () {
            updateDashboard(); // Initial fetch
            setInterval(updateDashboard, 5000); // Fetch every 5 seconds
        });
    </script>
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

    <div class="container d-flex justify-content-around align-items-center" id="title">
        <div style="color: white; margin-top: 2rem;">
            <h1>Universidade Inteligente</h1>
        </div>
    </div>

   

    <div class="container">
        
        <div class="row" id="sensor-data">
            <div class='col-12 d-flex justify-content-center'>
                <div class='card webcam'>
                    <div class="card-header text-center">
                        Security Cam
                    </div>
                    <div class="card-body webcam">
                        <div class="video-container">
                            <video id="webcam" autoplay></video>
                        </div>
                    </div>
                    <div class="card-footer webcam">
                        <button id="startButton" class="btn btn-primary">Start Security Cam</button>
                        <button id="stopButton" class="btn btn-danger">Stop  Security Cam</button>
                    </div>
                </div>
            </div>
            <div class="row" id="sensor-data">
                
            </div>
            <?php
            function reloadData()
            {
                $iterator = new DirectoryIterator("api/files/");
                $directories = array();


                foreach ($iterator as $fileinfo) {

                    if ($fileinfo->isDir() && !$fileinfo->isDot()) {
                        $directories[] = strtolower($fileinfo->getFilename());
                    }
                }
                // Loop através de cada diretório
                foreach ($directories as $directory) {
                    $formattedDir = __DIR__ . "\\api\\files\\" . $directory;
                    $hora = file_get_contents($formattedDir . "/hora.txt");
                    $nome = file_get_contents($formattedDir . "/nome.txt");
                    $valor = file_get_contents($formattedDir . "/valor.txt");
                    $imagefileName = ReturnFirstImageFileOfADirectory($formattedDir);

                    $formattedDirImage = "";
                    if (!isset($imagefileName)) {
                        $formattedDirImage = "./images/unloaded_image.svg";
                    } else {
                        $formattedDirImage = "./api/files/" . $directory . "/" . $imagefileName;
                    }

                    switch ($nome) {
                        //This needs to send before post on sensor code.
                        case 'cancela':
                            if ($valor <= 0) {
                                $valor = "Fechado";
                            } else {
                                $valor = "Aberto";
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

                    // Gerar o HTML dos cards
                    echo "
                                <div class='col-lg-4 col-md-6 col-sm-12 d-flex justify-content-center'>
                                    <div class='card text-center' id='{$directory}'>
                                        <img class='imgDashboard sensor-image'  src={$formattedDirImage}  alt='dashboard img'>
                                        <div class='card-body border-0'>
                                            <div class='card-title'>{$nome}</div>
                                            <span class='badge rounded-pill text-bg-warning mb-10 sensor-value'>{$valor}</span>
                                            <p class='mt-3 sensor-time'>{$hora}</p>
                                            <a class='btn btn-primary' href='historico.php?nome={$directory}'>Histórico</a>
                                        </div>
                                    </div>
                                </div>";
                }
            }

            reloadData();
            ?>
            </php>
        </div>

        <div class="row justify-content-center">

            <div class="col-15 mt-5">
                <div class="opacity-100%">
                    <div class="card text-center">
                        <div class="card-header">
                            <h3>Tabela de sensores</h3>
                        </div>
                        <div class="card-body">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">Tipo de Dispotivo IoT</th>
                                        <th scope="col">Valor</th>
                                        <th scope="col">Data de Atualização</th>
                                        <th scope="col">Estado de Alertas</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <!-- Data from files -->
                                        <td><?php echo $nome_temperatura ?> </td>
                                        <td><?php echo $valor_temperatura ?></td>
                                        <td><?php echo $hora_temperatura ?>
                                        <td>
                                            <span class="badge rounded-pill text-bg-warning">Primary</span>
                                    </tr>

                                    <tr>
                                        <td>Humidade</td>
                                        <td>70%</td>
                                        <td>2024/04/10 14:31
                                        <td>
                                            <span class="badge rounded-pill text-bg-primary">Primary</span>
                                    </tr>

                                    <tr>
                                        <td>LedArduino</td>
                                        <td>Ligado</td>
                                        <td>2024/04/10 14:31
                                        <td>
                                            <span class="badge rounded-pill text-bg-success">Primary</span>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>
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

</html>