<?php
include_once 'includes/config.php';

$cart = get_current_cart();
if (!$cart) {
    header("Location: " . $SETTINGS['url_site'] . "/index.php");
    exit;
}

$cart_items = get_cart_items($cart['id']);
if (!$cart_items) {
    header("Location: " . $SETTINGS['url_site'] . "/cart.php");
    exit;
}

$totals = get_cart_totals($cart['id']);
$countries = get_countries();
$payment_methods = get_payment_methods();

$user_id = $_SESSION['user_id'] ?? null;
$user_billing = $user_id ? get_last_user_address($user_id, 'billing') : null;
$user_shipping = $user_id ? get_last_user_address($user_id, 'shipping') : null;
if (!$user_shipping && $user_billing) {
    $user_shipping = $user_billing;
}

// Pre-fill fields logic
$billing_data = [
    'first_name' => $user_billing['first_name'] ?? $_SESSION['user_first_name'] ?? '',
    'last_name' => $user_billing['last_name'] ?? $_SESSION['user_last_name'] ?? '',
    'email' => $_SESSION['user_email'] ?? '',
    'mobile' => $user_billing['mobile'] ?? '',
    'address_line1' => $user_billing['address_line1'] ?? '',
    'address_line2' => $user_billing['address_line2'] ?? '',
    'country_id' => $user_billing['country_id'] ?? '',
    'city' => $user_billing['city'] ?? '',
    'state' => $user_billing['state'] ?? '',
    'postal_code' => $user_billing['postal_code'] ?? '',
];

$shipping_data = [
    'first_name' => $user_shipping['first_name'] ?? '',
    'last_name' => $user_shipping['last_name'] ?? '',
    'email' => $_SESSION['user_email'] ?? '',
    'mobile' => $user_shipping['mobile'] ?? '',
    'address_line1' => $user_shipping['address_line1'] ?? '',
    'address_line2' => $user_shipping['address_line2'] ?? '',
    'country_id' => $user_shipping['country_id'] ?? '',
    'city' => $user_shipping['city'] ?? '',
    'state' => $user_shipping['state'] ?? '',
    'postal_code' => $user_shipping['postal_code'] ?? '',
];

include 'includes/header.php';
?>

<!-- Page Header Start -->
<div class="container-fluid bg-secondary mb-5">
    <div class="d-flex flex-column align-items-center justify-content-center" style="min-height: 300px">
        <h1 class="font-weight-semi-bold text-uppercase mb-3"><?php echo t('checkout.header.title'); ?></h1>
        <div class="d-inline-flex">
            <p class="m-0"><a href="<?= $SETTINGS['url_site'] ?>/index.php"><?php echo t('checkout.breadcrumb.home'); ?></a></p>
            <p class="m-0 px-2">-</p>
            <p class="m-0"><?php echo t('checkout.breadcrumb.checkout'); ?></p>
        </div>
    </div>
</div>
<!-- Page Header End -->


