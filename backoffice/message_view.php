<?php
include_once 'includes/helpers.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$msg = db_get_one('messages', "id = $id");

if (!$msg) redirect("messages.php");

// Mark as read
if (!$msg['is_read']) {
    db_update('messages', ['is_read' => 1], "id = $id");
}

include 'layout/header.php';
include 'layout/sidebar.php';
?>

<div id="content">
    <div class="topbar">
        <h2 class="h4 mb-0">View Message</h2>
        <a href="messages.php" class="btn btn-secondary btn-sm"><i class="bi bi-arrow-left"></i> Back to List</a>
    </div>

    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between">
                        <span>Message from <?= $msg['name'] ?></span>
                        <span class="text-muted"><?= date('d/m/Y H:i', strtotime($msg['created_at'])) ?></span>
                    </div>
                    <div class="card-body">
                        <div class="mb-4">
                            <h5 class="card-title">Subject: <?= $msg['subject'] ?></h5>
                            <p class="card-text text-muted">Email: <a href="mailto:<?= $msg['email'] ?>"><?= $msg['email'] ?></a></p>
                        </div>
                        <hr>
                        <div class="bg-light p-4 rounded mb-4" style="white-space: pre-wrap; min-height: 200px;"><?= htmlspecialchars($msg['message']) ?></div>

                        <div class="d-flex justify-content-end">
                            <a href="message_delete.php?id=<?= $id ?>" class="btn btn-outline-danger btn-delete"><i class="bi bi-trash"></i> Delete Message</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'layout/footer.php'; ?>