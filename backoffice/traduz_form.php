<?php
include_once 'includes/helpers.php';

$code = isset($_GET['code']) ? $_GET['code'] : '';
$translations = $code ? db_get_all('traduz', "code = '" . addslashes($code) . "'") : [];
$trans_map = [];
foreach ($translations as $t) {
    $trans_map[$t['lang_code']] = $t;
}

$languages = get_active_languages();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $new_code = $_POST['code'];

    // If changing code, delete old ones
    if ($code && $code !== $new_code) {
        db_delete('traduz', "code = '" . addslashes($code) . "'");
    }

    foreach ($languages as $lang) {
        $lang_code = $lang['code'];
        $text = $_POST['trans'][$lang_code]['text'];

        $data = [
            'lang_code' => $lang_code,
            'code' => $new_code,
            'text' => $text
        ];

        $existing = db_get_one('traduz', "code = '" . addslashes($new_code) . "' AND lang_code = '$lang_code'");
        if ($existing) {
            db_update('traduz', $data, "id = {$existing['id']}");
        } else {
            db_insert('traduz', $data);
        }
    }

    set_alert("Translation updated successfully!");
    redirect("traduz.php");
}

include 'layout/header.php';
include 'layout/sidebar.php';
?>

<div id="content">
    <div class="topbar">
        <h2 class="h4 mb-0"><?= $code ? 'Edit Translation' : 'Create Translation' ?></h2>
        <a href="traduz.php" class="btn btn-secondary btn-sm"><i class="bi bi-arrow-left"></i> Back to List</a>
    </div>

    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <form action="" method="POST">
                    <div class="card mb-4">
                        <div class="card-header">Translation Key</div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label">Code Key (e.g. home.title, contact.form.success)</label>
                                <input type="text" name="code" class="form-control" value="<?= htmlspecialchars($code) ?>" required>
                                <div class="form-text">Use dot notation for grouping (module.section.key)</div>
                            </div>
                        </div>
                    </div>

                    <div class="card mb-4">
                        <div class="card-header">Content</div>
                        <div class="card-body">
                            <?php foreach ($languages as $lang):
                                $t = $trans_map[$lang['code']] ?? [];
                            ?>
                                <div class="mb-3">
                                    <label class="form-label"><?= $lang['emoji'] ?> Text (<?= strtoupper($lang['code']) ?>)</label>
                                    <textarea name="trans[<?= $lang['code'] ?>][text]" class="form-control" rows="3" required><?= htmlspecialchars($t['text'] ?? '') ?></textarea>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-save"></i> Save Translation
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include 'layout/footer.php'; ?>