<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<form class="form-page" method="post" enctype="multipart/form-data" action="<?= $product ? site_url('products/' . $product['id']) : site_url('products') ?>">
    <?= csrf_field() ?>
    <section class="panel form-panel">
        <div class="section-heading"><div><p class="eyebrow">Product details</p><h2><?= $product ? 'Update catalog item' : 'Create catalog item' ?></h2></div></div>
        <div class="form-grid">
            <div class="field span-2"><label for="name">Product name</label><input id="name" name="name" value="<?= old('name', $product['name'] ?? '') ?>" maxlength="100" required></div>
            <div class="field"><label for="price">Price</label><div class="money-input"><span>PHP</span><input id="price" name="price" type="number" min="0" step="0.01" value="<?= old('price', $product['price'] ?? '') ?>" required></div></div>
            <div class="field"><label for="stock_quantity">Stock quantity</label><input id="stock_quantity" name="stock_quantity" type="number" min="0" step="1" value="<?= old('stock_quantity', $product['stock_quantity'] ?? 0) ?>" required></div>
            <div class="field span-2"><label for="image">Product image</label><input id="image" name="image" type="file" accept="image/jpeg,image/png,image/webp" data-preview="imagePreview"><small>JPG, PNG, or WebP up to 3 MB. Images are cropped to a display-ready 900 x 700 size.</small></div>
            <div class="image-preview span-2" id="imagePreview"><?php if (! empty($product['image'])): ?><img src="<?= base_url(esc($product['image'])) ?>" alt="Current product image"><?php else: ?><i data-lucide="image-plus"></i><span>Image preview</span><?php endif ?></div>
            <?php if ($product): ?><div class="field span-2"><input type="hidden" name="is_active" value="0"><label class="switch-row"><input type="checkbox" name="is_active" value="1" <?= old('is_active', $product['is_active']) ? 'checked' : '' ?>><span class="switch"></span><span>Product is active and available for sale</span></label></div><?php endif ?>
        </div>
    </section>
    <div class="form-actions"><a class="button secondary" href="<?= site_url('products') ?>">Cancel</a><button class="button primary" type="submit"><i data-lucide="save"></i><span><?= $product ? 'Save changes' : 'Add product' ?></span></button></div>
</form>
<?= $this->endSection() ?>
