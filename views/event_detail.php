<!-- If the error variable is not empty, display it and provide a button to return to home -->
<?php if (!empty($error)): ?>
    <div class="alert alert-danger mt-3">
        <?= htmlspecialchars($error) ?>
    </div>
    <a href="?page=home" class="btn btn-secondary">Back to Events</a>
<?php elseif ($event): ?>
    <div class="row mt-3">
        <div class="col-md-8">
            <h2><?= htmlspecialchars($event['title']) ?></h2>
            
            <div class="card mb-4">
                <div class="card-body">
                    <p><strong>Date:</strong> <?= date('l, F j, Y \a\t g:i A', strtotime($event['event_date'])) ?></p>
                    <p><strong>Location:</strong> <?= htmlspecialchars($event['location']) ?></p>
                    <hr>
                    <h5>Description</h5>
                    <p><?= nl2br(htmlspecialchars($event['description'])) ?></p>
                </div>
            </div>
            
            <a href="?page=home" class="btn btn-secondary">Back to Events</a>
        </div>
        
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h4>Register for this Event</h4>
                </div>
                <div class="card-body">
                    <form method="post">
                        <input type="hidden" name="action" value="register">
                        <input type="hidden" name="event_id" value="<?= $event['id'] ?>">
                        
                        <div class="mb-3">
                            <label for="name" class="form-label">Full Name</label>
                            <input 
                                type="text" 
                                class="form-control" 
                                id="name" 
                                name="name" 
                                required
                            >
                        </div>
                        
                        <div class="mb-3">
                            <label for="email" class="form-label">Email Address</label>
                            <input 
                                type="email" 
                                class="form-control" 
                                id="email" 
                                name="email" 
                                required
                            >
                        </div>
                        
                        <button type="submit" class="btn btn-primary w-100">Register Now</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>