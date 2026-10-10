<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<form class="sale-layout" method="post" action="<?= site_url('sales') ?>" id="saleForm">
    <?= csrf_field() ?>
    <section class="panel form-panel"><div class="section-heading"><div><p class="eyebrow">Transaction</p><h2>Sale details</h2></div></div><div class="form-stack">
        <div class="field"><label for="product_id">Product</label><select id="product_id" name="product_id" required data-product-select><option value="">Select a product</option><?php foreach ($products as $product): ?><option value="<?= $product['id'] ?>" data-price="<?= $product['price'] ?>" data-stock="<?= $product['stock_quantity'] ?>" <?= (string) old('product_id') === (string) $product['id'] ? 'selected' : '' ?>><?= esc($product['name']) ?> - PHP <?= number_format($product['price'], 2) ?> (<?= number_format($product['stock_quantity']) ?> available)</option><?php endforeach ?></select></div>
        <div class="field"><label for="customer_id">Customer <span class="optional">Optional</span></label><select id="customer_id" name="customer_id"><option value="">Walk-in customer</option><?php foreach ($customers as $customer): ?><option value="<?= $customer['id'] ?>" <?= (string) old('customer_id') === (string) $customer['id'] ? 'selected' : '' ?>><?= esc($customer['full_name']) ?></option><?php endforeach ?></select></div>
        <div class="field"><label for="quantity">Quantity</label><input id="quantity" name="quantity" type="number" min="1" step="1" value="<?= old('quantity', 1) ?>" required data-quantity><small data-stock-message>Select a product to see its available stock.</small></div>
    </div></section>
    <aside class="panel sale-summary"><p class="eyebrow">Order summary</p><h2>Ready to record</h2><div class="summary-row"><span>Unit price</span><strong data-unit-price>PHP 0.00</strong></div><div class="summary-row"><span>Quantity</span><strong data-summary-quantity>1</strong></div><div class="summary-total"><span>Total</span><strong data-sale-total>PHP 0.00</strong></div><button class="button primary full" type="submit"><i data-lucide="check"></i><span>Complete sale</span></button><p class="summary-note"><i data-lucide="shield-check"></i><span>Stock is checked and updated in the same database transaction.</span></p></aside>
</form>
<?= $this->endSection() ?>