<!-- Checkout Start -->
<div class="container-fluid pt-5">
    <form action="place_order.php" method="POST" id="checkout-form">
        <div class="row px-xl-5">
            <div class="col-lg-8">
                <div class="mb-4">
                    <h4 class="font-weight-semi-bold mb-4"><?php echo t('checkout.form.billing.title'); ?></h4>
                    <div class="row">

                        <div class="col-md-6 form-group">
                            <label><?php echo t('checkout.form.firstname.label'); ?></label>
                            <input name="billing_first_name" class="form-control" type="text" placeholder="<?php echo t('checkout.form.firstname.placeholder'); ?>" value="<?= htmlspecialchars($billing_data['first_name']) ?>" required>
                        </div>

                        <div class="col-md-6 form-group">
                            <label><?php echo t('checkout.form.lastname.label'); ?></label>
                            <input name="billing_last_name" class="form-control" type="text" placeholder="<?php echo t('checkout.form.lastname.placeholder'); ?>" value="<?= htmlspecialchars($billing_data['last_name']) ?>" required>
                        </div>

                        <div class="col-md-6 form-group">
                            <label><?php echo t('checkout.form.email.label'); ?></label>
                            <input name="billing_email" class="form-control" type="email" placeholder="<?php echo t('checkout.form.email.placeholder'); ?>" value="<?= htmlspecialchars($billing_data['email']) ?>" required>
                        </div>

                        <div class="col-md-6 form-group">
                            <label><?php echo t('checkout.form.mobile.label'); ?></label>
                            <input name="billing_mobile" class="form-control" type="text" placeholder="<?php echo t('checkout.form.mobile.placeholder'); ?>" value="<?= htmlspecialchars($billing_data['mobile']) ?>" required>
                        </div>

                        <div class="col-md-6 form-group">
                            <label><?php echo t('checkout.form.address1.label'); ?></label>
                            <input name="billing_address_line1" class="form-control" type="text" placeholder="<?php echo t('checkout.form.address1.placeholder'); ?>" value="<?= htmlspecialchars($billing_data['address_line1']) ?>" required>
                        </div>

                        <div class="col-md-6 form-group">
                            <label><?php echo t('checkout.form.address2.label'); ?></label>
                            <input name="billing_address_line2" class="form-control" type="text" placeholder="<?php echo t('checkout.form.address2.placeholder'); ?>" value="<?= htmlspecialchars($billing_data['address_line2']) ?>">
                        </div>

                        <div class="col-md-6 form-group">
                            <label><?php echo t('checkout.form.country.label'); ?></label>
                            <select name="billing_country_id" class="custom-select" required>
                                <option value=""><?= t('checkout.form.country.select') ?></option>
                                <?php foreach ($countries as $country): ?>
                                    <option value="<?= $country['id'] ?>" <?= $billing_data['country_id'] == $country['id'] ? 'selected' : '' ?>>
                                        <?= $country['name'] ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="col-md-6 form-group">
                            <label><?php echo t('checkout.form.city.label'); ?></label>
                            <input name="billing_city" class="form-control" type="text" placeholder="<?php echo t('checkout.form.city.placeholder'); ?>" value="<?= htmlspecialchars($billing_data['city']) ?>" required>
                        </div>

                        <div class="col-md-6 form-group">
                            <label><?php echo t('checkout.form.state.label'); ?></label>
                            <input name="billing_state" class="form-control" type="text" placeholder="<?php echo t('checkout.form.state.placeholder'); ?>" value="<?= htmlspecialchars($billing_data['state']) ?>" required>
                        </div>

                        <div class="col-md-6 form-group">
                            <label><?php echo t('checkout.form.zip.label'); ?></label>
                            <input name="billing_postal_code" class="form-control" type="text" placeholder="<?php echo t('checkout.form.zip.placeholder'); ?>" value="<?= htmlspecialchars($billing_data['postal_code']) ?>" required>
                        </div>

                        <div class="col-md-12 form-group">
                            <div class="custom-control custom-checkbox">
                                <input name="shipto" type="checkbox" class="custom-control-input" id="shipto" value="1">
                                <label class="custom-control-label" for="shipto" data-toggle="collapse"
                                    data-target="#shipping-address">
                                    <?php echo t('checkout.form.shipping_toggle.label'); ?>
                                </label>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="collapse mb-4" id="shipping-address">
                    <h4 class="font-weight-semi-bold mb-4"><?php echo t('checkout.form.shipping.title'); ?></h4>
                    <div class="row">

                        <div class="col-md-6 form-group">
                            <label><?php echo t('checkout.form.firstname.label'); ?></label>
                            <input name="shipping_first_name" class="form-control" type="text" placeholder="<?php echo t('checkout.form.firstname.placeholder'); ?>" value="<?= htmlspecialchars($shipping_data['first_name']) ?>">
                        </div>

                        <div class="col-md-6 form-group">
                            <label><?php echo t('checkout.form.lastname.label'); ?></label>
                            <input name="shipping_last_name" class="form-control" type="text" placeholder="<?php echo t('checkout.form.lastname.placeholder'); ?>" value="<?= htmlspecialchars($shipping_data['last_name']) ?>">
                        </div>

                        <div class="col-md-6 form-group">
                            <label><?php echo t('checkout.form.email.label'); ?></label>
                            <input name="shipping_email" class="form-control" type="email" placeholder="<?php echo t('checkout.form.email.placeholder'); ?>" value="<?= htmlspecialchars($shipping_data['email']) ?>">
                        </div>

                        <div class="col-md-6 form-group">
                            <label><?php echo t('checkout.form.mobile.label'); ?></label>
                            <input name="shipping_mobile" class="form-control" type="text" placeholder="<?php echo t('checkout.form.mobile.placeholder'); ?>" value="<?= htmlspecialchars($shipping_data['mobile']) ?>">
                        </div>

                        <div class="col-md-6 form-group">
                            <label><?php echo t('checkout.form.address1.label'); ?></label>
                            <input name="shipping_address_line1" class="form-control" type="text" placeholder="<?php echo t('checkout.form.address1.placeholder'); ?>" value="<?= htmlspecialchars($shipping_data['address_line1']) ?>">
                        </div>

                        <div class="col-md-6 form-group">
                            <label><?php echo t('checkout.form.address2.label'); ?></label>
                            <input name="shipping_address_line2" class="form-control" type="text" placeholder="<?php echo t('checkout.form.address2.placeholder'); ?>" value="<?= htmlspecialchars($shipping_data['address_line2']) ?>">
                        </div>

                        <div class="col-md-6 form-group">
                            <label><?php echo t('checkout.form.country.label'); ?></label>
                            <select name="shipping_country_id" class="custom-select">
                                <option value=""><?= t('checkout.form.country.select') ?></option>
                                <?php foreach ($countries as $country): ?>
                                    <option value="<?= $country['id'] ?>" <?= $shipping_data['country_id'] == $country['id'] ? 'selected' : '' ?>>
                                        <?= $country['name'] ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="col-md-6 form-group">
                            <label><?php echo t('checkout.form.city.label'); ?></label>
                            <input name="shipping_city" class="form-control" type="text" placeholder="<?php echo t('checkout.form.city.placeholder'); ?>" value="<?= htmlspecialchars($shipping_data['city']) ?>">
                        </div>

                        <div class="col-md-6 form-group">
                            <label><?php echo t('checkout.form.state.label'); ?></label>
                            <input name="shipping_state" class="form-control" type="text" placeholder="<?php echo t('checkout.form.state.placeholder'); ?>" value="<?= htmlspecialchars($shipping_data['state']) ?>">
                        </div>

                        <div class="col-md-6 form-group">
                            <label><?php echo t('checkout.form.zip.label'); ?></label>
                            <input name="shipping_postal_code" class="form-control" type="text" placeholder="<?php echo t('checkout.form.zip.placeholder'); ?>" value="<?= htmlspecialchars($shipping_data['postal_code']) ?>">
                        </div>

                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card border-secondary mb-5">
                    <div class="card-header bg-secondary border-0">
                        <h4 class="font-weight-semi-bold m-0"><?php echo t('checkout.summary.title'); ?></h4>
                    </div>

                    <div class="card-body">
                        <h5 class="font-weight-medium mb-3"><?php echo t('checkout.summary.products.title'); ?></h5>

                        <?php foreach ($cart_items as $item): ?>
                            <div class="d-flex justify-content-between">
                                <p><?= $item['title'] ?> (x<?= $item['quantity'] ?>)</p>
                                <p><?= number_format($item['price'] * $item['quantity'], 2) ?> €</p>
                            </div>
                        <?php endforeach; ?>

                        <hr class="mt-0">

                        <div class="d-flex justify-content-between mb-3 pt-1">
                            <h6 class="font-weight-medium"><?php echo t('checkout.summary.subtotal'); ?></h6>
                            <h6 class="font-weight-medium"><?= number_format($totals['subtotal'], 2) ?> €</h6>
                        </div>

                        <div class="d-flex justify-content-between">
                            <h6 class="font-weight-medium"><?php echo t('checkout.summary.shipping'); ?></h6>
                            <h6 class="font-weight-medium"><?= number_format($totals['shipping'], 2) ?> €</h6>
                        </div>
                    </div>

                    <div class="card-footer border-secondary bg-transparent">
                        <div class="d-flex justify-content-between mt-2">
                            <h5 class="font-weight-bold"><?php echo t('checkout.summary.total'); ?></h5>
                            <h5 class="font-weight-bold"><?= number_format($totals['total'], 2) ?> €</h5>
                        </div>
                    </div>
                </div>

                <div class="card border-secondary mb-5">
                    <div class="card-header bg-secondary border-0">
                        <h4 class="font-weight-semi-bold m-0"><?php echo t('checkout.payment.title'); ?></h4>
                    </div>

                    <div class="card-body">
                        <?php foreach ($payment_methods as $index => $pm): ?>
                            <div class="form-group">
                                <div class="custom-control custom-radio">
                                    <input type="radio" class="custom-control-input" name="payment_method_id" id="pm-<?= $pm['id'] ?>" value="<?= $pm['id'] ?>" <?= $index === 0 ? 'checked' : '' ?> required>
                                    <label class="custom-control-label" for="pm-<?= $pm['id'] ?>"><?= $pm['name'] ?></label>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <div class="card-footer border-secondary bg-transparent">
                        <button type="submit" class="btn btn-lg btn-block btn-primary font-weight-bold my-3 py-3" id="place-order-btn">
                            <?php echo t('checkout.payment.place_order'); ?>
                        </button>
                    </div>
                </div>
            </div>

        </div>
    </form>
</div>
<!-- Checkout End -->

<script>
    document.getElementById('checkout-form').addEventListener('submit', function() {
        const btn = document.getElementById('place-order-btn');
        btn.disabled = true;
        btn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Processing...';
    });
</script>
<!-- Checkout End -->

<?php include 'includes/footer.php'; ?>

</body>

</html>