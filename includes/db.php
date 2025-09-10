<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/config.php';

// Create database connection
function getDBConnection() {
    $connection = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    if (!$connection) {
        die("Database connection failed: " . mysqli_connect_error());
    }
    return $connection;
}

function db_close($connection) {
    mysqli_close($connection);
}

// Simple query function
function executeQuery($sql, $params = []) {
    $conn = getDBConnection();
    
    if (!empty($params)) {
        $stmt = $conn->prepare($sql);
        if ($stmt) {
            $types = str_repeat('s', count($params));
            $stmt->bind_param($types, ...$params);
            $stmt->execute();
            $result = $stmt->get_result();
            $stmt->close();
        } else {
            $result = false;
        }
    } else {
        $result = $conn->query($sql);
    }
    
    $conn->close();
    return $result;
}

// Get single row
function getRow($sql, $params = []) {
    $result = executeQuery($sql, $params);
    if ($result && $result->num_rows > 0) {
        return $result->fetch_assoc();
    }
    return null;
}

// Get all rows
function getRows($sql, $params = []) {
    $result = executeQuery($sql, $params);
    $rows = [];
    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $rows[] = $row;
        }
    }
    return $rows;
}

// insert and return boolean if inserted
function insertRow($sql, $params = []) {
    $conn = getDBConnection();
    $stmt = $conn->prepare($sql);
    if ($stmt) {
        $types = str_repeat('s', count($params));
        $stmt->bind_param($types, ...$params);
        $success = $stmt->execute();
        $stmt->close();
        $conn->close();
        return $success;
    }
    $conn->close();
    return false;
}
