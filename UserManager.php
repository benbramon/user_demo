<?php

require_once 'Database.php'; // Include the Database class
include 'User.php';

class UserManager {
    private $pdo;

    public function __construct() {
        $db = Database::getInstance();
        $this->pdo = $db->getConnection();
    }

    // Fetch a user by ID
    public function findById($id) {
        $stmt = $this->pdo->prepare('SELECT * FROM users WHERE id = :id');
        $stmt->execute([':id' => $id]);
        $row = $stmt->fetch();
        if ($row) {
            return $this->mapToUser($row);
        }
        return null;
    }

    // Fetch all users
    public function findAll() {
        $stmt = $this->pdo->query('SELECT * FROM users');
        $rows = $stmt->fetchAll();
        $users = [];
        foreach ($rows as $row) {
            $users[] = $this->mapToUser($row);
        }
        return $users;
    }

    // Create a new user
    public function create(User $user) {
        $errors = $this->validate($user);
        if (!empty($errors)) {
            throw new Exception(implode("<br>", $errors));
        }

        $stmt = $this->pdo->prepare('
            INSERT INTO users (first_name, last_name, email, mobile_number, address, city, state, zip, created)
            VALUES (:first_name, :last_name, :email, :mobile_number, :address, :city, :state, :zip, NOW())
        ');
        $stmt->execute($this->mapToParams($user));
    }

    // Update an existing user
    public function update(User $user) {
        $user = $this->findById($user->getId());
        if (empty($user)) {
            throw new Exception("User not found");
        }

        $errors = $this->validate($user);
        if (!empty($errors)) {
            throw new Exception(implode("<br>", $errors));
        }

        $stmt = $this->pdo->prepare('
            UPDATE users
            SET first_name = :first_name,
                last_name = :last_name,
                email = :email,
                mobile_number = :mobile_number,
                address = :address,
                city = :city,
                state = :state,
                zip = :zip,
                last_updated = NOW()
            WHERE id = :id
        ');
        $params = $this->mapToParams($user);
        $params[':id'] = $user->getId();
        $stmt->execute($params);
    }

    // Delete a user by ID
    public function delete($id) {
        $stmt = $this->pdo->prepare('DELETE FROM users WHERE id = :id');
        $stmt->execute([':id' => $id]);
    }

    // Validate user data
    private function validate(User $user) {
        $errors = [];
        if (!preg_match("/^[a-zA-Z-' ]{1,50}$/", $user->getFirstName())) {
            $errors[] = "First name must be 1-50 characters long and contain only letters, apostrophes, hyphens, and spaces.";
        }
        if (!preg_match("/^[a-zA-Z-' ]{1,50}$/", $user->getLastName())) {
            $errors[] = "Last name must be 1-50 characters long and contain only letters, apostrophes, hyphens, and spaces.";
        }
        if (!filter_var($user->getEmail(), FILTER_VALIDATE_EMAIL)) {
            $errors[] = "Invalid email format.";
        }
        if (!preg_match("/^\d{10,15}$/", $user->getMobileNumber())) {
            $errors[] = "Mobile number must be between 10 and 15 digits.";
        }
        if (strlen($user->getAddress()) > 100) {
            $errors[] = "Address must be up to 100 characters long.";
        }
        if (!preg_match("/^[a-zA-Z-' ]{1,50}$/", $user->getCity())) {
            $errors[] = "City must be 1-50 characters long and contain only letters, apostrophes, hyphens, and spaces.";
        }
        if (!preg_match("/^[A-Z]{2}$/", $user->getState())) {
            $errors[] = "State must be a valid 2-letter state code.";
        }
        if (!preg_match("/^\d{5}(-\d{4})?$/", $user->getZip())) {
            $errors[] = "Zip code must be 5 digits or 5+4 digits (e.g., 12345 or 12345-6789).";
        }
        return $errors;
    }

    // Map database row to User object
    private function mapToUser($row) {
        $user = new User();
        $user->setId($row['id']);
        $user->setFirstName($row['first_name']);
        $user->setLastName($row['last_name']);
        $user->setEmail($row['email']);
        $user->setMobileNumber($row['mobile_number']);
        $user->setAddress($row['address']);
        $user->setCity($row['city']);
        $user->setState($row['state']);
        $user->setZip($row['zip']);
        $user->setCreatedDate($row['created']);
        $user->setUpdatedDate($row['last_updated']);
        return $user;
    }

    // Map User object to query parameters
    private function mapToParams(User $user) {
        return [
            ':first_name' => $user->getFirstName(),
            ':last_name' => $user->getLastName(),
            ':email' => $user->getEmail(),
            ':mobile_number' => $user->getMobileNumber(),
            ':address' => $user->getAddress(),
            ':city' => $user->getCity(),
            ':state' => $user->getState(),
            ':zip' => $user->getZip(),
        ];
    }
}
