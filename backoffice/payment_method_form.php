<?php
include_once 'includes/helpers.php';

$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
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
        set_alert("Método de pagamento atualizado com sucesso!");
    } else {
        $pm_id = db_insert('payment_methods', $data);
        set_alert("Método de pagamento criado com sucesso!");
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
        <h2 class="h4 mb-0"><?= $id ? 'Editar Método de Pagamento' : 'Criar Método de Pagamento' ?></h2>
        <a href="payment_methods.php" class="btn btn-secondary btn-sm"><i class="fas fa-arrow-left"></i> Voltar à
            Lista</a>
    </div>

    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <form action="" method="POST">
                    <div class="card mb-4">
                        <div class="card-header">Informação Geral</div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label">Código (Nome único, ex: 'paypal', 'cod')</label>
                                <input type="text" name="code" class="form-control" value="<?= $pm['code'] ?? '' ?>"
                                    required>
                            </div>
                            <div class="custom-control custom-switch mb-3">
                                <input class="custom-control-input" type="checkbox" name="is_active" id="isActive"
                                    <?= ($pm['is_active'] ?? 1) ? 'checked' : '' ?>>
                                <label class="custom-control-label" for="isActive">Ativo</label>
                            </div>
                        </div>
                    </div>

                    <div class="card mb-4">
                        <div class="card-header">Traduções</div>
                        <div class="card-body">
                            <?php foreach ($languages as $lang):
                                $t = $translations[$lang['code']] ?? [];
                                ?>
                                <div class="mb-3">
                                    <label class="form-label"><?= $lang['emoji'] ?> Nome
                                        (<?= strtoupper($lang['code']) ?>)</label>
                                    <input type="text" name="trans[<?= $lang['code'] ?>][name]" class="form-control"
                                        value="<?= $t['name'] ?? '' ?>" required>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-save"></i> Guardar Método de Pagamento
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include 'layout/footer.php'; ?>