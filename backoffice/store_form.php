<?php
include_once 'includes/helpers.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$store = $id ? db_get_one('stores', "id = $id") : null;
$translations = $id ? get_entity_translations('store_translations', 'store_id', $id) : [];
$languages = get_active_languages();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $is_active = isset($_POST['is_active']) ? 1 : 0;

    $data = [
        'email' => $email,
        'phone' => $phone,
        'is_active' => $is_active
    ];

    if ($id) {
        db_update('stores', $data, "id = $id");
        $store_id = $id;
        set_alert("Store updated successfully!");
    } else {
        $data['created_at'] = date('Y-m-d H:i:s');
        $store_id = db_insert('stores', $data);
        set_alert("Store created successfully!");
    }

    // Handle Translations
    foreach ($languages as $lang) {
        $lang_code = $lang['code'];
        $name = $_POST['trans'][$lang_code]['name'];
        $address = $_POST['trans'][$lang_code]['address'];

        $trans_data = [
            'store_id' => $store_id,
            'lang_code' => $lang_code,
            'name' => $name,
            'address' => $address
        ];

        $existing = db_get_one('store_translations', "store_id = $store_id AND lang_code = '$lang_code'");
        if ($existing) {
            db_update('store_translations', $trans_data, "id = {$existing['id']}");
        } else {
            db_insert('store_translations', $trans_data);
        }
    }

    redirect("stores.php");
}

include 'layout/header.php';
include 'layout/sidebar.php';
?>

<div id="content">
    <div class="topbar">
        <h2 class="h4 mb-0"><?= $id ? 'Edit Store' : 'Create Store' ?></h2>
        <a href="stores.php" class="btn btn-secondary btn-sm"><i class="bi bi-arrow-left"></i> Back to List</a>
    </div>

    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <form action="" method="POST">
                    <div class="card mb-4">
                        <div class="card-header">General Information</div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Email</label>
                                    <input type="email" name="email" class="form-control" value="<?= $store['email'] ?? '' ?>" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Phone</label>
                                    <input type="text" name="phone" class="form-control" value="<?= $store['phone'] ?? '' ?>" required>
                                </div>
                            </div>
                            <div class="form-check form-switch mb-2">
                                <input class="form-check-input" type="checkbox" name="is_active" id="isActive" <?= ($store['is_active'] ?? 1) ? 'checked' : '' ?>>
                                <label class="form-check-label" for="isActive">Is Active</label>
                            </div>
                        </div>
                    </div>

                    <div class="card mb-4">
                        <div class="card-header">Translations</div>
                        <div class="card-body">
                            <ul class="nav nav-tabs mb-3" id="langTabs" role="tablist">
                                <?php foreach ($languages as $index => $lang): ?>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link <?= $index === 0 ? 'active' : '' ?>" id="tab-<?= $lang['code'] ?>" data-bs-toggle="tab" data-bs-target="#content-<?= $lang['code'] ?>" type="button" role="tab">
                                            <?= $lang['emoji'] ?> <?= strtoupper($lang['code']) ?>
                                        </button>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                            <div class="tab-content">
                                <?php foreach ($languages as $index => $lang):
                                    $t = $translations[$lang['code']] ?? [];
                                ?>
                                    <div class="tab-pane fade <?= $index === 0 ? 'show active' : '' ?>" id="content-<?= $lang['code'] ?>" role="tabpanel">
                                        <div class="mb-3">
                                            <label class="form-label">Store Name (<?= strtoupper($lang['code']) ?>)</label>
                                            <input type="text" name="trans[<?= $lang['code'] ?>][name]" class="form-control" value="<?= $t['name'] ?? '' ?>" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Address (<?= strtoupper($lang['code']) ?>)</label>
                                            <textarea name="trans[<?= $lang['code'] ?>][address]" class="form-control" rows="2" required><?= $t['address'] ?? '' ?></textarea>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-save"></i> Save Store
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include 'layout/footer.php'; ?>