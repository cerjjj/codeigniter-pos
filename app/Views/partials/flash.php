<?php if (session('success')): ?>
    <div class="alert success" role="status"><i data-lucide="circle-check"></i><span><?= esc(session('success')) ?></span></div>
<?php endif ?>
<?php if (session('error')): ?>
    <div class="alert error" role="alert"><i data-lucide="circle-alert"></i><span><?= esc(session('error')) ?></span></div>
<?php endif ?>
<?php if (session('errors')): ?>
    <div class="alert error" role="alert">
        <i data-lucide="circle-alert"></i>
        <div><?php foreach (session('errors') as $message): ?><div><?= esc($message) ?></div><?php endforeach ?></div>
    </div>
<?php endif ?>
