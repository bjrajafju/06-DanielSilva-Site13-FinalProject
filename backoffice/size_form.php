<?php
include_once 'includes/helpers.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$size = $id ? db_get_one('sizes', "id = $id") : null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $data = ['name' => $name];

    if ($id) {
        db_update('sizes', $data, "id = $id");
        set_alert("Size updated successfully!");
    } else {
        db_insert('sizes', $data);
        set_alert("Size created successfully!");
    }

    redirect("sizes.php");
}

include 'layout/header.php';
include 'layout/sidebar.php';
?>

<div id="content">
    <div class="topbar">
        <h2 class="h4 mb-0"><?= $id ? 'Edit Size' : 'Create Size' ?></h2>
        <a href="sizes.php" class="btn btn-secondary btn-sm"><i class="fas fa-arrow-left"></i> Back to List</a>
    </div>

    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header">Size Details</div>
                    <div class="card-body">
                        <form action="" method="POST">
                            <div class="mb-3">
                                <label class="form-label">Size Name (e.g. XL, 42, etc.)</label>
                                <input type="text" name="name" class="form-control" value="<?= $size['name'] ?? '' ?>" required>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="fas fa-save"></i> Save Size
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'layout/footer.php'; ?>

