<?php
// Ensure that the request is a POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Receive the base64-encoded image data
    $imageData = $_POST['image'];

    // Remove the "data:image/jpeg;base64," prefix from the imageDataURL
    $imageData = str_replace('data:image/jpeg;base64,', '', $imageData);

    // Decode the base64-encoded image data
    $decodedImage = base64_decode($imageData);

    // Generate a unique filename for the image
    $filename = 'image_' . uniqid() . '.jpg';

    // Specify the directory where the image will be saved
    $savePath = __DIR__.'/api/security/' . $filename;

    // Save the image to the specified path
    $fileSaved = file_put_contents($savePath, $decodedImage);

    if ($fileSaved !== false) {
        // Respond with success message or any other relevant data
        echo json_encode(['message' => 'Image saved successfully', 'filename' => $filename]);
    } else {
        // Respond with error message
        http_response_code(500);
        echo json_encode(['error' => 'Failed to save image']);
    }
} else {
    // Respond with error for non-POST requests
    http_response_code(405); // Method Not Allowed
    echo json_encode(['error' => 'Method not allowed']);
}
?>
