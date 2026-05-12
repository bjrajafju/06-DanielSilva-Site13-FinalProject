<?php
include_once 'includes/helpers.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$product = $id ? db_get_one('products', "id = $id") : null;
$translations = $id ? get_entity_translations('product_translations', 'product_id', $id) : [];
$languages = get_active_languages();
$categories = db_get_all('categories');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $codProd = $_POST['codProd'];
    $category_id = (int)$_POST['category_id'];
    $price = (float)$_POST['price'];
    $is_active = isset($_POST['is_active']) ? 1 : 0;

    // Handle Image
    $image = handle_image_upload('image', $product['image'] ?? '');

    $data = [
        'codProd' => $codProd,
        'category_id' => $category_id,
        'price' => $price,
        'image' => $image,
        'is_active' => $is_active,
        'updated_at' => date('Y-m-d H:i:s')
    ];

    if ($id) {
        db_update('products', $data, "id = $id");
        $product_id = $id;
        set_alert("Product updated successfully!");
    } else {
        $data['created_at'] = date('Y-m-d H:i:s');
        $product_id = db_insert('products', $data);
        set_alert("Product created successfully!");
    }

    // Handle Translations
    foreach ($languages as $lang) {
        $lang_code = $lang['code'];
        $title = $_POST['trans'][$lang_code]['title'];
        $slug = $_POST['trans'][$lang_code]['slug'] ?: strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $title)));
        $short_description = $_POST['trans'][$lang_code]['short_description'];
        $description = $_POST['trans'][$lang_code]['description'];
        $additional_info = $_POST['trans'][$lang_code]['additional_info'];

        $trans_data = [
            'product_id' => $product_id,
            'lang_code' => $lang_code,
            'title' => $title,
            'slug' => $slug,
            'short_description' => $short_description,
            'description' => $description,
            'additional_info' => $additional_info
        ];

        // Check if translation exists
        $existing = db_get_one('product_translations', "product_id = $product_id AND lang_code = '$lang_code'");
        if ($existing) {
            db_update('product_translations', $trans_data, "id = {$existing['id']}");
        } else {
            db_insert('product_translations', $trans_data);
        }
    }

    redirect("products.php");
}

include 'layout/header.php';
include 'layout/sidebar.php';
?>

<div id="content">
    <div class="topbar">
        <h2 class="h4 mb-0"><?= $id ? 'Edit Product' : 'Create Product' ?></h2>
        <a href="products.php" class="btn btn-secondary btn-sm"><i class="fas fa-arrow-left"></i> Back to List</a>
    </div>

    <div class="container-fluid">
        <form action="" method="POST" enctype="multipart/form-data">
            <div class="row">
                <div class="col-lg-8">
                    <!-- Base Data -->
                    <div class="card mb-4">
                        <div class="card-header">General Information</div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Product Code</label>
                                    <input type="text" name="codProd" class="form-control" value="<?= $product['codProd'] ?? '' ?>" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Category</label>
                                    <select name="category_id" class="form-select">
                                        <option value="">Select Category</option>
                                        <?php foreach ($categories as $cat):
                                            $cat_trans = db_get_one("category_translations", "category_id = {$cat['id']} AND lang_code = 'gb'");
                                        ?>
                                            <option value="<?= $cat['id'] ?>" <?= ($product['category_id'] ?? '') == $cat['id'] ? 'selected' : '' ?>>
                                                <?= $cat_trans['name'] ?? "Category #{$cat['id']}" ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Price (€)</label>
                                    <input type="number" step="0.01" name="price" class="form-control" value="<?= $product['price'] ?? '' ?>" required>
                                </div>
                                <div class="col-md-6 mb-3 d-flex align-items-end">
                                    <div class="form-check form-switch mb-2">
                                        <input class="form-check-input" type="checkbox" name="is_active" id="isActive" <?= ($product['is_active'] ?? 1) ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="isActive">Product is Active</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Translations -->
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
                            <div class="tab-content" id="langTabsContent">
                                <?php foreach ($languages as $index => $lang):
                                    $t = $translations[$lang['code']] ?? [];
                                ?>
                                    <div class="tab-pane fade <?= $index === 0 ? 'show active' : '' ?>" id="content-<?= $lang['code'] ?>" role="tabpanel">
                                        <div class="mb-3">
                                            <label class="form-label">Title (<?= strtoupper($lang['code']) ?>)</label>
                                            <input type="text" name="trans[<?= $lang['code'] ?>][title]" class="form-control" value="<?= $t['title'] ?? '' ?>" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Slug (<?= strtoupper($lang['code']) ?>) - Leave empty for auto-gen</label>
                                            <input type="text" name="trans[<?= $lang['code'] ?>][slug]" class="form-control" value="<?= $t['slug'] ?? '' ?>">
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Short Description</label>
                                            <textarea name="trans[<?= $lang['code'] ?>][short_description]" class="form-control" rows="2"><?= $t['short_description'] ?? '' ?></textarea>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Full Description</label>
                                            <textarea name="trans[<?= $lang['code'] ?>][description]" class="form-control" rows="5"><?= $t['description'] ?? '' ?></textarea>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Additional Info</label>
                                            <textarea name="trans[<?= $lang['code'] ?>][additional_info]" class="form-control" rows="3"><?= $t['additional_info'] ?? '' ?></textarea>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <!-- Image -->
                    <div class="card mb-4">
                        <div class="card-header">Product Image</div>
                        <div class="card-body text-center">
                            <div class="mb-3">
                                <?php if (isset($product['image'])): ?>
                                    <img src="../<?= $product['image'] ?>" class="img-thumbnail mb-3" style="max-height: 200px;">
                                <?php endif; ?>
                                <input type="file" name="image" class="form-control">
                                <div class="form-text">Upload product image (PNG, JPG)</div>
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-body">
                            <button type="submit" class="btn btn-primary w-100 mb-2">
                                <i class="fas fa-save"></i> Save Product
                            </button>
                            <a href="products.php" class="btn btn-outline-secondary w-100">Cancel</a>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<?php include 'layout/footer.php'; ?>

