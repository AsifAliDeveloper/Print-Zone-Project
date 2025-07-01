<?php
// Include the database connection
include 'db.php';

// Fetch the user's uploaded logo
$result = $conn->query("SELECT * FROM user_logos WHERE user_id = 1 ORDER BY uploaded_at DESC LIMIT 1");
$logo = $result->fetch_assoc();
$logo_path = $logo['logo_path'];

// Resize the logo
$new_width = 150;
$new_height = 150;

$image_type = mime_content_type($logo_path);
if ($image_type == 'image/jpeg') {
    $source = imagecreatefromjpeg($logo_path);
} elseif ($image_type == 'image/png') {
    $source = imagecreatefrompng($logo_path);
}

$destination = imagecreatetruecolor($new_width, $new_height);
imagecopyresampled($destination, $source, 0, 0, 0, 0, $new_width, $new_height, imagesx($source), imagesy($source));

// Save the resized logo
$resized_logo_path = 'logos/resized_' . basename($logo_path);
if ($image_type == 'image/jpeg') {
    imagejpeg($destination, $resized_logo_path);
} elseif ($image_type == 'image/png') {
    imagepng($destination, $resized_logo_path);
}
imagedestroy($source);
imagedestroy($destination);
?>

<div class="container mt-5">
    <h3>Edited Logo</h3>
    <img src="<?= $resized_logo_path ?>" alt="Resized Logo">
</div>
