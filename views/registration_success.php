<div class="row justify-content-center mt-5">
    <div class="col-md-8">
        <div class="alert alert-success">
            <h3>Registration Successful!</h3>
            <p class="mb-0">Thank you for registering, <strong><?= htmlspecialchars($name) ?></strong>!</p>
        </div>
        
        <div class="card">
            <div class="card-body">
                <h5>Registration Details</h5>
                <p><strong>Event:</strong> <?= htmlspecialchars($event['title']) ?></p>
                <p><strong>Date:</strong> <?= date('l, F j, Y \a\t g:i A', strtotime($event['event_date'])) ?></p>
                <p><strong>Location:</strong> <?= htmlspecialchars($event['location']) ?></p>
                <p><strong>Your Email:</strong> <?= htmlspecialchars($email) ?></p>
                <hr>
                <p class="text-muted">A confirmation email has been sent to your email address.</p>
            </div>
        </div>
        
        <div class="mt-3">
            <a href="?page=home" class="btn btn-primary">View More Events</a>
            <a href="?page=event_detail&id=<?= $event['id'] ?>" class="btn btn-secondary">Back to Event</a>
        </div>
    </div>
</div>