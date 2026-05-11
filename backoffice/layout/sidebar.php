<nav id="sidebar">
    <div class="sidebar-header">
        <h3>DANISHOPPER</h3>
    </div>

    <ul class="list-unstyled components">
        <li class="<?= basename($_SERVER['PHP_SELF']) == 'index.php' ? 'active' : '' ?>">
            <a href="index.php"><i class="bi bi-speedometer2"></i> Dashboard</a>
        </li>

        <div class="sidebar-heading">Catalog</div>
        <li class="<?= basename($_SERVER['PHP_SELF']) == 'products.php' ? 'active' : '' ?>">
            <a href="products.php"><i class="bi bi-box-seam"></i> Products</a>
        </li>
        <li class="<?= basename($_SERVER['PHP_SELF']) == 'product_variants.php' ? 'active' : '' ?>">
            <a href="product_variants.php"><i class="bi bi-layers"></i> Variants</a>
        </li>
        <li class="<?= basename($_SERVER['PHP_SELF']) == 'categories.php' ? 'active' : '' ?>">
            <a href="categories.php"><i class="bi bi-tags"></i> Categories</a>
        </li>
        <li class="<?= basename($_SERVER['PHP_SELF']) == 'colors.php' ? 'active' : '' ?>">
            <a href="colors.php"><i class="bi bi-palette"></i> Colors</a>
        </li>
        <li class="<?= basename($_SERVER['PHP_SELF']) == 'sizes.php' ? 'active' : '' ?>">
            <a href="sizes.php"><i class="bi bi-rulers"></i> Sizes</a>
        </li>

        <div class="sidebar-heading">Sales</div>
        <li class="<?= basename($_SERVER['PHP_SELF']) == 'orders.php' ? 'active' : '' ?>">
            <a href="orders.php"><i class="bi bi-cart-check"></i> Orders</a>
        </li>
        <li class="<?= basename($_SERVER['PHP_SELF']) == 'payment_methods.php' ? 'active' : '' ?>">
            <a href="payment_methods.php"><i class="bi bi-credit-card"></i> Payment Methods</a>
        </li>

        <div class="sidebar-heading">Customers</div>
        <li class="<?= basename($_SERVER['PHP_SELF']) == 'users.php' ? 'active' : '' ?>">
            <a href="users.php"><i class="bi bi-people"></i> Users</a>
        </li>
        <li class="<?= basename($_SERVER['PHP_SELF']) == 'addresses.php' ? 'active' : '' ?>">
            <a href="addresses.php"><i class="bi bi-geo-alt"></i> Addresses</a>
        </li>
        <li class="<?= basename($_SERVER['PHP_SELF']) == 'countries.php' ? 'active' : '' ?>">
            <a href="countries.php"><i class="bi bi-globe"></i> Countries</a>
        </li>

        <div class="sidebar-heading">Content</div>
        <li class="<?= (basename($_SERVER['PHP_SELF']) == 'news.php' || basename($_SERVER['PHP_SELF']) == 'news_form.php') ? 'active' : '' ?>">
            <a href="news.php"><i class="bi bi-newspaper"></i> News</a>
        </li>
        <li class="<?= basename($_SERVER['PHP_SELF']) == 'reviews.php' ? 'active' : '' ?>">
            <a href="reviews.php"><i class="bi bi-star"></i> Reviews</a>
        </li>

        <div class="sidebar-heading">System</div>
        <li class="<?= basename($_SERVER['PHP_SELF']) == 'messages.php' ? 'active' : '' ?>">
            <a href="messages.php"><i class="bi bi-envelope"></i> Messages</a>
        </li>
        <li class="<?= basename($_SERVER['PHP_SELF']) == 'stores.php' ? 'active' : '' ?>">
            <a href="stores.php"><i class="bi bi-shop"></i> Stores</a>
        </li>
        <li class="<?= basename($_SERVER['PHP_SELF']) == 'traduz.php' ? 'active' : '' ?>">
            <a href="traduz.php"><i class="bi bi-translate"></i> Translations</a>
        </li>
        <li class="<?= basename($_SERVER['PHP_SELF']) == 'lang.php' ? 'active' : '' ?>">
            <a href="lang.php"><i class="bi bi-flag"></i> Languages</a>
        </li>
        <li class="<?= basename($_SERVER['PHP_SELF']) == 'carts.php' ? 'active' : '' ?>">
            <a href="carts.php"><i class="bi bi-cart"></i> Active Carts</a>
        </li>
        <li class="<?= basename($_SERVER['PHP_SELF']) == 'settings_email.php' ? 'active' : '' ?>">
            <a href="settings_email.php"><i class="bi bi-envelope-at"></i> Email Settings</a>
        </li>
    </ul>

    <div class="px-4 py-3 mt-auto">
        <a href="../index.php" class="btn btn-outline-light btn-sm w-100"><i class="bi bi-box-arrow-up-right"></i> View Site</a>
    </div>
</nav>