<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#174c3c">
    <title>Sign in | Storefront POS</title>
    <link rel="stylesheet" href="<?= base_url('assets/css/app.css') ?>">
</head>
<body class="login-page">
<main class="login-shell">
    <section class="login-brand" aria-label="Storefront POS">
        <div class="brand-mark large"><i data-lucide="scan-line"></i></div>
        <p class="eyebrow">Store operations</p>
        <h1>Storefront POS</h1>
        <p>Inventory, customers, staff, and every sale in one focused workspace.</p>
        <div class="login-pattern" aria-hidden="true">
            <i data-lucide="package-check"></i><i data-lucide="receipt-text"></i><i data-lucide="chart-no-axes-combined"></i>
        </div>
    </section>
    <section class="login-panel">
        <div class="login-form-wrap">
            <p class="eyebrow">Welcome back</p>
            <h2>Sign in to your register</h2>
            <p class="muted">Use your staff account to continue.</p>
            <?= view('partials/flash') ?>
            <form action="<?= site_url('login') ?>" method="post" class="form-stack">
                <?= csrf_field() ?>
                <div class="field">
                    <label for="username">Username</label>
                    <div class="input-with-icon"><i data-lucide="user"></i><input id="username" name="username" type="text" value="<?= old('username') ?>" autocomplete="username" required autofocus></div>
                </div>
                <div class="field">
                    <label for="password">Password</label>
                    <div class="input-with-icon"><i data-lucide="lock-keyhole"></i><input id="password" name="password" type="password" autocomplete="current-password" required></div>
                </div>
                <button class="button primary full" type="submit"><span>Sign in</span><i data-lucide="arrow-right"></i></button>
            </form>
            <p class="demo-note"><strong>Demo:</strong> admin / Admin123!</p>
        </div>
    </section>
</main>
<script src="<?= base_url('assets/vendor/lucide.min.js') ?>"></script>
<script src="<?= base_url('assets/js/app.js') ?>"></script>
</body>
</html>
