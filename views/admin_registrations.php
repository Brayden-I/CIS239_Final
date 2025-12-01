<div class="mt-4">
    <h2>Event Registrations</h2>
    
    <?php if (empty($registrations)): ?>
        <div class="alert alert-info">
            No events found.
        </div>
    <?php else: ?>
        <?php foreach ($registrations as $event): ?>
            <div class="card mb-4">
                <div class="card-header">
                    <h4><?= htmlspecialchars($event['event_title']) ?></h4>
                    <p class="mb-0 text-muted">
                        <?= date('l, F j, Y \a\t g:i A', strtotime($event['event_date'])) ?>
                    </p>
                </div>
                <div class="card-body">
                    <?php if (empty($event['registrations'])): ?>
                        <p class="text-muted">No registrations yet.</p>
                    <?php else: ?>
                        <p><strong>Total Registrations: <?= count($event['registrations']) ?></strong></p>
                        <div class="table-responsive">
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Registered At</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($event['registrations'] as $reg): ?>
                                        <tr>
                                            <td><?= htmlspecialchars($reg['name']) ?></td>
                                            <td><?= htmlspecialchars($reg['email']) ?></td>
                                            <td><?= date('M j, Y g:i A', strtotime($reg['registered_at'])) ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>