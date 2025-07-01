<?php
session_start();

if (isset($_GET['id'])) {
    $product_id = $_GET['id'];

    // Loop through the cart and remove the product
    foreach ($_SESSION['cart'] as $key => $item) {
        if ($item['id'] == $product_id) {
            unset($_SESSION['cart'][$key]);
            break;
        }
    }

    // Reindex the cart array and redirect back to the cart page
    $_SESSION['cart'] = array_values($_SESSION['cart']);
    header("Location: cart.php");
    exit();
}
?>
