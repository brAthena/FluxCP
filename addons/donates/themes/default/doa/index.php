<?php if (!defined('FLUX_ROOT')) exit; ?>
<h2>Doação PagSeguro</h2>
<?php if (!Flux::config('PagSeguroLock') || $session->account->group_id > 20): ?>
	<?php if (!empty($errorMessage)): ?>
		<p class="red"><?php echo htmlspecialchars($errorMessage) ?></p>
	<?php endif ?>
	
	<p>Ao fazer uma doação, você está ajudando nos custos de <em>execução</em> desde servidor e na <em>manutenção</em> do mesmo. Em troca, você é recompensado com <span class="keyword"><?php echo Flux::config('PagSeguroCoin') ?></span> que você pode utilizar para comprar itens
	<?php echo (Flux::config('PagSeguroFlux') ? 'da nossa <a href="'. $this->url('purchase').'">loja</a> de' : 'em nosso NPC de') ?> <?php echo Flux::config('PagSeguroCoin') ?> .</p>
	<?php if (Flux::config('Promotion')):?>
		<h3><span class="keyword"> Aproveite estamos com uma promoção onde <?php echo ((Flux::config('InitPromo') > 0) ? 'a partir de '.$this->formatCurrency(Flux::config('InitPromo')).' R$ ' : ' ').'você recebe mais '. Flux::config('Promotion').'% de créditos nas doações.' ?></span></h3>
	<?php endif ?>
	<h3>Você está pronto para doar?</h3>
	<p>Aqui as doações são recebidas através do PagSeguro, onde você pode pagar de diversas maneiras.</p>
		
	<?php
	$donateAmount     = (float)+Flux::config('rate');
	$creditAmount     = 1;
	$rateMultiplier   = 10;
	
	while ($donateAmount < 1) {
		$donateAmount  *= $rateMultiplier;
		$creditAmount  *= $rateMultiplier;
	}
	?>

	<div class="generic-form-div" style="margin-bottom: 10px">
		<table class="generic-form-table">
			<tr>
				<th><label>Taxa de Câmbio:</label></th>
				<td><p><?php echo $this->formatCurrency($donateAmount) ?> R$
				= <?php echo number_format($creditAmount) ?> <?php echo Flux::config('PagSeguroCoin') ?>.</p></td>
			</tr>
			<tr>
				<th><label>Quantidade Mínima de Doação:</label></th>
				<td><p><?php echo $this->formatCurrency(Flux::config('PagSeguroMin')) ?> R$</p></td>
			</tr>
		</table>
	</div>
		
	<?php if (!$donationAmount): ?>
	<form action="<?php echo $this->url ?>" method="post">
		<?php echo $this->moduleActionFormInputs($params->get('module')) ?>
		<input type="hidden" name="setamount" value="1" />
		<p class="enter-donation-amount">
			<label>
				Digite a quantidade que você quer doar:
				<input class="money-input" type="text" name="amount"
					value="<?php echo htmlspecialchars($params->get('amount')) ?>"
					size="<?php echo (strlen((string)+Flux::config('rate')) * 2) + 2 ?>" /> R$
			</label>
			ou
			<label>
				<input class="credit-input" type="text" name="credit-amount"
					value="<?php echo htmlspecialchars(intval($params->get('amount') / Flux::config('rate'))) ?>"
					size="<?php echo (strlen((string)+Flux::config('rate')) * 2) + 2 ?>" />
				<?php echo Flux::config('PagSeguroCoin') ?>
			</label>
		</p>
		<input type="submit" value="Confirmar Doação" class="submit_button" />
	</form>
	<?php else: ?>
	<p>Quando você estiver pronto para doar, clique no botão “Doar com PagSeguro” para proceder com a sua transação.</p>
		
	<p class="credit-amount-text">
		&mdash;
		<span class="credit-amount"><?php echo number_format(floor($donationAmount / Flux::config('rate'))) ?></span> 
		<?php echo Flux::config('PagSeguroCoin') ?>
		&mdash;
	</p>
		
	<p class="donation-amount-text">Quantidade:
		<span class="donation-amount">
		<?php echo $this->formatCurrency($donationAmount) ?>
		R$
		</span>
	</p>
	<p class="reset-amount-text">
		<a href="<?php echo $this->url('doa', 'index', array('resetamount' => true)) ?>">(Resetar Quantidade)</a>
	</p>
	<p><?php echo $this->pagSeguroButton($donationAmount) ?></p>
	<?php endif ?>
<?php else: ?>
	<p><?php echo Flux::message('NotAcceptingDonations') ?></p>
<?php endif ?>