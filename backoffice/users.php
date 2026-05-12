<?php
include_once 'includes/helpers.php';

$limit = 10;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

$total_items = db_count('users');
$total_pages = ceil($total_items / $limit);

$users = db_select("u.*", "users u", "", "1", "u.id DESC", "$offset, $limit");

include 'layout/header.php';
include 'layout/sidebar.php';
?>

<div id="content">
    <div class="topbar">
        <h2 class="h4 mb-0">Users</h2>
        <a href="user_form.php" class="btn btn-primary btn-sm"><i class="fas fa-user-plus"></i> Add New User</a>
    </div>

    <div class="container-fluid">
        <?php show_alert(); ?>

        <div class="card">
            <div class="card-header">User List</div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Mobile</th>
                                <th>Joined</th>
                                <th class="text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($users as $u): ?>
                                <tr>
                                    <td><strong><?= $u['first_name'] . ' ' . $u['last_name'] ?></strong></td>
                                    <td><?= $u['email'] ?></td>
                                    <td>
                                        <?php if ($u['is_admin']): ?>
                                            <span class="badge badge-primary">Admin</span>
                                        <?php else: ?>
                                            <span class="badge badge-secondary">User</span>
                                        <?php endif; ?>
                                    </td>
                                    <td><?= $u['mobile'] ?: 'N/A' ?></td>
                                    <td><?= date('d/m/Y', strtotime($u['created_at'])) ?></td>
                                    <td class="text-right">
                                        <a href="user_form.php?id=<?= $u['id'] ?>" class="btn btn-sm btn-outline-info"><i class="fas fa-edit"></i></a>
                                        <a href="user_delete.php?id=<?= $u['id'] ?>" class="btn btn-sm btn-outline-danger btn-delete"><i class="fas fa-trash"></i></a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <?php if ($total_pages > 1): ?>
                    <nav aria-label="Page navigation" class="mt-4">
                        <ul class="pagination justify-content-center">
                            <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                                <li class="page-item <?= $page == $i ? 'active' : '' ?>">
                                    <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
                                </li>
                            <?php endfor; ?>
                        </ul>
                    </nav>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php include 'layout/footer.php'; ?>

