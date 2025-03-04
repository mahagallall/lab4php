<?php
require_once 'config.php';

function insertCustomer($name, $email, $password, $room, $image) {
    $conn = connectDatabase();
    $stmt = $conn->prepare("INSERT INTO customers (name, email, password, room, image) VALUES (?, ?, ?, ?, ?)");
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    $stmt->bind_param("sssss", $name, $email, $hashed_password, $room, $image);
    $stmt->execute();
    $stmt->close();
    $conn->close();
}

function updateCustomer($id, $name, $email, $room, $image) {
    $conn = connectDatabase();
    $stmt = $conn->prepare("UPDATE customers SET name=?, email=?, room=?, image=? WHERE id=?");
    $stmt->bind_param("ssssi", $name, $email, $room, $image, $id);
    $stmt->execute();
    $stmt->close();
    $conn->close();
}

function deleteCustomer($id) {
    $conn = connectDatabase();
    $stmt = $conn->prepare("DELETE FROM customers WHERE id=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();
    $conn->close();
}

function getCustomerById($id) {
    $conn = connectDatabase();
    $stmt = $conn->prepare("SELECT * FROM customers WHERE id=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $customer = $result->fetch_assoc();
    $stmt->close();
    $conn->close();
    return $customer;
}

function getAllCustomers() {
    $conn = connectDatabase();
    $result = $conn->query("SELECT * FROM customers");
    $customers = [];
    while ($row = $result->fetch_assoc()) {
        $customers[] = $row;
    }
    $conn->close();
    return $customers;
}
