<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<section class="panel">
    <div class="section-heading"><div><p class="eyebrow">Directory</p><h2><?= count($customers) ?> customers</h2></div><a class="button primary" href="<?= site_url('customers/new') ?>"><i data-lucide="user-plus"></i><span>Add customer</span></a></div>
    <div class="table-wrap"><table><thead><tr><th>Customer</th><th>Email</th><th>Phone</th><th class="actions">Actions</th></tr></thead><tbody>
    <?php foreach ($customers as $customer): ?><tr><td><strong><?= esc($customer['full_name']) ?></strong></td><td><a class="plain-link" href="mailto:<?= esc($customer['email']) ?>"><?= esc($customer['email']) ?></a></td><td><?= esc($customer['phone'] ?: 'Not provided') ?></td><td class="actions"><a class="icon-button" href="<?= site_url('customers/' . $customer['id'] . '/edit') ?>" title="Edit customer" aria-label="Edit <?= esc($customer['full_name']) ?>"><i data-lucide="pencil"></i></a><form method="post" action="<?= site_url('customers/' . $customer['id'] . '/delete') ?>" data-confirm="Delete this customer? Their name will become Walk-in in existing sales history."><?= csrf_field() ?><button class="icon-button danger" type="submit" title="Delete customer" aria-label="Delete <?= esc($customer['full_name']) ?>"><i data-lucide="trash-2"></i></button></form></td></tr><?php endforeach ?>
    </tbody></table></div>
</section>
<?= $this->endSection() ?>
