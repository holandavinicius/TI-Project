<?php 


require_once($_SERVER["DOCUMENT_ROOT"]."/ti/api/device_data_interface.php");
require_once($_SERVER["DOCUMENT_ROOT"]."/ti/api/device_data_model.php");
require_once($_SERVER["DOCUMENT_ROOT"]."/ti/api/device_data_service.php");

session_start();



if (!isset($_SESSION['username'])) {
    header("refresh:60;url=index.php");
    die("Access denied.");
}

const STemperatura = "temperatura";
const SLuminosidade = "luminosidade";
const SHumidade = "humidade";
const ACancelaSinalizacao = "cancela";
const APortaAutomatica = "porta";
const AEsteiraTabuleiros = "esteira";

$deviceService = new DeviceDataService();


$sTempSensorData = $deviceService->ProcessDataGet(STemperatura);
$sLightSensorData = $deviceService->ProcessDataGet(SLuminosidade);
$sHumiditySensorData = $deviceService->ProcessDataGet(SHumidade);


$aBarrierActuadorData = $deviceService->ProcessDataGet(ACancelaSinalizacao);
$aDoorActuadorData = $deviceService->ProcessDataGet(APortaAutomatica);
$aTrayActuadorData = $deviceService->ProcessDataGet(AEsteiraTabuleiros);

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="icon" href="./src/logo.svg">
    <link rel="stylesheet" href="./css/dashboard.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

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
                <button
                    data-mdb-button-init data-mdb-ripple-init data-mdb-dropdown-init class="btn btn-primary-outline dropdown-toggle"
                    type="button"
                    id="dropdownMenuButton"
                    data-mdb-toggle="dropdown"
                    aria-expanded="true"
                >
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
            <div class="col-lg-4 col-md-6 col-sm-12 d-flex justify-content-center">
                <div class="card text-center">
                    <img class="imgDashboard" src="./images/temperature.svg" style="width: auto; height: 150px;" alt="dashboard img">
                    <div class="card-body border-0">
                        <div class="card-title">Temperatura</div>
                        <span class="badge rounded-pill text-bg-warning mb-10"><?php echo $sTempSensorData->getValue().'Cº'?></span>
                        <p class="mt-3"><?php echo $sTempSensorData->getTime()?></p>
                        <a href="historico.php?nome=temperatura">
                            <button class="btn btn-primary">Historico</button>
                        </a>
                    </div>
                </div>
            </div>


            <div class="col-lg-4 col-md-6 col-sm-12 d-flex justify-content-center">
            <div class="card text-center">
                    <img class="imgDashboard" src="./images/humidity.svg" style="width: auto; height: 150px;" alt="dashboard img">
                    <div class="card-body border-0">
                        <div class="card-title">Humidade</div>
                        <span class="badge rounded-pill text-bg-warning mb-10"><?php echo $sHumiditySensorData->getValue()?></span>
                        <p class="mt-3"><?php echo $sHumiditySensorData->getTime()?></p>
                        <a href="historico.php?nome=temperatura">
                            <button class="btn btn-primary">Historico</button>
                        </a>
                    </div>
                </div>
            </div>


            <div class="col-lg-4 col-md-6 col-sm-12 d-flex justify-content-center">
            <div class="card text-center">
                    <img class="imgDashboard" src="./images/light.svg" style="width: auto; height: 150px;" alt="dashboard img">
                    <div class="card-body border-0">
                        <div class="card-title">Luminosidade</div>
                        <span class="badge rounded-pill text-bg-warning mb-10"><?php echo $sLightSensorData->getValue()?></span>
                        <p class="mt-3"><?php echo $sLightSensorData->getTime()?></p>
                        <a href="historico.php?nome=temperatura">
                            <button class="btn btn-primary">Historico</button>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
        <div class="col-lg-4 col-md-6 col-sm-12 d-flex justify-content-center">
            <div class="card text-center">
                    <img class="imgDashboard" src="./images/gate.svg" style="width: auto; height: 150px;" alt="dashboard img">
                    <div class="card-body border-0">
                        <div class="card-title">Cancela</div>
                        <span class="badge rounded-pill text-bg-warning mb-10"><?php echo $aBarrierActuadorData->getValue()?></span>
                        <p class="mt-3"><?php echo $aBarrierActuadorData->getTime()?></p>
                        <a href="historico.php?nome=temperatura">
                            <button class="btn btn-primary">Historico</button>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-12 d-flex justify-content-center">
                <div class="card text-center">
                    <img class="imgDashboard" src="./images/door.svg" style="width: auto; height: 150px;" alt="dashboard img">
                    <div class="card-body border-0">
                        <div class="card-title">Porta Automática</div>
                        <span class="badge rounded-pill text-bg-warning mb-10"><?php echo $aDoorActuadorData->getValue()?></span>
                        <p class="mt-3"><?php echo $sTempSensorData->getTime()?></p>
                        <a href="historico.php?nome=temperatura">
                            <button class="btn btn-primary">Historico</button>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-12 d-flex justify-content-center">
            <div class="card text-center">
                    <img class="imgDashboard" src="./images/belt.svg" style="width: auto; height: 150px;" alt="dashboard img">
                    <div class="card-body border-0">
                        <div class="card-title">Esteira de Tabuleiros</div>
                        <span class="badge rounded-pill text-bg-warning mb-10"><?php echo $aTrayActuadorData->getValue()?></span>
                        <p class="mt-3"><?php echo $aTrayActuadorData->getTime()?></p>
                        <a href="historico.php?nome=temperatura">
                            <button class="btn btn-primary">Historico</button>
                        </a>
                    </div>
                </div>
            </div>
        </div>
      
        </div>
        <div class="row justify-content-center m-0">
            <div class="col-sm-12 col-md-8 mt-5">
                <table class="table table-borderless">
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
                            <td><?php echo $sTempSensorData->getName()?></td>
                            <td><?php echo $sTempSensorData->getValue()?></td>
                            <td><?php echo $sTempSensorData->getTime()?></td>
                            <td><span class="badge rounded-pill text-bg-warning">Primary</span></td>
                        </tr>
                        <tr>
                            <td><?php echo $sHumiditySensorData->getName()?></td>
                            <td><?php echo $sHumiditySensorData->getValue()?></td>
                            <td><?php echo $sHumiditySensorData->getTime()?></td>
                            <td><span class="badge rounded-pill text-bg-primary">Primary</span></td>
                        </tr>

                        <tr>
                            <td><?php echo $sLightSensorData->getName()?></td>
                            <td><?php echo $sLightSensorData->getValue()?></td>
                            <td><?php echo $sLightSensorData->getTime()?></td>
                            <td><span class="badge rounded-pill text-bg-success">Primary</span></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
<footer>
    <br>
</footer>
<script src=" https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
</script>
</html>