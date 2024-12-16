<?php
require_once 'UserManager.php';
require_once 'Database.php';

$userManager = new UserManager();

$errorMessages = "";
$user = null;

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
    try {
        $user = $userManager->findById($_GET['id']);
        if (!$user) {
            throw new Exception("User not found.");
        }
    } catch (Exception $e) {
        $errorMessages = $e->getMessage();
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $user = $userManager->findById($_POST['id']);
        if (!$user) {
            throw new Exception("User not found.");
        }
        $user->setFirstName($_POST['first_name']);
        $user->setLastName($_POST['last_name']);
        $user->setEmail($_POST['email']);
        $user->setMobileNumber($_POST['mobile_number']);
        $user->setAddress($_POST['address']);
        $user->setCity($_POST['city']);
        $user->setState($_POST['state']);
        $user->setZip($_POST['zip']);

        $userManager->update($user);
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
    <title>Edit User</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<header>
    <div class="page-header">
        <img src="profile.png" alt="Profile Icon">
        <h1>Edit User</h1>
    </div>
</header>
<div class="container">
    <?php if (!empty($errorMessages)): ?>
        <div class="error-messages" style="color: red; margin-bottom: 20px;">
            <?= $errorMessages ?>
        </div>
    <?php endif; ?>

    <?php if ($user): ?>
        <form action="edit_user.php" method="POST">
            <input type="hidden" name="id" value="<?= htmlspecialchars($user->getId()) ?>">
            <label for="first_name">First Name</label>
            <input type="text" id="first_name" name="first_name" value="<?= htmlspecialchars($user->getFirstName()) ?>" required>
            <label for="last_name">Last Name</label>
            <input type="text" id="last_name" name="last_name" value="<?= htmlspecialchars($user->getLastName()) ?>" required>
            <label for="email">Email</label>
            <input type="email" id="email" name="email" value="<?= htmlspecialchars($user->getEmail()) ?>" required>
            <label for="mobile_number">Mobile Number</label>
            <input type="text" id="mobile_number" name="mobile_number" value="<?= htmlspecialchars($user->getMobileNumber()) ?>" required>
            <label for="address">Address</label>
            <input type="text" id="address" name="address" value="<?= htmlspecialchars($user->getAddress()) ?>" required>
            <label for="city">City</label>
            <input type="text" id="city" name="city" value="<?= htmlspecialchars($user->getCity()) ?>" required>
            <label for="state">State</label>
            <input type="text" id="state" name="state" value="<?= htmlspecialchars($user->getState()) ?>" required>
            <label for="zip">Zip Code</label>
            <input type="text" id="zip" name="zip" value="<?= htmlspecialchars($user->getZip()) ?>" required>
            <button class="btn" type="submit">Save Changes</button>
        </form>
    <?php endif; ?>
    <br>
    <a class="btn" href="manage_users.php">Back to Manage Users</a>
</div>
</body>
</html>
