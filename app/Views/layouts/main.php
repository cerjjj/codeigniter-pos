<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#174c3c">
    <title><?= esc($title ?? 'Storefront POS') ?> | Storefront POS</title>
    <link rel="stylesheet" href="<?= base_url('assets/css/app.css') ?>">
</head>
<body>
<?php $path = uri_string(); ?>
<div class="app-shell">
    <aside class="sidebar" id="sidebar">
        <a class="brand" href="<?= site_url('dashboard') ?>" aria-label="Storefront POS dashboard">
            <span class="brand-mark"><i data-lucide="scan-line"></i></span>
            <span><strong>Storefront</strong><small>Point of Sale</small></span>
        </a>
        <nav class="nav-list" aria-label="Primary navigation">
            <a class="<?= $path === 'dashboard' ? 'active' : '' ?>" href="<?= site_url('dashboard') ?>"><i data-lucide="layout-dashboard"></i><span>Dashboard</span></a>
            <a class="<?= str_starts_with($path, 'sales/new') ? 'active' : '' ?>" href="<?= site_url('sales/new') ?>"><i data-lucide="shopping-cart"></i><span>Record sale</span></a>
            <a class="<?= $path === 'sales' ? 'active' : '' ?>" href="<?= site_url('sales') ?>"><i data-lucide="receipt-text"></i><span>Sales history</span></a>
            <span class="nav-label">Management</span>
            <a class="<?= str_starts_with($path, 'products') ? 'active' : '' ?>" href="<?= site_url('products') ?>"><i data-lucide="package"></i><span>Products</span></a>
            <a class="<?= str_starts_with($path, 'customers') ? 'active' : '' ?>" href="<?= site_url('customers') ?>"><i data-lucide="users"></i><span>Customers</span></a>
            <a class="<?= str_starts_with($path, 'staff') ? 'active' : '' ?>" href="<?= site_url('staff') ?>"><i data-lucide="badge-check"></i><span>Staff</span></a>
        </nav>
        <div class="sidebar-user">
            <div class="avatar">
                <?php if (session('avatar')): ?>
                    <img src="<?= base_url(esc(session('avatar'))) ?>" alt="">
                <?php else: ?>
                    <?= esc(strtoupper(substr((string) session('full_name'), 0, 1))) ?>
                <?php endif ?>
            </div>
            <div class="user-copy"><strong><?= esc(session('full_name')) ?></strong><small>@<?= esc(session('username')) ?></small></div>
            <form action="<?= site_url('logout') ?>" method="post">
                <?= csrf_field() ?>
                <button class="icon-button inverse" type="submit" title="Sign out" aria-label="Sign out"><i data-lucide="log-out"></i></button>
            </form>
        </div>
    </aside>

    <main class="main-area">
        <header class="topbar">
            <button class="icon-button menu-button" type="button" id="menuButton" aria-label="Open navigation" aria-controls="sidebar" aria-expanded="false"><i data-lucide="menu"></i></button>
            <div><p class="eyebrow">Store operations</p><h1><?= esc($title ?? '') ?></h1></div>
            <a class="button primary compact-sale" href="<?= site_url('sales/new') ?>"><i data-lucide="plus"></i><span>New sale</span></a>
        </header>
        <div class="content-wrap">
            <?= view('partials/flash') ?>
            <?= $this->renderSection('content') ?>
        </div>
    </main>
</div>
<div class="scrim" id="scrim"></div>
<script src="<?= base_url('assets/vendor/lucide.min.js') ?>"></script>
<script src="<?= base_url('assets/js/app.js') ?>"></script>
</body>
</html>
