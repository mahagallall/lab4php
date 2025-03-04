<?php
require_once 'database.php';

function selectAllRooms() {
    $conn = connectDatabase();
    $result = $conn->query("SELECT DISTINCT room FROM customers");
    $rooms = [];
    while ($row = $result->fetch_assoc()) {
        $rooms[] = $row['room'];
    }
    $conn->close();
    return $rooms;
}

function selectCustomer($id) {
    return getCustomerById($id);
}

function selectAllCustomers() {
    return getAllCustomers();
}

function updateCustomerInfo($id, $name, $email, $room, $image) {
    updateCustomer($id, $name, $email, $room, $image);
}

function deleteCustomerInfo($id) {
    deleteCustomer($id);
}
