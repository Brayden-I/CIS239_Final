<?php
/**
 * EVENT CONTROLLER
 * This is the CONTROLLER layer of MVC.
 * Controllers handle application logic and routing.
 * They call model functions to get data, then load the appropriate view.
 */

require_once __DIR__ . '/../model/eventModel.php';

// Define paths to header and footer for easy reuse
$header = __DIR__ . '/../partials/header.php';
$footer = __DIR__ . '/../partials/footer.php';

/**
 * Helper function to show a simple page
 * Wraps a view file with header and footer
 */
function showPage($view) {
    global $header, $footer;
    
    // Build full path to view file
    $view = __DIR__ . "/../views/$view.php";
    
    // Include header, then view, then footer
    include $header;
    include $view;
    include $footer;
}

// PUBLIC PAGES
// These functions display pages for the public side

/**
 * Show the home page with list of upcoming events
 * Calls getUpcomingEvents() model function to get data
 * Then loads the home.php view which displays the events
 */
function showEvents() {
    global $header, $footer;
    
    // Get data from model
    $events = getUpcomingEvents();
    
    // Load view (view can access $events variable)
    include $header;
    include __DIR__ . '/../views/home.php';
    include $footer;
}

/**
 * Gets event ID from URL (?page=event_detail&id=123)
 * Loads event data and displays detail view with registration form
 */
function showEventDetail() {
    global $header, $footer;
    
    // Initialize variables that the view will use
    $event = null;
    $error = '';
    
    // Check if ID was provided in URL
    if (isset($_GET['id'])) {
        // Get event from database
        $event = getEvent($_GET['id']);
        
        // If event doesn't exist, set error message
        if (!$event) {
            $error = "Event not found.";
        }
    } else {
        // No ID in URL
        $error = "No event specified.";
    }
    
    // Load view - it will check if $event exists or if there's an $error
    include $header;
    include __DIR__ . '/../views/event_detail.php';
    include $footer;
}

/**
 * Show registration success page
 * This is shown after someone successfully registers for an event
 */
function showRegistrationSuccess() {
    global $header, $footer;
    
    // $name, $email, $event already set in index.php by the registration action
    include $header;
    include __DIR__ . '/../views/registration_success.php';
    include $footer;
}

// ADMIN PAGES
// These functions display pages for the admin side

/**
 * Show admin login form
 * Variable $error is set in index.php if login failed
 */
function showAdminLogin() {
    global $header, $footer;
    
    // $error variable already set in index.php if needed
    include $header;
    include __DIR__ . '/../views/admin_login.php';
    include $footer;
}

/*
 * Show admin dashboard (landing page after login)
 * Requires admin session - will redirect to login if not logged in
 */
function showAdminDashboard() {
    requireAdmin();  // Session guard - redirects if not logged in
    showPage('admin_dashboard');
}

/*
 * Show list of all events (admin can see past events too)
 * Requires admin session
 */
function showAdminEvents() {
    requireAdmin();  // Check if logged in
    global $header, $footer;
    
    // Get ALL events (not just upcoming)
    $events = getAllEvents();
    
    // Load view - it will loop through $events
    include $header;
    include __DIR__ . '/../views/admin_events.php';
    include $footer;
}

/*
 * Show event form (for both add and edit)
 * Requires admin session
 */
function showAdminEventForm() {
    requireAdmin();  // Check if logged in
    global $header, $footer;
    
    // Initialize variables for the form
    $event = null;
    $mode = 'add';  // Default to add mode
    
    // Check if editing an existing event
    if (isset($_GET['id'])) {
        // Get existing event data
        $event = getEvent($_GET['id']);
        
        if ($event) {
            $mode = 'edit';  // Switch to edit mode
        }
    }
    
    // Load view - it checks $mode to determine if add or edit
    include $header;
    include __DIR__ . '/../views/admin_event_form.php';
    include $footer;
}

function showAdminRegistrations() {
    requireAdmin();  // Check if logged in
    global $header, $footer;
    
    // Get registrations grouped by event
    $registrations = getRegistrationsByEvent();
    
    // Load view - it will loop through events and their registrations
    include $header;
    include __DIR__ . '/../views/admin_registrations.php';
    include $footer;
}