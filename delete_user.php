<?php
require_once 'UserManager.php';

if (isset($_GET['id'])) {
    try {
        $userManager = new UserManager();
        $userManager->deleteUser($_GET['id']);
        header("Location: manage_users.php");
        exit;
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }
} else {
    echo "Invalid request.";
}
