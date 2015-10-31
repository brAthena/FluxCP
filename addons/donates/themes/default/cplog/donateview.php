<?php if (!defined('FLUX_ROOT')) exit; ?>
<h2>Visualizando Detalhes da Transação</h2>
<?php if (!empty($errorMessage)): ?>
		<p class="red"><?php echo htmlspecialchars($errorMessage) ?></p>
<?php endif ?>
<?php if ($transaction): ?>
<table class="vertical-table">
	<tr>
		<th>Transação</th>
		<td><?php echo $transaction->id ?></td>
		<th>Login da Conta</th>
		<td>
			<?php if ($auth->actionAllowed('account', 'view') && $auth->allowedToViewAccount): ?>
				<?php echo $this->linkToAccount($transaction->account_id, $transaction->userid) ?>
			<?php else: ?>
				<?php echo $transaction->userid ?>
			<?php endif ?>
		</td>
	</tr>
	<tr>
		<th>ID da Conta</th>
		<td>
			<?php if ($auth->actionAllowed('account', 'view') && $auth->allowedToViewAccount): ?>
				<?php echo $this->linkToAccount($transaction->account_id, $transaction->account_id) ?>
			<?php else: ?>
				<?php echo $transaction->account_id ?>
			<?php endif ?>
		</td>
		<th>Email da Conta</th>
		<td>
			<?php if ($auth->actionAllowed('account', 'view') && $auth->allowedToViewAccount): ?>
				<?php echo $this->linkToAccount($transaction->account_id, $transaction->email) ?>
			<?php else: ?>
				<?php echo htmlspecialchars($transaction->email) ?>
			<?php endif ?>
		</td>
	</tr>
	<tr>
		<th>Data da Doação</th>
		<td><?php echo htmlspecialchars(date(Flux::config('DateTimeFormat'), strtotime($transaction->payment_date))) ?></td>
		<th>Valor</th>
		<td>R$ <?php echo htmlspecialchars($this->formatCurrency($transaction->payment)) ?></td>
	</tr>
	<tr>
		<th>Endereço Ip</th>
		<td><?php echo htmlspecialchars($transaction->payment_ip) ?></td>
		
		<th>Tipo</th>
		<td><?php echo htmlspecialchars($transaction->payment_type) ?></td>
	</tr>
	<tr>
		<th>ID da Transação</th>
		<td><?php echo htmlspecialchars($transaction->payment_id) ?></td>
		<th>Status</th>
		<td>Status de 
			<?php $status = Flux::config('PagSeguroStatus')->toArray();
			echo htmlspecialchars($status[$transaction->payment_status_pagseguro]) ?> no PagSeguro.
		</td>
	</tr>
<?php if ($transaction->payment_code || $transaction->payment_notification_code): ?>
	<tr>
		<th>Forma de Pagamento</th>
		<td><?php $type = Flux::config('PagSeguroType')->toArray();
		echo htmlspecialchars($type[$transactionPagseguro->getPaymentMethod()->getType()->getValue()]) ?></td>
		
		<th>Nome Doador</th>
		<td><?php echo $transactionPagseguro->getSender()->getName() ?></td>
	</tr>
	<tr>
		<th>Telefone Doador</th>
		<td><?php echo '('.htmlspecialchars($transactionPagseguro->getSender()->getPhone()->getAreaCode().')'.$transactionPagseguro->getSender()->getPhone()->getNumber()) ?></td>
		<th>Email Doador</th>
		<td><?php echo htmlspecialchars($transactionPagseguro->getSender()->getEmail()) ?></td>
	</tr>
<?php endif ?>
</table>

<h2>Requisição de Status Manual</h2>

<form action="<?php echo $this->urlWithQs ?>" method="post">
		<table class="generic-form-table">
				<tr>
					<th><label for="numero">Código da Transação:</label></th>
					<td><input type="text" name="transactionCode" id="transactionCode" value="<?php echo htmlspecialchars($transaction->payment_code) ?>" size=39/></td>
					<td>Coloque aqui o código da transação que quer solicitar o status manualmente.</td>
				</tr>				
				<tr>
					<td colspan=3><input type="submit" value="Enviar" /></td>
				</tr>
		</table>
</form>

<?php endif ?>