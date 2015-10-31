<?php if (!defined('FLUX_ROOT')) exit; ?>
<h2>Processamento de Doações</h2>

<?php if (!empty($errorMessage)): ?>
		<p class="red"><?php echo htmlspecialchars($errorMessage) ?></p>
<?php endif ?>