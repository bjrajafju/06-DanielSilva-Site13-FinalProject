<?php
include_once 'includes/helpers.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$address = $id ? db_get_one('addresses', "id = $id") : null;

$users = db_get_all('users');
$countries = db_get_all('countries');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = [
        'user_id' => (int)$_POST['user_id'],
        'first_name' => $_POST['first_name'],
        'last_name' => $_POST['last_name'],
        'mobile' => $_POST['mobile'],
        'address_line1' => $_POST['address_line1'],
        'address_line2' => $_POST['address_line2'],
        'city' => $_POST['city'],
        'state' => $_POST['state'],
        'postal_code' => $_POST['postal_code'],
        'country_id' => (int)$_POST['country_id'],
        'type' => $_POST['type']
    ];

    if ($id) {
        db_update('addresses', $data, "id = $id");
        set_alert("Address updated successfully!");
    } else {
        $data['created_at'] = date('Y-m-d H:i:s');
        db_insert('addresses', $data);
        set_alert("Address created successfully!");
    }

    redirect("addresses.php");
}

include 'layout/header.php';
include 'layout/sidebar.php';
?>

<div id="content">
    <div class="topbar">
        <h2 class="h4 mb-0"><?= $id ? 'Edit Address' : 'Create Address' ?></h2>
        <a href="addresses.php" class="btn btn-secondary btn-sm"><i class="fas fa-arrow-left"></i> Back to List</a>
    </div>

    <div class="container-fluid">
        <div class="card">
            <div class="card-header">Address Details</div>
            <div class="card-body">
                <form action="" method="POST">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">User</label>
                            <select name="user_id" class="form-select" required>
                                <option value="">Select User</option>
                                <?php foreach ($users as $u): ?>
                                    <option value="<?= $u['id'] ?>" <?= ($address['user_id'] ?? '') == $u['id'] ? 'selected' : '' ?>>
                                        <?= $u['first_name'] . ' ' . $u['last_name'] ?> (<?= $u['email'] ?>)
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Address Type</label>
                            <select name="type" class="form-select" required>
                                <option value="shipping" <?= ($address['type'] ?? '') == 'shipping' ? 'selected' : '' ?>>Shipping</option>
                                <option value="billing" <?= ($address['type'] ?? '') == 'billing' ? 'selected' : '' ?>>Billing</option>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">First Name</label>
                            <input type="text" name="first_name" class="form-control" value="<?= $address['first_name'] ?? '' ?>" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Last Name</label>
                            <input type="text" name="last_name" class="form-control" value="<?= $address['last_name'] ?? '' ?>" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Mobile</label>
                        <input type="text" name="mobile" class="form-control" value="<?= $address['mobile'] ?? '' ?>" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Address Line 1</label>
                        <input type="text" name="address_line1" class="form-control" value="<?= $address['address_line1'] ?? '' ?>" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Address Line 2</label>
                        <input type="text" name="address_line2" class="form-control" value="<?= $address['address_line2'] ?? '' ?>">
                    </div>

                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label">City</label>
                            <input type="text" name="city" class="form-control" value="<?= $address['city'] ?? '' ?>" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">State</label>
                            <input type="text" name="state" class="form-control" value="<?= $address['state'] ?? '' ?>" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Postal Code</label>
                            <input type="text" name="postal_code" class="form-control" value="<?= $address['postal_code'] ?? '' ?>" required>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label">Country</label>
                        <select name="country_id" class="form-select" required>
                            <option value="">Select Country</option>
                            <?php foreach ($countries as $c): ?>
                                <option value="<?= $c['id'] ?>" <?= ($address['country_id'] ?? '') == $c['id'] ? 'selected' : '' ?>>
                                    <?= $c['code'] ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-save"></i> Save Address
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include 'layout/footer.php'; ?>

