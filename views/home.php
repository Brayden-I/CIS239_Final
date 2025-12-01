<h2>Upcoming Events</h2>

<?php if (empty($events)): ?>
    <p>No upcoming events.</p>
<?php else: ?>
    <div class="row">
        <?php foreach ($events as $event): ?>
            <div class="col-md-4 mb-3">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title"><?= htmlspecialchars($event['title']) ?></h5>
                        <p><strong>Date:</strong> <?= date('M j, Y g:i A', strtotime($event['event_date'])) ?></p>
                        <p><strong>Location:</strong> <?= htmlspecialchars($event['location']) ?></p>
                        <a href="?page=event_detail&id=<?= $event['id'] ?>" class="btn btn-primary">
                            View Details & Register
                        </a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>