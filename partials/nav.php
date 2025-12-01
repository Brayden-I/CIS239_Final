<nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container-fluid">
        <a class="navbar-brand" href="?page=home">Event Planner</a>
        <div class="collapse navbar-collapse">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="?page=home">Events</a>
                </li>
                <?php if (!empty($_SESSION['admin_logged_in'])): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="?page=admin_dashboard">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="?page=admin_events">Manage Events</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="?page=admin_registrations">Registrations</a>
                    </li>
                    <li class="nav-item">
                        <form method="post" class="d-inline">
                            <input type="hidden" name="action" value="admin_logout">
                            <button class="btn btn-sm btn-outline-secondary">Logout</button>
                        </form>
                    </li>
                <?php else: ?>
                    <li class="nav-item">
                        <a class="nav-link" href="?page=admin_login">Admin Login</a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>