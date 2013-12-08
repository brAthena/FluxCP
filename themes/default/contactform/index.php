<?php
/* Contact Form Addon
 * Created and maintained by Akkarin
 * Current Version: 1.00.01
 */
 
if (!defined('FLUX_ROOT')) exit;
$this->loginRequired();
?>
<?php if (isset($errorMessage)): ?>
<p class="red"><?php echo htmlspecialchars($errorMessage) ?></p>
<?php endif ?>

<h2><?php echo htmlspecialchars(Flux::message('CFTitleSubmit')) ?></h2>
<form action="<?php echo $this->urlWithQs ?>" method="post">
	<table class="vertical-table" width="100%">
		<tr>
			<th>ID da Conta</th>
			<td><input type="text" name="account_id" id="account_id" value="<?php echo $session->account->account_id ?>" readonly="readonly" /></td>
		</tr>
		<tr>
			<th>Nome da Conta</th>
			<td><input type="text" name="userid" id="userid" value="<?php echo $session->account->userid ?>" readonly="readonly" /></td>
		</tr>
		<tr>
			<th>De E-mail</th>
			<td><input type="text" name="email" id="email" value="<?php echo $session->account->email ?>" readonly="readonly" /></td>
		</tr>
		<tr>
			<th>Assunto</th>
			<td><input type="text" name="subject" id="subject" size="50" /><br />Digite uma breve descrição sobre esta mensagem.</td>
		</tr>
		<tr>
			<th>Texto</th>
			<td>
				<textarea name="body"></textarea>
			</td>
		</tr>

		<tr>
			<td colspan="2"><input type="hidden" name="ip" value="<?php echo $_SERVER['REMOTE_ADDR'] ?>" /><input type="submit" value="Enviar" /></td>
		</tr>
    </table>
</form>