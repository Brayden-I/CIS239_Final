<div class="mt-4">
    <h2><?= $mode === 'edit' ? 'Edit Event' : 'Create New Event' ?></h2>
    
    <?php if (!empty($error)): ?>
        <div class="alert alert-danger">
            <?= htmlspecialchars($error) ?>
        </div>
    <?php endif; ?>
    
    <div class="card">
        <div class="card-body">
            <form method="post">
                <input type="hidden" name="action" value="<?= $mode === 'edit' ? 'update_event' : 'create_event' ?>">
                <?php if ($mode === 'edit'): ?>
                    <input type="hidden" name="id" value="<?= $event['id'] ?>">
                <?php endif; ?>
                
                <div class="mb-3">
                    <label for="title" class="form-label">Event Title</label>
                    <input 
                        type="text" 
                        class="form-control" 
                        id="title" 
                        name="title" 
                        required
                        value="<?= htmlspecialchars($event['title'] ?? $_POST['title'] ?? '') ?>"
                    >
                </div>
                
                <div class="mb-3">
                    <label for="event_date" class="form-label">Event Date & Time</label>
                    <input 
                        type="datetime-local" 
                        class="form-control" 
                        id="event_date" 
                        name="event_date" 
                        required
                        value="<?= isset($event['event_date']) ? date('Y-m-d\TH:i', strtotime($event['event_date'])) : ($_POST['event_date'] ?? '') ?>"
                    >
                </div>
                
                <div class="mb-3">
                    <label for="location" class="form-label">Location</label>
                    <input 
                        type="text" 
                        class="form-control" 
                        id="location" 
                        name="location" 
                        required
                        value="<?= htmlspecialchars($event['location'] ?? $_POST['location'] ?? '') ?>"
                    >
                </div>
                
                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea 
                        class="form-control" 
                        id="description" 
                        name="description" 
                        rows="5" 
                        required
                    ><?= htmlspecialchars($event['description'] ?? $_POST['description'] ?? '') ?></textarea>
                </div>
                
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        <?= $mode === 'edit' ? 'Update Event' : 'Create Event' ?>
                    </button>
                    <a href="?page=admin_events" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>