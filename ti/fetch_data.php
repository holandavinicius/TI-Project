<?php

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
function fetchSensorData()
{
    $iterator = new DirectoryIterator("api/files/");
    $directories = array();
    foreach ($iterator as $fileinfo) {

        if ($fileinfo->isDir() && !$fileinfo->isDot()) {
            $directories[] = strtolower($fileinfo->getFilename());
        }
    }

    $sensorData = [];

    foreach ($directories as $directory) {
        $formattedDir = __DIR__ . "/api/files/" . $directory;

        $hora = file_get_contents($formattedDir . "/hora.txt");
        $nome = file_get_contents($formattedDir . "/nome.txt");
        $valor = file_get_contents($formattedDir . "/valor.txt");
        $tipo = file_get_contents($formattedDir . "/tipo.txt");
        $imagefileName = ReturnFirstImageFileOfADirectory($formattedDir);


        switch ($nome) {
            //This needs to send before post on sensor code.
            case 'cancela':
                $nome = "Cancela Eletrônica";
                if ($valor <= 0) {
                    $valor = "Fechado";
                    $imagefileName = "barrier-closed.svg";
                } else {
                    $valor = "Aberto";
                    $imagefileName = "barrier-open.svg";
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
                } else {
                    $valor = "Desativado";
                }
                break;
            case 'sprinkler':
                if ($valor >= 1) {
                    $valor = "Ativado";
                } else {
                    $valor = "Desativado";
                }
                break;
        }

        if (!isset($imagefileName)) {
            $formattedDirImage = "./images/unloaded_image.svg";
        } else {
            $formattedDirImage = "./api/files/" . $directory . "/" . $imagefileName;
        }


        $sensorData[] = [
            'id' => $directory,
            'nome' => $nome,
            'valor' => $valor,
            'hora' => $hora,
            'image' => $formattedDirImage,
        ];
    }

    return $sensorData;
}

header('Content-Type: application/json');
echo json_encode(fetchSensorData());

?>