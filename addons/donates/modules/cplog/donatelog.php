<?php
if (!defined('FLUX_ROOT')) exit;

$this->loginRequired();
$title = 'Transações do PagSeguro';
$donateTable = Flux::config('FluxTables.DonateTable');

$donateId      = (int)$params->get('id');
$donateCode    = trim($params->get('payment_code'));
$donateRef     = trim($params->get('payment_id'));
$donateAcc     = (int)$params->get('account_id');
$donateUser    = trim($params->get('userid'));
$donateIp      = trim($params->get('payment_ip'));
$donateDateMin = $params->get('dateMin');
$donateDateMax = $params->get('dateMax');
$donateVal     = str_replace(',','.',$params->get('payment'));
$donateEmail   = $params->get('email');
$donateStatus  = $params->get('payment_status');
$status = Flux::config('PaymentStatus')->toArray();

$sqlpartial    = "WHERE 1=1 ";
$bind          = array();

if ($donateId) {
	$sqlpartial .= 'AND id = ? ';
	$bind[]      = $donateId;
}

if ($donateCode) {
	$sqlpartial .= 'AND payment_code = ? ';
	$bind[]      = $donateCode;
}

if ($donateRef) {
	$sqlpartial .= 'AND payment_id = ? ';
	$bind[]      = $donateRef;
}

if ($donateAcc) {
	$sqlpartial .= 'AND account_id = ? ';
	$bind[]      = $donateAcc;
}

if ($donateUser) {
	$sqlpartial .= 'AND userid LIKE ? ';
	$bind[]      = "%$donateUser%";
}

if ($donateIp) {
	$sqlpartial .= 'AND payment_ip LIKE ? ';
	$bind[]      = "%$donateIp%";
}

if ($donateVal) {
	$sqlpartial .= 'AND payment = ? ';
	$bind[]      = $donateVal;
}

if ($donateEmail) {
	$sqlpartial .= 'AND email = ? ';
	$bind[]      = $donateEmail;
}

if ($donateDateMin && $donateDateMax) {
	$sqlpartial .= 'AND payment_date >= ? AND payment_date <= ? ';
	$bind[]      = $donateDateMin;
	$bind[]      = $donateDateMax;
}

if ($donateStatus) {
	$sqlpartial .= 'AND payment_status = ? ';
	$bind[]      =  array_search($donateStatus ,$status);
}

$sql = "SELECT COUNT(id) AS total FROM {$server->loginDatabase}.$donateTable $sqlpartial";
$sth = $server->connection->getStatement($sql);
$sth->execute($bind);

$paginator = $this->getPaginator($sth->fetch()->total);
$paginator->setSortableColumns(array(
	'id',
	'account_id',
	'payment_id',
	'payment_date' => 'desc',
	'payment_status',
	'payment'
));

$sql = "SELECT id, account_id, payment_id, userid, payment_ip, payment_date, payment, email, payment_status FROM {$server->loginDatabase}.$donateTable $sqlpartial";
$sql = $paginator->getSQL($sql);
$sth = $server->connection->getStatement($sql);
$sth->execute($bind);

$transactions = $sth->fetchAll();
?>