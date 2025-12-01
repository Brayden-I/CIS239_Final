<div class="mt-4">
    <h2>Admin Dashboard</h2>
    <p class="lead">Welcome, <?= htmlspecialchars($_SESSION['admin_username']) ?>!</p>
    
    <div class="row mt-4">
        <div class="col-md-4">
            <div class="card">
                <div class="card-body text-center">
                    <h5 class="card-title">Manage Events</h5>
                    <p class="card-text">Create, edit, or delete events</p>
                    <a href="?page=admin_events" class="btn btn-primary">View Events</a>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card">
                <div class="card-body text-center">
                    <h5 class="card-title">View Registrations</h5>
                    <p class="card-text">See who's registered for each event</p>
                    <a href="?page=admin_registrations" class="btn btn-primary">View Registrations</a>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card">
                <div class="card-body text-center">
                    <h5 class="card-title">Create New Event</h5>
                    <p class="card-text">Add a new event to the calendar</p>
                    <a href="?page=admin_event_form" class="btn btn-success">Create Event</a>
                </div>
            </div>
        </div>
    </div>
</div>