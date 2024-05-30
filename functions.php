<?php
session_start();
require_once 'config.php';

function registerUser($username, $email, $password) {
    global $conn;
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $username, $email, $hashed_password);
    if ($stmt->execute()) {
        return true;
    } else {
        // Handle execution error (e.g., log or return false)
        return false;
    }
}

function loginUser($username, $password) {
    global $conn;
    $stmt = $conn->prepare("SELECT id, password FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id, $hashed_password);
        $stmt->fetch();
        if (password_verify($password, $hashed_password)) {
            $_SESSION['user_id'] = $id;
            return true;
        }
    }
    return false;
}
// includes/functions.php

function isLoggedIn() {
    // Implementation of your login status check
    // For example, check if a user session variable exists
    return isset($_SESSION['user_id']);
}


function isAdmin() {
    global $conn;
    if (isLoggedIn()) {
        $user_id = $_SESSION['user_id'];
        $stmt = $conn->prepare("SELECT is_admin FROM users WHERE id = ?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $stmt->store_result();
        if ($stmt->num_rows > 0) {
            $stmt->bind_result($is_admin);
            $stmt->fetch();
            return $is_admin;
        }
    }
    return false;
}

function getAllBookings() {
    global $conn;
    $bookings = [];
    $stmt = $conn->prepare("SELECT id, hotel_name, check_in, check_out, adults, children FROM bookings ORDER BY created_at DESC");
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($id, $hotel_name, $check_in, $check_out, $adults, $children);
    while ($stmt->fetch()) {
        $booking = [
            'id' => $id,
            'hotel_name' => $hotel_name,
            'check_in' => $check_in,
            'check_out' => $check_out,
            'adults' => $adults,
            'children' => $children
        ];
        $bookings[] = $booking;
    }
    return $bookings;
}

function getAvailableRooms() {
    global $conn;
    $rooms = [];
    $stmt = $conn->prepare("SELECT id, room_number, hotel_name FROM rooms WHERE is_available = 1");
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($id, $room_number, $hotel_name);
    while ($stmt->fetch()) {
        $room = [
            'id' => $id,
            'room_number' => $room_number,
            'hotel_name' => $hotel_name
        ];
        $rooms[] = $room;
    }
    return $rooms;
}

function bookRoom($user_id, $hotel_name, $check_in, $check_out, $adults, $children) {
    global $conn;
    $stmt = $conn->prepare("INSERT INTO bookings (user_id, hotel_name, check_in, check_out, adults, children) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("isssii", $user_id, $hotel_name, $check_in, $check_out, $adults, $children);
    if ($stmt->execute()) {
        return true;
    } else {
        // Handle execution error (e.g., log or return false)
        return false;
    }
}

function markRoomUnavailable($room_id) {
    global $conn;
    $stmt = $conn->prepare("UPDATE rooms SET is_available = 0 WHERE id = ?");
    $stmt->bind_param("i", $room_id);
    if ($stmt->execute()) {
        return true;
    } else {
        // Handle execution error (e.g., log or return false)
        return false;
    }
}
?>
