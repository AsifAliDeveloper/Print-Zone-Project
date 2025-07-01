<?php
// Fetch a sample item and logo
$item_image = 'items/sample_item.jpg'; // Example product image
$logo_path = $resized_logo_path;

// Load images
$item = imagecreatefromjpeg($item_image);
$logo = imagecreatefrompng($logo_path);

// Get dimensions
$item_width = imagesx($item);
$item_height = imagesy($item);
$logo_width = imagesx($logo);
$logo_height = imagesy($logo);

// Position logo at the bottom-right corner
$dest_x = $item_width - $logo_width - 10; // 10px margin
$dest_y = $item_height - $logo_height - 10;

// Merge images
imagecopy($item, $logo, $dest_x, $dest_y, 0, 0, $logo_width, $logo_height);

// Save the final image
$final_image_path = 'items/with_logo_' . basename($item_image);
imagejpeg($item, $final_image_path);

// Cleanup
imagedestroy($item);
imagedestroy($logo);
?>

<div class="container mt-5">
    <h3>Item with Logo</h3>
    <img src="<?= $final_image_path ?>" alt="Item with Logo" class="img-fluid">
</div>
