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
    $files = glob($directory . '/*.{svg,png,jpg}', GLOB_BRACE);

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
    <link rel="stylesheet" href="./css/dashboard.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
 
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="icon" href="./src/logo.svg">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <!-- <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet"> -->
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
                <a href="security.php">Segurança</a>
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
                        Camara Entrada
                    </div>
                    <div class="card-body webcam">
                        <div class="video-container">
                            <video id="webcam" autoplay></video>
                        </div>
                    </div>
                    <div class="card-footer webcam">
                        <button id="startButton" class="btn btn-primary">Iniciar Camara</button>
                        <button id="stopButton" class="btn btn-danger">Pausar Camara</button>
                        <button id="captureButton" class="btn btn-success">Capturar Imagem</button>
                    </div>
                </div>
            </div>


            <div class="row" id="sensor-data">
            </div>
            <h2 class="section-title  text-center">Sensores</h2>
            <div id="sensors-section" class="row"></div>

            <h2 class="section-title  text-center mt-20">Atuadores</h2>
            <div id="actuators-section" class="row"></div>

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

                $sensorsHtml = '';
                $actuatorsHtml = '';


                //$startWebcam = false; // Flag to start the webcam
                // Loop through each directory
                foreach ($directories as $directory) {

                    $formattedDir = __DIR__ . "\\api\\files\\" . $directory;
                    $hora = file_get_contents($formattedDir . "/hora.txt");
                    $nome = file_get_contents($formattedDir . "/nome.txt");
                    $valor = file_get_contents($formattedDir . "/valor.txt");
                    $tipo = file_get_contents($formattedDir . "/tipo.txt");
                    $imagefileName = ReturnFirstImageFileOfADirectory($formattedDir);



                    //Actuators Evemts
                    switch ($nome) {
                        //This needs to send before post on sensor code.
                        case 'cancela':
                            $nome = "Cancela Eletrônica";
                            if ($valor <= 0) {
                                $valor = "Fechado";
                                $imagefileName = "barrier_closed.svg";
                            } else {
                                $valor = "Aberto";
                                $imagefileName = "barrier_open.svg";
                            }
                            break;
                        case 'luminosidade':
                            $nome = "LED";
                            if ($valor >= 1) {
                                $valor = "Ligado";
                                $imagefileName = "lamp-on.svg";
                            } else {
                                $valor = "Desligado";
                                $imagefileName = "lamp-off.svg";
                            }
                            break;
                        case 'fumaca':
                            $nome = "Fumo";
                            if ($valor >= 1) {
                                $valor = "Ativado";
                            } else {
                                $valor = "Desativado";
                            }
                            break;
                        case 'movimento':
                            if ($valor >= 1) {
                                $valor = "Ativado";
                                $startWebcam = true; // Set flag to true when movimento is >= 1
                            } else {
                                $valor = "Desativado";
                            }
                            break;
                        case 'sprinkler':
                            if ($valor >= 1) {
                                $valor = "Ativado";
                                $imagefileName = "sprinkler-on.svg";
                            } else {
                                $valor = "Desativado";
                                $imagefileName = "sprinkler-off.svg";
                            }
                            break;
                        case 'porta':
                            if ($valor >= 1) {
                                $valor = "Aberta";
                                $imagefileName = "door-opened.svg";
                            } else {
                                $valor = "Fechada";
                                $imagefileName = "door-closed.svg";
                            }
                            break;
                    }

                    $formattedDirImage = "";
                    if (!isset($imagefileName)) {
                        $formattedDirImage = "./images/unloaded_image.svg";
                    } else {
                        $formattedDirImage = "./api/files/" . $directory . "/" . $imagefileName;
                    }

                    $nome = ucfirst($nome);

                    // Generate the card HTML
                    $cardHtml = "
                            <div class='col-lg-4 col-md-6 col-sm-12 d-flex justify-content-center'>
                                <div class='card text-center' id='{$directory}'>
                                    <span class='badge rounded-pill text-bg-warning mb-10 sensor-value'>{$valor}</span>
                                    <img class='imgDashboard sensor-image' src='{$formattedDirImage}' alt='dashboard img'>
                                    <div class='card-body border-0'>
                                        <div class='card-title custom-title'>{$nome}</div>
                                        <p class='mt-3 sensor-time'>{$hora}</p>
                                        <a class='btn btn-primary' href='historico.php?nome={$directory}'>Histórico</a>
                                    </div>
                                </div>
                            </div>";

                    if ($tipo == 1) { // Sensors
                        $sensorsHtml .= $cardHtml;
                    } else { // Actuators
                        $actuatorsHtml .= $cardHtml;
                    }
                }

                echo "<script>
                    document.getElementById('sensors-section').innerHTML = `{$sensorsHtml}`;
                    document.getElementById('actuators-section').innerHTML = `{$actuatorsHtml}`;
                    
                    </script>";
            }


            reloadData();
            ?>
        </div>


    </div>

