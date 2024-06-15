<?php
$imagesFolder = __DIR__.'/api/security/';

// Initialize array to hold image data
$imageList = array();

// Scan the directory for image files
$files = scandir($imagesFolder);

// Iterate through files
foreach ($files as $file) {
    if (in_array($file, array('.', '..'))) {
        continue; // Skip current and parent directory entries
    }

    // Get file modification time (datetime)
    $dateTime = date("Y-m-d H:i:s", filemtime($imagesFolder . $file));

    // Add image data to the list
    $imageList[] = array(
        'fileName' => $file,
        'dateTime' => $dateTime,
    );
}

// Output JSON formatted data
header('Content-Type: application/json');
echo json_encode($imageList);
?>