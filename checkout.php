<!DOCTYPE html>
<html lang="gb">

<?php
include_once 'includes/config.php';
include 'includes/header.php';
?>

<!-- Page Header Start -->
<div class="container-fluid bg-secondary mb-5">
    <div class="d-flex flex-column align-items-center justify-content-center" style="min-height: 300px">
        <h1 class="font-weight-semi-bold text-uppercase mb-3"><?php echo t('checkout.header.title'); ?></h1>
        <div class="d-inline-flex">
            <p class="m-0"><a href=""><?php echo t('checkout.breadcrumb.home'); ?></a></p>
            <p class="m-0 px-2">-</p>
            <p class="m-0"><?php echo t('checkout.breadcrumb.checkout'); ?></p>
        </div>
    </div>
</div>
<!-- Page Header End -->


<!-- Checkout Start -->
<div class="container-fluid pt-5">
    <div class="row px-xl-5">
        <div class="col-lg-8">
            <div class="mb-4">
                <h4 class="font-weight-semi-bold mb-4"><?php echo t('checkout.form.billing.title'); ?></h4>
                <div class="row">

                    <div class="col-md-6 form-group">
                        <label><?php echo t('checkout.form.firstname.label'); ?></label>
                        <input class="form-control" type="text" placeholder="<?php echo t('checkout.form.firstname.placeholder'); ?>">
                    </div>

                    <div class="col-md-6 form-group">
                        <label><?php echo t('checkout.form.lastname.label'); ?></label>
                        <input class="form-control" type="text" placeholder="<?php echo t('checkout.form.lastname.placeholder'); ?>">
                    </div>

                    <div class="col-md-6 form-group">
                        <label><?php echo t('checkout.form.email.label'); ?></label>
                        <input class="form-control" type="text" placeholder="<?php echo t('checkout.form.email.placeholder'); ?>">
                    </div>

                    <div class="col-md-6 form-group">
                        <label><?php echo t('checkout.form.mobile.label'); ?></label>
                        <input class="form-control" type="text" placeholder="<?php echo t('checkout.form.mobile.placeholder'); ?>">
                    </div>

                    <div class="col-md-6 form-group">
                        <label><?php echo t('checkout.form.address1.label'); ?></label>
                        <input class="form-control" type="text" placeholder="<?php echo t('checkout.form.address1.placeholder'); ?>">
                    </div>

                    <div class="col-md-6 form-group">
                        <label><?php echo t('checkout.form.address2.label'); ?></label>
                        <input class="form-control" type="text" placeholder="<?php echo t('checkout.form.address2.placeholder'); ?>">
                    </div>

                    <div class="col-md-6 form-group">
                        <label><?php echo t('checkout.form.country.label'); ?></label>
                        <select class="custom-select">
                            <option selected>United States</option>
                            <option>Afghanistan</option>
                            <option>Albania</option>
                            <option>Algeria</option>
                        </select>
                    </div>

                    <div class="col-md-6 form-group">
                        <label><?php echo t('checkout.form.city.label'); ?></label>
                        <input class="form-control" type="text" placeholder="<?php echo t('checkout.form.city.placeholder'); ?>">
                    </div>

                    <div class="col-md-6 form-group">
                        <label><?php echo t('checkout.form.state.label'); ?></label>
                        <input class="form-control" type="text" placeholder="<?php echo t('checkout.form.state.placeholder'); ?>">
                    </div>

                    <div class="col-md-6 form-group">
                        <label><?php echo t('checkout.form.zip.label'); ?></label>
                        <input class="form-control" type="text" placeholder="<?php echo t('checkout.form.zip.placeholder'); ?>">
                    </div>

                    <div class="col-md-12 form-group">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="shipto">
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
                        <input class="form-control" type="text" placeholder="<?php echo t('checkout.form.firstname.placeholder'); ?>">
                    </div>

                    <div class="col-md-6 form-group">
                        <label><?php echo t('checkout.form.lastname.label'); ?></label>
                        <input class="form-control" type="text" placeholder="<?php echo t('checkout.form.lastname.placeholder'); ?>">
                    </div>

                    <div class="col-md-6 form-group">
                        <label><?php echo t('checkout.form.email.label'); ?></label>
                        <input class="form-control" type="text" placeholder="<?php echo t('checkout.form.email.placeholder'); ?>">
                    </div>

                    <div class="col-md-6 form-group">
                        <label><?php echo t('checkout.form.mobile.label'); ?></label>
                        <input class="form-control" type="text" placeholder="<?php echo t('checkout.form.mobile.placeholder'); ?>">
                    </div>

                    <div class="col-md-6 form-group">
                        <label><?php echo t('checkout.form.address1.label'); ?></label>
                        <input class="form-control" type="text" placeholder="<?php echo t('checkout.form.address1.placeholder'); ?>">
                    </div>

                    <div class="col-md-6 form-group">
                        <label><?php echo t('checkout.form.address2.label'); ?></label>
                        <input class="form-control" type="text" placeholder="<?php echo t('checkout.form.address2.placeholder'); ?>">
                    </div>

                    <div class="col-md-6 form-group">
                        <label><?php echo t('checkout.form.country.label'); ?></label>
                        <select class="custom-select">
                            <option selected>United States</option>
                            <option>Afghanistan</option>
                            <option>Albania</option>
                            <option>Algeria</option>
                        </select>
                    </div>

                    <div class="col-md-6 form-group">
                        <label><?php echo t('checkout.form.city.label'); ?></label>
                        <input class="form-control" type="text" placeholder="<?php echo t('checkout.form.city.placeholder'); ?>">
                    </div>

                    <div class="col-md-6 form-group">
                        <label><?php echo t('checkout.form.state.label'); ?></label>
                        <input class="form-control" type="text" placeholder="<?php echo t('checkout.form.state.placeholder'); ?>">
                    </div>

                    <div class="col-md-6 form-group">
                        <label><?php echo t('checkout.form.zip.label'); ?></label>
                        <input class="form-control" type="text" placeholder="<?php echo t('checkout.form.zip.placeholder'); ?>">
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

                    <div class="d-flex justify-content-between">
                        <p>Colorful Stylish Shirt 1</p>
                        <p>$150</p>
                    </div>
                    <div class="d-flex justify-content-between">
                        <p>Colorful Stylish Shirt 2</p>
                        <p>$150</p>
                    </div>
                    <div class="d-flex justify-content-between">
                        <p>Colorful Stylish Shirt 3</p>
                        <p>$150</p>
                    </div>

                    <hr class="mt-0">

                    <div class="d-flex justify-content-between mb-3 pt-1">
                        <h6 class="font-weight-medium"><?php echo t('checkout.summary.subtotal'); ?></h6>
                        <h6 class="font-weight-medium">$150</h6>
                    </div>

                    <div class="d-flex justify-content-between">
                        <h6 class="font-weight-medium"><?php echo t('checkout.summary.shipping'); ?></h6>
                        <h6 class="font-weight-medium">$10</h6>
                    </div>
                </div>

                <div class="card-footer border-secondary bg-transparent">
                    <div class="d-flex justify-content-between mt-2">
                        <h5 class="font-weight-bold"><?php echo t('checkout.summary.total'); ?></h5>
                        <h5 class="font-weight-bold">$160</h5>
                    </div>
                </div>
            </div>

            <div class="card border-secondary mb-5">
                <div class="card-header bg-secondary border-0">
                    <h4 class="font-weight-semi-bold m-0"><?php echo t('checkout.payment.title'); ?></h4>
                </div>

                <div class="card-body">
                    <div class="form-group">
                        <div class="custom-control custom-radio">
                            <input type="radio" class="custom-control-input" name="payment" id="paypal">
                            <label class="custom-control-label" for="paypal">Paypal</label>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="custom-control custom-radio">
                            <input type="radio" class="custom-control-input" name="payment" id="directcheck">
                            <label class="custom-control-label" for="directcheck">Direct Check</label>
                        </div>
                    </div>

                    <div class="">
                        <div class="custom-control custom-radio">
                            <input type="radio" class="custom-control-input" name="payment" id="banktransfer">
                            <label class="custom-control-label" for="banktransfer">Bank Transfer</label>
                        </div>
                    </div>
                </div>

                <div class="card-footer border-secondary bg-transparent">
                    <button class="btn btn-lg btn-block btn-primary font-weight-bold my-3 py-3">
                        <?php echo t('checkout.payment.place_order'); ?>
                    </button>
                </div>
            </div>
        </div>

    </div>
</div>
<!-- Checkout End -->

<?php include 'includes/footer.php'; ?>

</body>

</html>