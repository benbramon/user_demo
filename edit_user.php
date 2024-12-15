<?php
require_once 'UserManager.php';

$userManager = new UserManager();

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
    $user = $userManager->getUserById($_GET['id']);
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userManager->updateUser(
        $_POST['id'],
        $_POST['first_name'],
        $_POST['last_name'],
        $_POST['email'],
        $_POST['mobile_number'],
        $_POST['address'],
        $_POST['city'],
        $_POST['state'],
        $_POST['zip']
    );
    header("Location: manage_users.php");
    exit;
} else {
    echo "Invalid request.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<header>
    <h1>Edit User</h1>
</header>
<div class="container">
    <form action="edit_user.php" method="POST">
        <input type="hidden" name="id" value="<?= htmlspecialchars($user['id']) ?>">

        <label for="first_name">First Name</label>
        <input type="text" id="first_name" name="first_name" value="<?= htmlspecialchars($user['first_name']) ?>" required>

        <label for="last_name">Last Name</label>
        <input type="text" id="last_name" name="last_name" value="<?= htmlspecialchars($user['last_name']) ?>" required>

        <label for="email">Email</label>
        <input type="email" id="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" required>

        <label for="mobile_number">Mobile Number</label>
        <input type="text" id="mobile_number" name="mobile_number" value="<?= htmlspecialchars($user['mobile_number']) ?>" required>

        <label for="address">Address</label>
        <input type="text" id="address" name="address" value="<?= htmlspecialchars($user['address']) ?>" required>

        <label for="city">City</label>
        <input type="text" id="city" name="city" value="<?= htmlspecialchars($user['city']) ?>" required>

        <label for="state">State</label>
        <input type="text" id="state" name="state" value="<?= htmlspecialchars($user['state']) ?>" required>

        <label for="zip">Zip Code</label>
        <input type="text" id="zip" name="zip" value="<?= htmlspecialchars($user['zip']) ?>" required>

        <button class="btn" type="submit">Save Changes</button>
    </form>
    <br>
    <a class="btn" href="manage_users.php">Back to Manage Users</a>
</div>
</body>
</html>
