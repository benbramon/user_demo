<?php
require_once 'UserManager.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $firstName = $_POST['first_name'];
    $lastName = $_POST['last_name'];
    $email = $_POST['email'];
    $mobileNumber = $_POST['mobile_number'];
    $address = $_POST['address'];
    $city = $_POST['city'];
    $state = $_POST['state'];
    $zip = $_POST['zip'];

    try {
        $userManager = new UserManager();
        $userManager->createUser($firstName, $lastName, $email, $mobileNumber, $address, $city, $state, $zip);
        header("Location: manage_users.php");
        exit;
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
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
    <form action="create_user.php" method="POST">
        <label for="first_name">First Name</label>
        <input type="text" id="first_name" name="first_name" required>

        <label for="last_name">Last Name</label>
        <input type="text" id="last_name" name="last_name" required>

        <label for="email">Email</label>
        <input type="email" id="email" name="email" required>

        <label for="mobile_number">Mobile Number</label>
        <input type="text" id="mobile_number" name="mobile_number" required>

        <label for="address">Address</label>
        <input type="text" id="address" name="address" required>

        <label for="city">City</label>
        <input type="text" id="city" name="city" required>

        <label for="state">State</label>
        <input type="text" id="state" name="state" required>

        <label for="zip">Zip Code</label>
        <input type="text" id="zip" name="zip" required>

        <button class="btn" type="submit">Create User</button>
    </form>
    <br>
    <a class="btn" href="manage_users.php">Back to Manage Users</a>
</div>
</body>
</html>
