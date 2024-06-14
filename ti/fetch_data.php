<?php

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
        $imagefileName = ReturnFirstImageFileOfADirectory($formattedDir);

        if(!isset($imagefileName)){
            $formattedDirImage = "./images/unloaded_image.svg";
        } else {
            $formattedDirImage = "./api/files/" . $directory . "/" . $imagefileName;
        }

        switch ($nome) {
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


        $sensorData[] = [
            'id' => $directory,
            'nome' => $nome,
            'valor' => $valor,
            'hora' => $hora,
            'image' => $formattedDirImage
        ];
    }

    return $sensorData;
}

header('Content-Type: application/json');
echo json_encode(fetchSensorData());

?>