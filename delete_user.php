<?php
require_once 'UserManager.php';

$userManager = new UserManager();

$errorMessages = "";

if (isset($_GET['id'])) {
    try {
        $user = $userManager->findById($_GET['id']);
        if (!$user) {
            throw new Exception("User not found.");
        }

        $userManager->delete($user->getId());
        header("Location: manage_users.php?message=User successfully deleted.");
        exit;
    } catch (Exception $e) {
        $errorMessages = $e->getMessage();
    }
} else {
    $errorMessages = "Invalid request. User ID is missing.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete User</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<header>
    <h1>Delete User</h1>
</header>
<div class="container">
    <?php if (!empty($errorMessages)): ?>
        <div class="error-messages" style="color: red; margin-bottom: 20px;">
            <?= htmlspecialchars($errorMessages) ?>
        </div>
    <?php endif; ?>
    <a class="btn" href="manage_users.php">Back to Manage Users</a>
</div>
</body>
</html>
