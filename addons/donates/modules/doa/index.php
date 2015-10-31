<?php if (!defined('FLUX_ROOT')) exit;

$this->loginRequired(Flux::message('LoginToDonate'));
$title = 'Fazer Uma Doação';
$donationAmount = false;

if (count($_POST) && $params->get('setamount')) {
	$minimum = Flux::config('PagSeguroMin');
	$amount  = (float)$params->get('amount');
	
	if (!$amount || $amount < $minimum) {
		$errorMessage = sprintf('A quantidade de doação deve ser maior ou igual a %s R$!',
			$this->formatCurrency($minimum));
	}
	else {		
		$donationAmount = $amount;
	}
}

if (!$params->get('setamount') && $params->get('resetamount')) {
	$this->redirect($this->url);
}
?>