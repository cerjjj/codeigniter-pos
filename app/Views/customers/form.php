<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<form class="form-page" method="post" action="<?= $customer ? site_url('customers/' . $customer['id']) : site_url('customers') ?>">
    <?= csrf_field() ?>
    <section class="panel form-panel"><div class="section-heading"><div><p class="eyebrow">Customer details</p><h2><?= $customer ? 'Update customer' : 'Create customer' ?></h2></div></div><div class="form-grid">
        <div class="field span-2"><label for="full_name">Full name</label><input id="full_name" name="full_name" value="<?= old('full_name', $customer['full_name'] ?? '') ?>" maxlength="100" required></div>
        <div class="field"><label for="email">Email address</label><input id="email" name="email" type="email" value="<?= old('email', $customer['email'] ?? '') ?>" maxlength="100" required></div>
        <div class="field"><label for="phone">Phone number <span class="optional">Optional</span></label><input id="phone" name="phone" type="tel" value="<?= old('phone', $customer['phone'] ?? '') ?>" maxlength="20"></div>
    </div></section>
    <div class="form-actions"><a class="button secondary" href="<?= site_url('customers') ?>">Cancel</a><button class="button primary" type="submit"><i data-lucide="save"></i><span><?= $customer ? 'Save changes' : 'Add customer' ?></span></button></div>
</form>
<?= $this->endSection() ?>
