<?php
include_once 'includes/helpers.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$pm = $id ? db_get_one('payment_methods', "id = $id") : null;
$translations = $id ? get_entity_translations('payment_method_translations', 'payment_method_id', $id) : [];
$languages = get_active_languages();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $code = $_POST['code'];
    $is_active = isset($_POST['is_active']) ? 1 : 0;

    $data = [
        'code' => $code,
        'is_active' => $is_active
    ];

    if ($id) {
        db_update('payment_methods', $data, "id = $id");
        $pm_id = $id;
        set_alert("Payment method updated successfully!");
    } else {
        $pm_id = db_insert('payment_methods', $data);
        set_alert("Payment method created successfully!");
    }

    // Handle Translations
    foreach ($languages as $lang) {
        $lang_code = $lang['code'];
        $name = $_POST['trans'][$lang_code]['name'];

        $trans_data = [
            'payment_method_id' => $pm_id,
            'lang_code' => $lang_code,
            'name' => $name
        ];

        $existing = db_get_one('payment_method_translations', "payment_method_id = $pm_id AND lang_code = '$lang_code'");
        if ($existing) {
            db_update('payment_method_translations', $trans_data, "id = {$existing['id']}");
        } else {
            db_insert('payment_method_translations', $trans_data);
        }
    }

    redirect("payment_methods.php");
}

include 'layout/header.php';
include 'layout/sidebar.php';
?>

<div id="content">
    <div class="topbar">
        <h2 class="h4 mb-0"><?= $id ? 'Edit Payment Method' : 'Create Payment Method' ?></h2>
        <a href="payment_methods.php" class="btn btn-secondary btn-sm"><i class="fas fa-arrow-left"></i> Back to List</a>
    </div>

    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <form action="" method="POST">
                    <div class="card mb-4">
                        <div class="card-header">General Information</div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label">Code (Unique name, e.g. 'stripe', 'cod')</label>
                                <input type="text" name="code" class="form-control" value="<?= $pm['code'] ?? '' ?>" required>
                            </div>
                            <div class="form-check form-switch mb-3">
                                <input class="form-check-input" type="checkbox" name="is_active" id="isActive" <?= ($pm['is_active'] ?? 1) ? 'checked' : '' ?>>
                                <label class="form-check-label" for="isActive">Is Active</label>
                            </div>
                        </div>
                    </div>

                    <div class="card mb-4">
                        <div class="card-header">Translations</div>
                        <div class="card-body">
                            <?php foreach ($languages as $lang):
                                $t = $translations[$lang['code']] ?? [];
                            ?>
                                <div class="mb-3">
                                    <label class="form-label"><?= $lang['emoji'] ?> Name (<?= strtoupper($lang['code']) ?>)</label>
                                    <input type="text" name="trans[<?= $lang['code'] ?>][name]" class="form-control" value="<?= $t['name'] ?? '' ?>" required>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-save"></i> Save Payment Method
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include 'layout/footer.php'; ?>

