<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<section class="panel">
    <div class="section-heading"><div><p class="eyebrow">Catalog</p><h2><?= count($products) ?> products</h2></div><a class="button primary" href="<?= site_url('products/new') ?>"><i data-lucide="plus"></i><span>Add product</span></a></div>
    <div class="table-wrap">
        <table>
            <thead><tr><th>Product</th><th class="number">Price</th><th class="number">Stock</th><th>Status</th><th class="actions">Actions</th></tr></thead>
            <tbody>
            <?php foreach ($products as $product): ?>
                <tr class="<?= $product['is_active'] ? '' : 'muted-row' ?>">
                    <td><div class="entity"><div class="thumb product-thumb"><?php if ($product['image']): ?><img src="<?= base_url(esc($product['image'])) ?>" alt="<?= esc($product['name']) ?>"><?php else: ?><i data-lucide="image"></i><?php endif ?></div><strong><?= esc($product['name']) ?></strong></div></td>
                    <td class="number">PHP <?= number_format($product['price'], 2) ?></td>
                    <td class="number"><span class="stock-count <?= $product['stock_quantity'] <= 3 ? 'critical' : '' ?>"><?= number_format($product['stock_quantity']) ?></span></td>
                    <td><span class="badge <?= $product['is_active'] ? 'active' : 'archived' ?>"><?= $product['is_active'] ? 'Active' : 'Archived' ?></span></td>
                    <td class="actions"><a class="icon-button" href="<?= site_url('products/' . $product['id'] . '/edit') ?>" title="Edit product" aria-label="Edit <?= esc($product['name']) ?>"><i data-lucide="pencil"></i></a><form method="post" action="<?= site_url('products/' . $product['id'] . '/archive') ?>"><?= csrf_field() ?><button class="icon-button" type="submit" title="<?= $product['is_active'] ? 'Archive' : 'Restore' ?> product" aria-label="<?= $product['is_active'] ? 'Archive' : 'Restore' ?> <?= esc($product['name']) ?>"><i data-lucide="<?= $product['is_active'] ? 'archive' : 'archive-restore' ?>"></i></button></form></td>
                </tr>
            <?php endforeach ?>
            </tbody>
        </table>
    </div>
</section>
<?= $this->endSection() ?>
