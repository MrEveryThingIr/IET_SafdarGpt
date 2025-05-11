<?php


?>
<h1 class="text-3xl font-bold">Welcome, <?= sanitize($user->firstname ?? '') ?></h1>
<p>Your email: <?= sanitize_email($user->email ?? '') ?></p>
<a href="<?= route('auth.logout') ?>" class="text-red-500">Logout</a>
