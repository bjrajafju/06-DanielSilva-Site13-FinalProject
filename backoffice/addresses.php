<?php
include_once 'includes/helpers.php';

$limit = 10;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

$total_items = db_count('addresses');
$total_pages = ceil($total_items / $limit);

$addresses = db_select(
    "a.*, u.first_name as user_fname, u.last_name as user_lname, c.code as country_code",
    "addresses a",
    "LEFT JOIN users u ON u.id = a.user_id LEFT JOIN countries c ON c.id = a.country_id",
    "1",
    "a.id DESC",
    "$offset, $limit"
);

include 'layout/header.php';
include 'layout/sidebar.php';
?>

<div id="content">
    <div class="topbar">
        <h2 class="h4 mb-0">User Addresses</h2>
        <a href="address_form.php" class="btn btn-primary btn-sm"><i class="fas fa-plus"></i> Add New Address</a>
    </div>

    <div class="container-fluid">
        <?php show_alert(); ?>

        <div class="card">
            <div class="card-header">Address List</div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead>
                            <tr>
                                <th>User</th>
                                <th>Type</th>
                                <th>Name</th>
                                <th>Address</th>
                                <th>City</th>
                                <th>Country</th>
                                <th class="text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($addresses as $a): ?>
                                <tr>
                                    <td><?= $a['user_fname'] ? $a['user_fname'] . ' ' . $a['user_lname'] : 'Guest' ?></td>
                                    <td><span class="badge badge-<?= $a['type'] == 'billing' ? 'primary' : 'info' ?>"><?= strtoupper($a['type']) ?></span></td>
                                    <td><?= $a['first_name'] . ' ' . $a['last_name'] ?></td>
                                    <td><?= $a['address_line1'] ?></td>
                                    <td><?= $a['city'] ?></td>
                                    <td><code><?= $a['country_code'] ?></code></td>
                                    <td class="text-right">
                                        <a href="address_form.php?id=<?= $a['id'] ?>" class="btn btn-sm btn-outline-info"><i class="fas fa-edit"></i></a>
                                        <a href="address_delete.php?id=<?= $a['id'] ?>" class="btn btn-sm btn-outline-danger btn-delete"><i class="fas fa-trash"></i></a>
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

