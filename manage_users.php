<?php
require_once 'UserManager.php';

$userManager = new UserManager();

try {
    $users = $userManager->findAll();
} catch (Exception $e) {
    $errorMessage = $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Users</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<header>
    <h1>Manage Users</h1>
</header>
<div class="container">
    <a class="btn" href="create_user.php">Create New User</a>
    <?php if (isset($errorMessage)): ?>
        <div class="error-messages" style="color: red; margin-bottom: 20px;">
            <?= $errorMessage ?>
        </div>
    <?php else: ?>
        <table>
            <thead>
            <tr>
                <th>ID</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Email</th>
                <th>Mobile Number</th>
                <th>Date Added</th>
                <th>Last Modified</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($users as $user): ?>
                <tr>
                    <td><?= htmlspecialchars($user->getId()) ?></td>
                    <td><?= htmlspecialchars($user->getFirstName()) ?></td>
                    <td><?= htmlspecialchars($user->getLastName()) ?></td>
                    <td><?= htmlspecialchars($user->getEmail()) ?></td>
                    <td><?= htmlspecialchars($user->getMobileNumber()) ?></td>
                    <td><?= htmlspecialchars($user->getCreatedDate()) ?></td>
                    <td><?= htmlspecialchars($user->getUpdatedDate()) ?></td>
                    <td>
                        <a href="edit_user.php?id=<?= htmlspecialchars($user->getId()) ?>">Edit</a>
                        <a href="delete_user.php?id=<?= htmlspecialchars($user->getId()) ?>"
                           onclick="return confirm('Are you sure you want to delete this user?');">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>
</body>
</html>
