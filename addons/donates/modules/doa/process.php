<?php if (!defined('FLUX_ROOT')) exit;

$this->loginRequired(Flux::message('LoginToDonate'));
require_once Flux::config('PagSeguroLib');
$title = 'Processamento de Doações';
$donateTable = Flux::config('FluxTables.DonateTable');
$rate        = Flux::config('rate');
$donatePromo = Flux::config('Promotion');
$initPromo   = Flux::config('InitPromo');
$donateFlux  = Flux::config('PagSeguroFlux');
$donateCoin  = Flux::config('PagSeguroCoin');
$donateMin   = Flux::config('PagSeguroMin');


if (count($_POST)) {
	$donateVal   = $params->get('itemAmount1');
	$donateEmail = $session->account->email;
	$donateAcc   = $session->account->account_id;
	$donateInf   = sprintf('%s '.strtoupper($donateCoin)  , number_format(floor(($donateVal >= $initPromo ? ($donateVal + ($donatePromo*$donateVal)/100) : $donateVal) / $rate)));
	$donateIp    = $_SERVER['REMOTE_ADDR'];
	$donateRef   = strtoupper(uniqid(true));
	$donateUser  = $session->account->userid;
	$donateBy    = $params->get('payment_type');
	
	if ($donateBy != 'PagSeguro') {
		$errorMessage = 'Somente PagSeguro';
	}
	else if($donateVal < $donateMin) { 
		$errorMessage = sprintf('O valor da doação deve ser maior ou igual a %s R$!', $this->formatCurrency($donateMin));
	}
	else {
	
		$transactionRequest = new PagSeguroPaymentRequest();
		$transactionRequest->setCurrency("BRL");
		$transactionRequest->addItem('01', $donateInf, '1', str_replace(",","",$this->formatCurrency($donateVal)));
		$transactionRequest->setReference($donateRef);
		$transactionRequest->setNotificationURL($this->url('doa', 'notification', array('_host' => true)));
		$transactionRequest->setRedirectURL($this->url('doa', 'return', array('_host' => true)));
		$transactionCredentials = new PagSeguroAccountCredentials(Flux::config('EmailPagSeguro'), Flux::config('TokenPagseguro'));
		$url = $transactionRequest->register($transactionCredentials);
	
		if ($url){
			$sql  = "INSERT INTO {$session->loginAthenaGroup->loginDatabase}.$donateTable ";
			$sql .= "(account_id, userid, email, payment_id, payment_ip, payment_type, payment, payment_date) ";
			$sql .= "VALUES (?, ?, ?, ?, ?, ?, ?, NOW())";
			$sth  = $session->loginAthenaGroup->connection->getStatement($sql);
			$res  = $sth->execute(array($donateAcc, $donateUser, $donateEmail, $donateRef, $donateIp, $donateBy, $donateVal));
			header('Location:'.$url.'');
			
		}
		else{ 
			$errorMessage = 'Ocorreu um erro, reporte imediatamente a administração!';
		}
	}	
}
?>