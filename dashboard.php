<?php 
// require_once("../ti/api/device_data_interface.php");
// require_once("../ti/api/device_data_model.php");
// require_once("../ti/api/device_data_service.php");

require_once("../ti/api/device_data_interface.php");
require_once("../ti/api/device_data_model.php");
require_once("../ti/api/device_data_service.php");

session_start();



if (!isset($_SESSION['username'])) {
    header("refresh:60;url=index.php");
    die("Acess denied.");
}

const Temperatura = "temperatura";
const Luminosidade = "luminosidade";
const Humidade = "humidade";

$deviceService = new DeviceDataService();


$tempSensorData = $deviceService->ProcessDataGet(Temperatura);
$lightSensorData = $deviceService->ProcessDataGet(Luminosidade);
$humiditySensorData = $deviceService->ProcessDataGet(Humidade);



?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="./css/dashboard.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

</head>

<body>
    
    <nav class="d-flex">
        <!-- Logo -->
        <div id="logo">
            <a href="dashboard.php">
                <img id="img" src="./src/logo.svg" alt="Logo">
            </a>
        </div>

        <!-- Menu Items -->
        <div id="menu">
            <!-- Menu Introduction -->
            <div class="menu-item menu-item-active">
                <a href="dashboard.php">
                    Home
                </a>
            </div>
            <!-- Courses -->
            <div class="menu-item">
                <a href="historico.php">
                    Histórico
                </a>
            </div>
        </div>
        <!-- User -->
        <div id="user">
            <div class="menu-item">
                <a href="logout.php" class="me-5">
                    Logout
                </a>
                <a href="profile.php">
                    <img src="./src/person.svg" id="userLogo">
                </a>
            </div>
        </div>
    </nav>
    
    <div class="container d-flex justify-content-around align-items-center">
        <div id="title-header" style="color: white;">
            <h1>Servidor IoT</h1>
            <h6>user: <?php echo $_SESSION['username'] ?><h6>
        </div>
    </div>


    <div class="container">
        <div class="row">
            <div class="col-lg-4 col-md-6 col-sm-12">
                <div class="card text-center">
                    <div class="card-header">
                        <h3>Temperatura: <?php echo $lightSensorData->getValue()?></h3>
                    </div>
                    <div class="card-body">
                        <img id="imgDashboard" src="./images/temperature-high.png" style="width: auto; height: 300px;">
                        <br>
                        <h6>Wifi: ON</h6>
                    </div>
                    <div class="card-footer d-inline-flex justify-content-center">
                        <?php echo "Atualização: ".substr($tempSensorData->getTime(),0,10)?>
                        <br><a href="../ti/historico.php">Histórico</a>
                    </div>
                </div>
            </div>


            <div class="col-lg-4 col-md-6 col-sm-12">
                <div class="card text-center">
                    <div class="card-header">
                        <h3>Humidade: <?php echo $humiditySensorData->getValue()?></h3>
                    </div>
                    <div class="card-body">
                        <img id="imgDashboard" src="./images/humidity-high.png" style="width: auto; height: 300px;">
                        <h6>Wifi: ON</h6>
                    </div>
                    <div class="card-footer d-inline-flex justify-content-center">
                        <?php echo "Atualização: ".substr($humiditySensorData->getTime(),0,10)?>v
                        <a href="../ti/historico.php">Histórico</a>
                    </div>
                </div>
            </div>


            <div class="col-lg-4 col-md-6 col-sm-12">
                <div class="card text-center">
                    <div class="card-header">
                        <h3>Luminosidade: <?php echo $lightSensorData->getValue()?></h3>
                    </div>
                    <div class="card-body bg-transparent border-light">
                        <img id="imgDashboard" src="./images/light-on.png" style="width: auto; height: 300px;">
                    </div>
                    <div class="card-footer d-inline-flex justify-content-center">
                        <?php echo "Atualização: ".substr($lightSensorData->getTime(),0,10)?>
                        <a href="../ti/historico.php">Histórico</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-4 col-md-6 col-sm-12">
                <div class="card text-center">
                    <div class="card-header">
                        <h3>ATUADOR 1</h3>
                    </div>
                    <div class="card-body">
                        <img id="imgDashboard" src="./src/wifi.svg" style="width: auto; height: 300px;">
                        <h6>Wifi: ON</h6>
                    </div>
                    <div class="card-footer d-inline-flex justify-content-center">
                        <p>06/04/2024 - </p>
                        <a href="../ti/historico.php">Histórico</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-12">
                <div class="card text-center">
                    <div class="card-header">
                        <h3>ATUADOR 2</h3>
                    </div>
                    <div class="card-body">
                        <img id="imgDashboard" src="./src/wifi.svg" style="width: auto; height: 300px;">
                        <h6>Wifi: ON</h6>
                    </div>
                    <div class="card-footer d-inline-flex justify-content-center">
                        <p>06/04/2024 - </p>
                        <a href="../ti/historico.php">Histórico</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-12">
                <div class="card text-center">
                    <div class="card-header">
                        <h3>ATUADOR 3</h3>
                    </div>
                    <div class="card-body bg-transparent border-light">
                        <img id="imgDashboard" src="./src/wifi.svg" style="width: auto; height: 300px;">
                        <h6>Wifi: ON</h6>
                    </div>
                    <div class="card-footer d-inline-flex justify-content-center">
                        <p>06/04/2024 - </p>
                        <a href="../ti/historico.php">Histórico</a>
                    </div>
                </div>
            </div>
        </div>
      
        </div>
        <div class="row justify-content-center">
            <div class="col-10 mt-5">
                <div class="card text-center">
                    <div class="card-header">
                        <h3>Tabela de Sensores</h3>
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
                                    <td><?php echo $tempSensorData->getName()?> </td>
                                    <td><?php echo $tempSensorData->getValue()?></td>
                                    <td><?php echo $tempSensorData->getTime()?></td>
                                    <td><span class="badge rounded-pill text-bg-warning">Primary</span></td>
                                </tr>
                                <tr>
                                    <td><?php echo $humiditySensorData->getName()?> </td>
                                    <td><?php echo $humiditySensorData->getValue()?></td>
                                    <td><?php echo $humiditySensorData->getTime()?></td>
                                    <td><span class="badge rounded-pill text-bg-primary">Primary</span></td>
                                </tr>

                                <tr>
                                    <td><?php echo $lightSensorData->getName()?> </td>
                                    <td><?php echo $lightSensorData->getValue()?></td>
                                    <td><?php echo $lightSensorData->getTime()?></td>
                                    <td><span class="badge rounded-pill text-bg-success">Primary</span></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>


        <div class="row justify-content-center">
            <div class="col-10 mt-5">
                <div class="card text-center">
                    <div class="card-header">
                        <h3>Tabela de Atuadores</h3>
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
                                    <td><?php echo $tempSensorData->getName()?> </td>
                                    <td><?php echo $tempSensorData->getValue()?></td>
                                    <td><?php echo $tempSensorData->getTime()?></td>
                                    <td><span class="badge rounded-pill text-bg-warning">Primary</span></td>
                                </tr>
                                <tr>
                                    <td><?php echo $humiditySensorData->getName()?> </td>
                                    <td><?php echo $humiditySensorData->getValue()?></td>
                                    <td><?php echo $humiditySensorData->getTime()?></td>
                                    <td><span class="badge rounded-pill text-bg-primary">Primary</span></td>
                                </tr>

                                <tr>
                                    <td><?php echo $lightSensorData->getName()?> </td>
                                    <td><?php echo $lightSensorData->getValue()?></td>
                                    <td><?php echo $lightSensorData->getTime()?></td>
                                    <td><span class="badge rounded-pill text-bg-success">Primary</span></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>
<script src=" https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
</script>

</html>