<?php
require_once 'UserManager.php';
require_once 'Database.php';

$userManager = new UserManager();

$errorMessages = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $user = new User();
        $user->setFirstName($_POST['first_name']);
        $user->setLastName($_POST['last_name']);
        $user->setEmail($_POST['email']);
        $user->setMobileNumber($_POST['mobile_number']);
        $user->setAddress($_POST['address']);
        $user->setCity($_POST['city']);
        $user->setState($_POST['state']);
        $user->setZip($_POST['zip']);

        $userManager->create($user);
        header("Location: manage_users.php");
        exit;
    } catch (Exception $e) {
        $errorMessages = $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create New User</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<header>
    <h1>Create New User</h1>
</header>
<div class="container">
    <?php if (!empty($errorMessages)): ?>
        <div class="error-messages" style="color: red; margin-bottom: 20px;">
            <?= $errorMessages ?>
        </div>
    <?php endif; ?>

    <form action="create_user.php" method="POST">
        <label for="first_name">First Name</label>
        <input type="text" id="first_name" name="first_name" value="<?= htmlspecialchars($_POST['first_name'] ?? '') ?>" required>
        <label for="last_name">Last Name</label>
        <input type="text" id="last_name" name="last_name" value="<?= htmlspecialchars($_POST['last_name'] ?? '') ?>" required>
        <label for="email">Email</label>
        <input type="email" id="email" name="email" value="<?= htmlspecialchars($_POST['email'] ?? '') ?>" required>
        <label for="mobile_number">Mobile Number</label>
        <input type="text" id="mobile_number" name="mobile_number" value="<?= htmlspecialchars($_POST['mobile_number'] ?? '') ?>" required>
        <label for="address">Address</label>
        <input type="text" id="address" name="address" value="<?= htmlspecialchars($_POST['address'] ?? '') ?>" required>
        <label for="city">City</label>
        <input type="text" id="city" name="city" value="<?= htmlspecialchars($_POST['city'] ?? '') ?>" required>
        <label for="state">State</label>
        <input type="text" id="state" name="state" value="<?= htmlspecialchars($_POST['state'] ?? '') ?>" required>
        <label for="zip">Zip Code</label>
        <input type="text" id="zip" name="zip" value="<?= htmlspecialchars($_POST['zip'] ?? '') ?>" required>
        <button class="btn" type="submit">Create User</button>
    </form>
    <br>
    <a class="btn" href="manage_users.php">Back to Manage Users</a>
</div>
</body>
</html>
