<?php
include_once 'includes/helpers.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$lang = $id ? db_get_one('lang', "id = $id") : null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $code = strtolower($_POST['code']);
    $emoji = $_POST['emoji'];

    $data = [
        'code' => $code,
        'emoji' => $emoji
    ];

    if ($id) {
        db_update('lang', $data, "id = $id");
        set_alert("Language updated successfully!");
    } else {
        db_insert('lang', $data);
        set_alert("Language created successfully!");
    }

    redirect("lang.php");
}

include 'layout/header.php';
include 'layout/sidebar.php';
?>

<div id="content">
    <div class="topbar">
        <h2 class="h4 mb-0"><?= $id ? 'Edit Language' : 'Create Language' ?></h2>
        <a href="lang.php" class="btn btn-secondary btn-sm"><i class="fas fa-arrow-left"></i> Back to List</a>
    </div>

    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <form action="" method="POST">
                    <div class="card mb-4">
                        <div class="card-header">Language Details</div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label">Code (e.g. 'en', 'pt', 'fr')</label>
                                <input type="text" name="code" class="form-control" value="<?= $lang['code'] ?? '' ?>" maxlength="5" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Emoji (e.g. ??, ??)</label>
                                <input type="text" name="emoji" class="form-control" value="<?= $lang['emoji'] ?? '' ?>" required>
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-save"></i> Save Language
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include 'layout/footer.php'; ?>

