<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<form class="form-page" method="post" enctype="multipart/form-data" action="<?= $member ? site_url('staff/' . $member['id']) : site_url('staff') ?>">
    <?= csrf_field() ?>
    <section class="panel form-panel"><div class="section-heading"><div><p class="eyebrow">Account details</p><h2><?= $member ? 'Update staff member' : 'Create staff account' ?></h2></div></div><div class="form-grid">
        <div class="field"><label for="full_name">Full name</label><input id="full_name" name="full_name" value="<?= old('full_name', $member['full_name'] ?? '') ?>" maxlength="100" required></div>
        <div class="field"><label for="username">Username</label><input id="username" name="username" value="<?= old('username', $member['username'] ?? '') ?>" maxlength="50" required></div>
        <div class="field span-2"><label for="password">Password <?= $member ? '<span class="optional">Leave blank to keep current password</span>' : '' ?></label><input id="password" name="password" type="password" minlength="8" maxlength="255" <?= $member ? '' : 'required' ?> autocomplete="new-password"><small>Use at least 8 characters.</small></div>
        <div class="field span-2"><label for="avatar">Avatar <span class="optional">Optional</span></label><input id="avatar" name="avatar" type="file" accept="image/jpeg,image/png,image/webp" data-preview="avatarPreview"><small>JPG, PNG, or WebP up to 2 MB. Images are cropped to a square.</small></div>
        <div class="image-preview avatar-preview span-2" id="avatarPreview"><?php if (! empty($member['avatar'])): ?><img src="<?= base_url(esc($member['avatar'])) ?>" alt="Current avatar"><?php else: ?><i data-lucide="user-round"></i><span>Avatar preview</span><?php endif ?></div>
        <?php if ($member): ?><div class="field span-2"><input type="hidden" name="is_active" value="0"><label class="switch-row"><input type="checkbox" name="is_active" value="1" <?= old('is_active', $member['is_active']) ? 'checked' : '' ?> <?= (int) $member['id'] === (int) session('user_id') ? 'disabled' : '' ?>><span class="switch"></span><span>Staff account is active</span></label><?php if ((int) $member['id'] === (int) session('user_id')): ?><input type="hidden" name="is_active" value="1"><?php endif ?></div><?php endif ?>
    </div></section>
    <div class="form-actions"><a class="button secondary" href="<?= site_url('staff') ?>">Cancel</a><button class="button primary" type="submit"><i data-lucide="save"></i><span><?= $member ? 'Save changes' : 'Add staff' ?></span></button></div>
</form>
<?= $this->endSection() ?>
