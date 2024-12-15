<?php
require_once 'UserManager.php';

try {
    $userManager = new UserManager();
    $users = $userManager->getAllUsers();
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
    die();
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
    <a href="create_user.php" class="btn">Create New User</a>
    <table>
        <thead>
        <tr>
            <th>ID</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Email</th>
            <th>Mobile Number</th>
            <th>Address</th>
            <th>City</th>
            <th>State</th>
            <th>Zip</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        <?php if (!empty($users)): ?>
            <?php foreach ($users as $user): ?>
                <tr>
                    <td><?= htmlspecialchars($user['id']) ?></td>
                    <td><?= htmlspecialchars($user['first_name']) ?></td>
                    <td><?= htmlspecialchars($user['last_name']) ?></td>
                    <td><?= htmlspecialchars($user['email']) ?></td>
                    <td><?= htmlspecialchars($user['mobile_number']) ?></td>
                    <td><?= htmlspecialchars($user['address']) ?></td>
                    <td><?= htmlspecialchars($user['city']) ?></td>
                    <td><?= htmlspecialchars($user['state']) ?></td>
                    <td><?= htmlspecialchars($user['zip']) ?></td>
                    <td class="actions">
                        <a href="edit_user.php?id=<?= htmlspecialchars($user['id']) ?>">Edit</a>
                        <a href="delete_user.php?id=<?= htmlspecialchars($user['id']) ?>"
                           onclick="return confirm('Are you sure you want to delete this user?');">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="10">No users found.</td>
            </tr>
        <?php endif; ?>
        </tbody>
    </table>
</div>
</body>
</html>
