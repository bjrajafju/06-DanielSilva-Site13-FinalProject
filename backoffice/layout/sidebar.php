<nav id="sidebar">
    <div class="sidebar-header">
        <h3>DANISHOPPER</h3>
    </div>

    <ul class="list-unstyled components">
        <li class="<?= basename($_SERVER['PHP_SELF']) == 'index.php' ? 'active' : '' ?>">
            <a href="index.php"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
        </li>

        <div class="sidebar-heading">Catalog</div>
        <li class="<?= basename($_SERVER['PHP_SELF']) == 'products.php' ? 'active' : '' ?>">
            <a href="products.php"><i class="fas fa-box"></i> Products</a>
        </li>
        <li class="<?= basename($_SERVER['PHP_SELF']) == 'product_variants.php' ? 'active' : '' ?>">
            <a href="product_variants.php"><i class="fas fa-layer-group"></i> Variants</a>
        </li>
        <li class="<?= basename($_SERVER['PHP_SELF']) == 'categories.php' ? 'active' : '' ?>">
            <a href="categories.php"><i class="fas fa-tags"></i> Categories</a>
        </li>
        <li class="<?= basename($_SERVER['PHP_SELF']) == 'colors.php' ? 'active' : '' ?>">
            <a href="colors.php"><i class="fas fa-palette"></i> Colors</a>
        </li>
        <li class="<?= basename($_SERVER['PHP_SELF']) == 'sizes.php' ? 'active' : '' ?>">
            <a href="sizes.php"><i class="fas fa-ruler-combined"></i> Sizes</a>
        </li>

        <div class="sidebar-heading">Sales</div>
        <li class="<?= basename($_SERVER['PHP_SELF']) == 'orders.php' ? 'active' : '' ?>">
            <a href="orders.php"><i class="fas fa-shopping-cart"></i> Orders</a>
        </li>
        <li class="<?= basename($_SERVER['PHP_SELF']) == 'payment_methods.php' ? 'active' : '' ?>">
            <a href="payment_methods.php"><i class="fas fa-credit-card"></i> Payment Methods</a>
        </li>

        <div class="sidebar-heading">Customers</div>
        <li class="<?= basename($_SERVER['PHP_SELF']) == 'users.php' ? 'active' : '' ?>">
            <a href="users.php"><i class="fas fa-users"></i> Users</a>
        </li>
        <li class="<?= basename($_SERVER['PHP_SELF']) == 'addresses.php' ? 'active' : '' ?>">
            <a href="addresses.php"><i class="fas fa-map-marker-alt"></i> Addresses</a>
        </li>
        <li class="<?= basename($_SERVER['PHP_SELF']) == 'countries.php' ? 'active' : '' ?>">
            <a href="countries.php"><i class="fas fa-globe"></i> Countries</a>
        </li>

        <div class="sidebar-heading">Content</div>
        <li
            class="<?= (basename($_SERVER['PHP_SELF']) == 'news.php' || basename($_SERVER['PHP_SELF']) == 'news_form.php') ? 'active' : '' ?>">
            <a href="news.php"><i class="fas fa-newspaper"></i> News</a>
        </li>
        <li class="<?= basename($_SERVER['PHP_SELF']) == 'reviews.php' ? 'active' : '' ?>">
            <a href="reviews.php"><i class="fas fa-star"></i> Reviews</a>
        </li>

        <div class="sidebar-heading">System</div>
        <li class="<?= basename($_SERVER['PHP_SELF']) == 'messages.php' ? 'active' : '' ?>">
            <a href="messages.php"><i class="fas fa-envelope"></i> Messages</a>
        </li>
        <li class="<?= basename($_SERVER['PHP_SELF']) == 'stores.php' ? 'active' : '' ?>">
            <a href="stores.php"><i class="fas fa-store"></i> Stores</a>
        </li>
        <li class="<?= basename($_SERVER['PHP_SELF']) == 'traduz.php' ? 'active' : '' ?>">
            <a href="traduz.php"><i class="fas fa-language"></i> Translations</a>
        </li>
        <li class="<?= basename($_SERVER['PHP_SELF']) == 'lang.php' ? 'active' : '' ?>">
            <a href="lang.php"><i class="fas fa-flag"></i> Languages</a>
        </li>
        <li class="<?= basename($_SERVER['PHP_SELF']) == 'carts.php' ? 'active' : '' ?>">
            <a href="carts.php"><i class="fas fa-shopping-basket"></i> Active Carts</a>
        </li>
        <li class="<?= basename($_SERVER['PHP_SELF']) == 'settings_email.php' ? 'active' : '' ?>">
            <a href="settings_email.php"><i class="fas fa-at"></i> Email Settings</a>
        </li>
    </ul>

    <div class="px-4 py-3 mt-auto">
        <a href="../index.php" class="btn btn-outline-light btn-sm w-100"><i class="fas fa-external-link-alt"></i> View
            Site</a>
    </div>
</nav>

