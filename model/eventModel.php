<?php
/**
 * EVENT MODEL
 * All database functions go here - this is the MODEL layer of MVC.
 * Models handle ALL interactions with the database.
 * Like the functions.php file from your record store project.
 */

require_once "db.php";

//  EVENT FUNCTIONS
// These functions handle CRUD operations for events

function getUpcomingEvents() {
    $pdo = getPDO();
    
    // Prepared statement to prevent SQL injection
    $stmt = $pdo->prepare("
        SELECT * FROM events 
        WHERE event_date >= CURDATE() 
        ORDER BY event_date ASC
    ");
    
    // Execute query (no parameters needed here)
    $stmt->execute();
    
    // Return all rows as an array of associative arrays
    return $stmt->fetchAll();
}

/**
 * Get ALL events (for admin side)
 * Admins need to see past events too, so no date filter
 */
function getAllEvents() {
    $pdo = getPDO();
    
    $stmt = $pdo->prepare("
        SELECT * FROM events 
        ORDER BY event_date DESC
    ");
    
    $stmt->execute();
    return $stmt->fetchAll();
}

function getEvent($id) {
    $pdo = getPDO();
    
    // Use ? placeholder for user input to prevent SQL injection
    $stmt = $pdo->prepare("SELECT * FROM events WHERE id = ?");
    
    // Pass $id as parameter - PDO escapes it automatically
    $stmt->execute([$id]);
    
    // fetch() returns single row or false if not found
    return $stmt->fetch();
}

function createEvent($title, $event_date, $location, $description) {
    $pdo = getPDO();
    
    // INSERT statement with ? placeholders
    $stmt = $pdo->prepare("
        INSERT INTO events (title, event_date, location, description) 
        VALUES (?, ?, ?, ?)
    ");
    
    // Execute with array of values in the same order as ? placeholders
    $stmt->execute([$title, $event_date, $location, $description]);
}

function updateEvent($id, $title, $event_date, $location, $description) {
    $pdo = getPDO();
    
    // UPDATE statement - note ID is last in both query and array
    $stmt = $pdo->prepare("
        UPDATE events 
        SET title = ?, event_date = ?, location = ?, description = ? 
        WHERE id = ?
    ");
    
    // Array order must match ? placeholder order
    return $stmt->execute([$title, $event_date, $location, $description, $id]);
}

/**
 * Delete an event
 * @param int $id - Event ID to delete
 * @return bool - True if successful
 */
function deleteEvent($id) {
    $pdo = getPDO();
    
    $stmt = $pdo->prepare("DELETE FROM events WHERE id = ?");
    return $stmt->execute([$id]);
}

// REGISTRATION FUNCTIONS
// These handle event registrations from the public

function createRegistration($event_id, $name, $email) {
    $pdo = getPDO();
    
    // registered_at will auto-populate with CURRENT_TIMESTAMP
    $stmt = $pdo->prepare("
        INSERT INTO registrations (event_id, name, email) 
        VALUES (?, ?, ?)
    ");
    
    $stmt->execute([$event_id, $name, $email]);
}

function getRegistrationsByEvent() {
    $pdo = getPDO();
    
    // LEFT JOIN so we get ALL events, even ones with no registrations
    $stmt = $pdo->prepare("
        SELECT e.id as event_id, e.title as event_title, e.event_date,
               r.id as reg_id, r.name, r.email, r.registered_at
        FROM events e
        LEFT JOIN registrations r ON e.id = r.event_id
        ORDER BY e.event_date DESC, r.registered_at DESC
    ");
    
    $stmt->execute();
    $results = $stmt->fetchAll();
    
    // Group registrations by event using PHP
    $grouped = [];
    
    foreach ($results as $row) {
        $event_id = $row['event_id'];
        
        // If this event isn't in our array yet, add it
        if (!isset($grouped[$event_id])) {
            $grouped[$event_id] = [
                'event_id' => $row['event_id'],
                'event_title' => $row['event_title'],
                'event_date' => $row['event_date'],
                'registrations' => []  // Start with empty array
            ];
        }
        
        // If there's a registration (reg_id exists), add it to this event
        // LEFT JOIN means reg_id can be NULL if no registrations exist
        if ($row['reg_id']) {
            $grouped[$event_id]['registrations'][] = [
                'name' => $row['name'],
                'email' => $row['email'],
                'registered_at' => $row['registered_at']
            ];
        }
    }
    
    return $grouped;
}

// ADMIN FUNCTIONS
// These handle admin authentication

function verifyAdmin($username, $password) {
    $pdo = getPDO();
    
    // Look up admin by username
    $stmt = $pdo->prepare("
        SELECT id, username, password_hash 
        FROM admins 
        WHERE username = ?
    ");
    
    $stmt->execute([$username]);
    $admin = $stmt->fetch();
    
    // Check if admin exists AND password matches the hash
    // password_verify() compares plain text password with hash
    if ($admin && password_verify($password, $admin['password_hash'])) {
        return $admin;  // Login successful
    }
    
    return null;  // Login failed
}

function requireAdmin() {
    // Check if admin session variable exists
    if (empty($_SESSION['admin_logged_in'])) {
        // Not logged in - redirect to login page
        header('Location: ?page=admin_login');
        exit;  // MUST call exit after header redirect
    }
    // If session exists, function just returns and page continues
}