<?php
session_start();
include('db.php');

// Check if the company is logged in
if (!isset($_SESSION['company_id'])) {
    header("Location: company_login.php");
    exit();
}

// Get the company ID from the session
$company_id = $_SESSION['company_id'];

// Check if the card ID is provided in the URL
if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("Card ID is required.");
}

// Get the card ID from the URL
$card_id = (int) $_GET['id'];

// Check if the card exists and belongs to the logged-in company
$card_query = $conn->query("SELECT * FROM cards WHERE id = $card_id AND company_id = $company_id");
if ($card_query->num_rows == 0) {
    die("Card not found or access denied.");
}

// Fetch the card details
$card = $card_query->fetch_assoc();

// Delete the card from the database
$delete_query = "DELETE FROM cards WHERE id = $card_id AND company_id = $company_id";
if ($conn->query($delete_query)) {
    // Redirect back to the dashboard or card list page
    header("Location: dashboard.php?message=Card deleted successfully.");
    exit();
} else {
    die("Error deleting card: " . $conn->error);
}
?>
