<?php
/**
 * DATABASE CONNECTION
 * This file establishes a PDO connection to the MySQL database.
 * It's exactly like your books example from class.
 */

function getPDO() {
    // Database connection parameters
    $dsn = "mysql:host=localhost;dbname=event_planner;charset=utf8mb4";
    $user = "root";
    $pass = "";

    try {
        // Create new PDO instance with error handling options
        $pdo = new PDO($dsn, $user, $pass, [
            // Throw exceptions on errors instead of silent failures
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            // Return results as associative arrays by default
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]);
        return $pdo;
    } catch (PDOException $e) {
        // If connection fails, stop execution and show error
        die("DB Connection failed: " . $e->getMessage());
    }
}