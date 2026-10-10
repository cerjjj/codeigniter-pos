<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<div class="metrics-grid">
    <article class="metric"><span class="metric-icon green"><i data-lucide="package"></i></span><div><small>Active products</small><strong><?= number_format($productCount) ?></strong></div></article>
    <article class="metric"><span class="metric-icon blue"><i data-lucide="users"></i></span><div><small>Customers</small><strong><?= number_format($customerCount) ?></strong></div></article>
    <article class="metric"><span class="metric-icon amber"><i data-lucide="receipt-text"></i></span><div><small>Transactions</small><strong><?= number_format($saleCount) ?></strong></div></article>
    <article class="metric"><span class="metric-icon rose"><i data-lucide="banknote"></i></span><div><small>Total revenue</small><strong>PHP <?= number_format($revenue, 2) ?></strong></div></article>
</div>

<div class="dashboard-grid">
    <section class="panel">
        <div class="section-heading"><div><p class="eyebrow">Latest activity</p><h2>Recent sales</h2></div><a class="text-link" href="<?= site_url('sales') ?>">View all <i data-lucide="arrow-right"></i></a></div>
        <div class="table-wrap">
            <table>
                <thead><tr><th>Product</th><th>Customer</th><th class="number">Qty</th><th class="number">Total</th></tr></thead>
                <tbody>
                <?php if ($recentSales): foreach ($recentSales as $sale): ?>
                    <tr><td><strong><?= esc($sale['product_name']) ?></strong><small><?= date('M j, g:i A', strtotime($sale['created_at'])) ?></small></td><td><?= esc($sale['customer_name'] ?: 'Walk-in') ?></td><td class="number"><?= number_format($sale['quantity']) ?></td><td class="number">PHP <?= number_format($sale['total_price'], 2) ?></td></tr>
                <?php endforeach; else: ?>
                    <tr><td colspan="4"><div class="empty-inline">No sales yet. <a href="<?= site_url('sales/new') ?>">Record the first sale</a>.</div></td></tr>
                <?php endif ?>
                </tbody>
            </table>
        </div>
    </section>

    <section class="panel stock-panel">
        <div class="section-heading"><div><p class="eyebrow">Attention</p><h2>Low stock</h2></div><a class="icon-button" href="<?= site_url('products') ?>" title="Manage products" aria-label="Manage products"><i data-lucide="settings-2"></i></a></div>
        <?php if ($lowStock): ?>
            <div class="stock-list">
            <?php foreach ($lowStock as $product): ?>
                <div class="stock-row"><div><strong><?= esc($product['name']) ?></strong><small>PHP <?= number_format($product['price'], 2) ?></small></div><span class="stock-count <?= $product['stock_quantity'] <= 3 ? 'critical' : '' ?>"><?= number_format($product['stock_quantity']) ?> left</span></div>
            <?php endforeach ?>
            </div>
        <?php else: ?>
            <div class="empty-state small"><i data-lucide="badge-check"></i><strong>Stock looks healthy</strong><p>No active product is below 11 units.</p></div>
        <?php endif ?>
    </section>
</div>
<?= $this->endSection() ?>
