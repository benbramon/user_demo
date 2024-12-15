<?php

require_once 'Database.php';

class UserManager {
    private $pdo;

    public function __construct() {
        $db = Database::getInstance();
        $this->pdo = $db->getConnection();
    }

    public function createUser($firstName, $lastName, $email, $mobileNumber, $address, $city, $state, $zip) {
        $sql = "INSERT INTO users (first_name, last_name, email, mobile_number, address, city, state, zip, created)
                VALUES (:first_name, :last_name, :email, :mobile_number, :address, :city, :state, :zip, NOW())";

        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            ':first_name' => $firstName,
            ':last_name' => $lastName,
            ':email' => $email,
            ':mobile_number' => $mobileNumber,
            ':address' => $address,
            ':city' => $city,
            ':state' => $state,
            ':zip' => $zip,
        ]);
    }

    public function getUserById($id) {
        $sql = "SELECT * FROM users WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch();
    }

    public function getAllUsers() {
        $sql = "SELECT * FROM users";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll();
    }

    public function updateUser($id, $firstName, $lastName, $email, $mobileNumber, $address, $city, $state, $zip) {
        $sql = "UPDATE users
                SET first_name = :first_name, last_name = :last_name, email = :email, 
                    mobile_number = :mobile_number, address = :address, city = :city, 
                    state = :state, zip = :zip, last_updated = NOW()
                WHERE id = :id";

        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            ':id' => $id,
            ':first_name' => $firstName,
            ':last_name' => $lastName,
            ':email' => $email,
            ':mobile_number' => $mobileNumber,
            ':address' => $address,
            ':city' => $city,
            ':state' => $state,
            ':zip' => $zip,
        ]);
    }

    public function deleteUser($id) {
        $sql = "DELETE FROM users WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([':id' => $id]);
    }
}
?>
