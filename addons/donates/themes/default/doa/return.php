<?php if (!defined('FLUX_ROOT')) exit; ?>
<h2>Agradecemos a Sua Doação</h2>

<?php if (!empty($errorMessage)): ?>
		<p class="red"><?php echo htmlspecialchars($errorMessage) ?></p>
<?php endif ?>

<meta http-equiv="refresh" content="10; url=<?php echo $this->url('doa', 'history', array('_host' => true)); ?>" />

<p>Agradecemos por sua doação <?php echo htmlspecialchars($session->account->userid) ?>, ela é muito importante
para nós e será utilizada para melhoria de nossos servidores.
Assim que aprovada pelo sistema do PagSeguro seus créditos serão automaticamente adicionados em sua conta.</p>
<p>Você está sendo redirecionado para a página Histórico do PagSeguro para visualizar o status de sua doação.</p>