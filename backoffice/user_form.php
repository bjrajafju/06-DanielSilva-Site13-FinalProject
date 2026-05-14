<?php
include_once 'includes/helpers.php';

$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
$user = $id ? db_get_one('users', "id = $id") : null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $mobile = $_POST['mobile'];

    $is_admin = isset($_POST['is_admin']) ? 1 : 0;

    $data = [
        'first_name' => $first_name,
        'last_name' => $last_name,
        'email' => $email,
        'mobile' => $mobile,
        'is_admin' => $is_admin
    ];

    if (!empty($_POST['password'])) {
        $data['password'] = password_hash($_POST['password'], PASSWORD_DEFAULT);
    }

    if ($id) {
        if ($user['is_admin'] && !$is_admin) {
            $admin_count = db_count('users', "is_admin = 1");
            if ($admin_count <= 1) {
                set_alert("Não é possível remover o estatuto de admin ao único administrador.", "danger");
                redirect("user_form.php?id=$id");
            }
        }

        db_update('users', $data, "id = $id");
        set_alert("Utilizador atualizado com sucesso!");
        redirect("users.php");
    } else {
        if (empty($_POST['password'])) {
            set_alert("A palavra-passe é obrigatória para novos utilizadores.", "danger");
        } else {
            $data['created_at'] = date('Y-m-d H:i:s');
            db_insert('users', $data);
            set_alert("Utilizador criado com sucesso!");
            redirect("users.php");
        }
    }
}

include 'layout/header.php';
include 'layout/sidebar.php';
?>

<div id="content">
    <div class="topbar">
        <h2 class="h4 mb-0"><?= $id ? 'Editar Utilizador' : 'Criar Utilizador' ?></h2>
        <a href="users.php" class="btn btn-secondary btn-sm"><i class="fas fa-arrow-left"></i> Voltar à Lista</a>
    </div>

    <div class="container-fluid">
        <?php show_alert(); ?>
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header">Detalhes do Utilizador</div>
                    <div class="card-body">
                        <form action="" method="POST">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Nome</label>
                                    <input type="text" name="first_name" class="form-control"
                                        value="<?= $user['first_name'] ?? '' ?>" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Apelido</label>
                                    <input type="text" name="last_name" class="form-control"
                                        value="<?= $user['last_name'] ?? '' ?>" required>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">E-mail</label>
                                <input type="email" name="email" class="form-control"
                                    value="<?= $user['email'] ?? '' ?>" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Telemóvel</label>
                                <input type="text" name="mobile" class="form-control"
                                    value="<?= $user['mobile'] ?? '' ?>">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Palavra-passe
                                    <?= $id ? '(Deixe vazio para manter a atual)' : '' ?></label>
                                <input type="password" name="password" class="form-control" <?= $id ? '' : 'required' ?>>
                            </div>

                            <div class="mb-4 custom-control custom-switch">
                                <input class="custom-control-input" type="checkbox" name="is_admin" id="isAdmin"
                                    <?= isset($user['is_admin']) && $user['is_admin'] ? 'checked' : '' ?>>
                                <label class="custom-control-label" for="isAdmin">Permissões de Admin</label>
                            </div>

                            <button type="submit" class="btn btn-primary w-100">
                                <i class="fas fa-save"></i> Guardar Utilizador
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'layout/footer.php'; ?>