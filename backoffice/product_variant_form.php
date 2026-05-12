<?php
include_once 'includes/helpers.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$variant = $id ? db_get_one('product_variants', "id = $id") : null;

$products = db_get_all('products');
$sizes = db_get_all('sizes');
$colors = db_get_all('colors');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $product_id = (int)$_POST['product_id'];
    $size_id = (int)$_POST['size_id'];
    $color_id = (int)$_POST['color_id'];
    $stock = (int)$_POST['stock'];
    $is_available = isset($_POST['is_available']) ? 1 : 0;

    $data = [
        'product_id' => $product_id,
        'size_id' => $size_id,
        'color_id' => $color_id,
        'stock' => $stock,
        'is_available' => $is_available
    ];

    if ($id) {
        db_update('product_variants', $data, "id = $id");
        set_alert("Variant updated successfully!");
    } else {
        db_insert('product_variants', $data);
        set_alert("Variant created successfully!");
    }

    redirect("product_variants.php");
}

include 'layout/header.php';
include 'layout/sidebar.php';
?>

<div id="content">
    <div class="topbar">
        <h2 class="h4 mb-0"><?= $id ? 'Edit Variant' : 'Create Variant' ?></h2>
        <a href="product_variants.php" class="btn btn-secondary btn-sm"><i class="fas fa-arrow-left"></i> Back to List</a>
    </div>

    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header">Variant Details</div>
                    <div class="card-body">
                        <form action="" method="POST">
                            <div class="mb-3">
                                <label class="form-label">Product</label>
                                <select name="product_id" class="form-select" required>
                                    <option value="">Select Product</option>
                                    <?php foreach ($products as $p):
                                        $p_trans = db_get_one("product_translations", "product_id = {$p['id']} AND lang_code = 'gb'");
                                        if (!$p_trans) $p_trans = db_get_one("product_translations", "product_id = {$p['id']}");
                                    ?>
                                        <option value="<?= $p['id'] ?>" <?= ($variant['product_id'] ?? '') == $p['id'] ? 'selected' : '' ?>>
                                            [<?= $p['codProd'] ?>] <?= $p_trans['title'] ?? 'N/A' ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Size</label>
                                    <select name="size_id" class="form-select" required>
                                        <option value="">Select Size</option>
                                        <?php foreach ($sizes as $s): ?>
                                            <option value="<?= $s['id'] ?>" <?= ($variant['size_id'] ?? '') == $s['id'] ? 'selected' : '' ?>>
                                                <?= $s['name'] ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Color</label>
                                    <select name="color_id" class="form-select" required>
                                        <option value="">Select Color</option>
                                        <?php foreach ($colors as $c):
                                            $c_trans = db_get_one("color_translations", "color_id = {$c['id']} AND lang_code = 'gb'");
                                        ?>
                                            <option value="<?= $c['id'] ?>" <?= ($variant['color_id'] ?? '') == $c['id'] ? 'selected' : '' ?>>
                                                <?= $c_trans['name'] ?? "Color #{$c['id']}" ?> (<?= $c['hex'] ?>)
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Stock Quantity</label>
                                    <input type="number" name="stock" class="form-control" value="<?= $variant['stock'] ?? 0 ?>" min="0" required>
                                </div>
                                <div class="col-md-6 mb-4">
                                    <div class="form-check form-switch mt-4 pt-2">
                                        <input class="form-check-input" type="checkbox" name="is_available" id="isAvailable" <?= ($variant['is_available'] ?? 1) ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="isAvailable">Variant is Available</label>
                                    </div>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary w-100">
                                <i class="fas fa-save"></i> Save Variant
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'layout/footer.php'; ?>