</body>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
<script>
    function updateDashboard() {
        $.ajax({
            url: 'fetch_data.php',
            method: 'GET',
            dataType: 'json',
            success: function (data) {
                console.log("Data fetched successfully:", data);
                data.forEach(function (sensor) {
                    $(`#${sensor.id} .sensor-value`).text(sensor.valor);
                    $(`#${sensor.id} .sensor-time`).text(sensor.hora);
                    $(`#${sensor.id} .sensor-image`).attr('src', sensor.image);

                    if (sensor.nome === 'movimento' && sensor.valor >= 1) {
                        startWebcam(); // Start webcam when movimento is detected
                    }
                });
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.error("Error fetching data:", textStatus, errorThrown);
            }
        });
    }

    $(document).ready(function () {
        updateDashboard();
        setInterval(updateDashboard, 2000);
    });


    const video = document.getElementById('webcam');
    const startButton = document.getElementById('startButton');
    const stopButton = document.getElementById('stopButton');
    const captureButton = document.getElementById('captureButton');
    const imageList = document.getElementById('imageList');
    const ajaxUrl = 'fetch_data.php'; // Replace with your fetch URL

    let captureInterval;

    function startWebcam() {
        navigator.mediaDevices.getUserMedia({ video: true })
            .then(stream => {
                video.srcObject = stream;
            })
            .catch(error => {
                console.error('Error accessing webcam: ', error);
            });
    }

    function stopWebCam() {
        const stream = video.srcObject;
        if (stream) {
            const tracks = stream.getTracks();
            tracks.forEach(track => track.stop());
            video.srcObject = null;
        }
    }

    function captureImage() {
        const canvas = document.createElement('canvas');
        canvas.width = video.videoWidth;
        canvas.height = video.videoHeight;
        canvas.getContext('2d').drawImage(video, 0, 0, canvas.width, canvas.height);
        const imageDataURL = canvas.toDataURL('image/jpeg');

        // Create image element and append to imageList
        // const imgElement = document.createElement('img');
        // imgElement.src = imageDataURL;
        // imgElement.classList.add('col-md-3', 'my-2');
        // imageList.appendChild(imgElement);
        // AJAX POST request to save image on the server
        const dateNow = new Date().toISOString();
        $.ajax({
            url: 'save_image.php',
            method: 'POST',
            data: {
                image: imageDataURL
            },
            success: function (response) {
                console.log('Image saved successfully:', response);
            },
            error: function (xhr, status, error) {
                console.error('Error saving image:', error);
            }
        });

    }


    startButton.addEventListener('click', startWebcam);
    stopButton.addEventListener('click', stopWebCam);
    captureButton.addEventListener('click', captureImage);

    // Start fetching data and capturing images every 5 seconds
    // 

    fetchDataAndCapture(); // Initial fetch
    captureInterval = setInterval(fetchDataAndCapture, 2000); // Fetch every 5 seconds

</script>

</html>