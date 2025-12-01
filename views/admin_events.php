<div class="mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Manage Events</h2>
        <a href="?page=admin_event_form" class="btn btn-success">Create New Event</a>
    </div>
    
    <?php if (!empty($success)): ?>
        <div class="alert alert-success">
            <?= htmlspecialchars($success) ?>
        </div>
    <?php endif; ?>
    
    <?php if (empty($events)): ?>
        <div class="alert alert-info">
            No events found. <a href="?page=admin_event_form">Create your first event</a>
        </div>
    <?php else: ?>
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Title</th>
                        <th>Date</th>
                        <th>Location</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($events as $event): ?>
                        <tr>
                            <td><?= $event['id'] ?></td>
                            <td><?= htmlspecialchars($event['title']) ?></td>
                            <td><?= date('M j, Y g:i A', strtotime($event['event_date'])) ?></td>
                            <td><?= htmlspecialchars($event['location']) ?></td>
                            <td>
                                <a href="?page=event_detail&id=<?= $event['id'] ?>" 
                                   class="btn btn-sm btn-info" 
                                   target="_blank">
                                    View
                                </a>
                                <a href="?page=admin_event_form&id=<?= $event['id'] ?>" 
                                   class="btn btn-sm btn-warning">
                                    Edit
                                </a>
                                <form method="post" class="d-inline" 
                                      onsubmit="return confirm('Are you sure you want to delete this event?');">
                                    <input type="hidden" name="action" value="delete_event">
                                    <input type="hidden" name="id" value="<?= $event['id'] ?>">
                                    <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>