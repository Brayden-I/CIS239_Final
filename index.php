<?php

// Load our model and controller files
require_once __DIR__ . '/model/db.php';
require_once __DIR__ . '/model/eventModel.php';
require_once __DIR__ . '/controllers/eventController.php';

session_start();

$page = $_GET['page'] ?? 'home';

$action = $_POST['action'] ?? '';

// Variables that views might use for displaying messages
$error = '';    // Error messages (login failed, validation errors, etc.)
$success = '';  // Success messages (event created, etc.)

// HANDLE ACTIONS (POST REQUESTS)
switch ($action) {
    
    case 'admin_login':
        // Get username and password from form, trim whitespace
        $username = trim($_POST['username'] ?? '');
        $password = $_POST['password'] ?? '';
        
        // Check if both fields were filled
        if ($username && $password) {
            // Call model function to verify credentials
            $admin = verifyAdmin($username, $password);
            
            if ($admin) {
                // LOGIN SUCCESS - Create session variables
                $_SESSION['admin_logged_in'] = true;
                $_SESSION['admin_id'] = $admin['id'];
                $_SESSION['admin_username'] = $admin['username'];
                
                // Send them to admin dashboard
                $page = 'admin_dashboard';
            } else {
                // LOGIN FAILED - Wrong username/password
                $error = "Invalid username or password.";
                $page = 'admin_login';
            }
        } else {
            // LOGIN FAILED - Empty fields
            $error = "Please enter both fields.";
            $page = 'admin_login';
        }
        break;
    
    case 'admin_logout':
        // Clear ALL session variables
        $_SESSION = [];
        
        // Destroy the session
        session_destroy();
        
        // Start a fresh session
        session_start();
        
        // Redirect to login page
        header('Location: ?page=admin_login');
        exit;  // ALWAYS exit after header redirect
        break;
    
    case 'create_event':
        requireAdmin();  // Make sure they're logged in
        
        // Get form data and trim whitespace
        $title = trim($_POST['title'] ?? '');
        $event_date = $_POST['event_date'] ?? '';
        $location = trim($_POST['location'] ?? '');
        $description = trim($_POST['description'] ?? '');
        
        // SERVER-SIDE VALIDATION - Check all fields are filled
        if ($title && $event_date && $location && $description) {
            // All fields valid - create the event
            createEvent($title, $event_date, $location, $description);
            $success = "Event created!";
            $page = 'admin_events';  // Go back to event list
        } else {
            // VALIDATION FAILED - Show form again with error
            $error = "All fields required.";
            $page = 'admin_event_form';
        }
        break;
    
    case 'update_event':
        requireAdmin();  // Make sure they're logged in
        
        // Get form data
        $id = (int)($_POST['id'] ?? 0);  // Cast to int for safety
        $title = trim($_POST['title'] ?? '');
        $event_date = $_POST['event_date'] ?? '';
        $location = trim($_POST['location'] ?? '');
        $description = trim($_POST['description'] ?? '');
        
        // SERVER-SIDE VALIDATION
        if ($id && $title && $event_date && $location && $description) {
            // All fields valid - update the event
            updateEvent($id, $title, $event_date, $location, $description);
            $success = "Event updated!";
            $page = 'admin_events';
        } else {
            // VALIDATION FAILED
            $error = "All fields required.";
            $page = 'admin_event_form';
        }
        break;
    
    case 'delete_event':
        requireAdmin();  // Make sure they're logged in
        
        // Get event ID from form
        $id = (int)($_POST['id'] ?? 0);
        
        if ($id) {
            // Delete the event
            deleteEvent($id);
            $success = "Event deleted.";
        }
        
        // Go back to event list
        $page = 'admin_events';
        break;
    
    case 'register':
        // Get form data
        $event_id = (int)($_POST['event_id'] ?? 0);
        $name = trim($_POST['name'] ?? '');
        $email = trim($_POST['email'] ?? '');
        
        // SERVER-SIDE VALIDATION - Check required fields
        if (!$event_id || !$name || !$email) {
            $error = "All fields required.";
            $page = 'event_detail';
        } 
        // Validate email format
        elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $error = "Invalid email.";
            $page = 'event_detail';
        } 
        else {
            // Validation passed - verify event exists
            $event = getEvent($event_id);
            
            if ($event) {
                // Event exists - create the registration
                createRegistration($event_id, $name, $email);
                
                // Set variables for success page (these will be used in the view)
                // NOTE: These variables persist because we don't redirect
                $page = 'registration_success';
            } else {
                // Event doesn't exist
                $error = "Event not found.";
                $page = 'home';
            }
        }
        break;
}

// ROUTE TO VIEWS

switch ($page) {
    
    // ===== PUBLIC PAGES =====
    
    case 'home':
        // Home page - list of upcoming events
        showEvents();
        break;
    
    case 'event_detail':
        // Event detail page with registration form
        showEventDetail();
        break;
    
    case 'registration_success':
        // Confirmation page after registration
        showRegistrationSuccess();
        break;
    
    // ADMIN PAGES
    
    case 'admin_login':
        // Admin login form
        showAdminLogin();
        break;
    
    case 'admin_dashboard':
        // Admin dashboard (landing page after login)
        showAdminDashboard();
        break;
    
    case 'admin_events':
        // Admin event list (can add/edit/delete)
        showAdminEvents();
        break;
    
    case 'admin_event_form':
        // Admin form for adding or editing an event
        showAdminEventForm();
        break;
    
    case 'admin_registrations':
        // Admin page showing all registrations grouped by event
        showAdminRegistrations();
        break;
        
    default:
        // If unknown page, show home
        showEvents();
        break;
}