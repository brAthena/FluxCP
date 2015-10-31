<?php
if (!defined('FLUX_ROOT')) exit;

$this->loginRequired();
$title = 'Estatísticas do PagSeguro';

if($_SERVER['REQUEST_METHOD'] == 'POST'){
	if (count($_POST) && isset($_POST['dateMin']) && isset($_POST['dateMax'])){
	
		$dateMin = $_POST['dateMin'];
		$dateMax = $_POST['dateMax'];
		
		if (!preg_match('/^(\d{4}(-\d{2}){2})(T| )((([0-1]?[0-9])|([2][0-3])):)?(([0-5][0-9]))$/',$dateMin)){
			$errorMessage = sprintf('Formato incorreto: YYYY-MM-DD HH:MM');
		}else if (!preg_match('/^(\d{4}(-\d{2}){2})(T| )((([0-1]?[0-9])|([2][0-3])):)?(([0-5][0-9]))$/',$dateMax)){
			$errorMessage = sprintf('Formato incorreto: YYYY-MM-DD HH:MM');
		}
		
		$donateTable = Flux::config('FluxTables.DonateTable');

		$sql  = "SELECT COUNT(id) AS total ";
		$sql .= "FROM {$server->loginDatabase}.$donateTable WHERE payment_date >= ? AND payment_date <= ? ";
		$sth  = $server->connection->getStatement($sql);
		$sth->execute(array($dateMin, $dateMax));
		$transactionsTotal = $sth->fetch();
		
		$sql  = "SELECT COUNT(id) AS total ";
		$sql .= "FROM {$server->loginDatabase}.$donateTable WHERE payment_date >= ? AND payment_date <= ? AND payment_status = ?";
		$sth  = $server->connection->getStatement($sql);
		$sth->execute(array($dateMin, $dateMax, 0));
		$transactionsFail = $sth->fetch();
		
		$sql  = "SELECT COUNT(id) AS total ";
		$sql .= "FROM {$server->loginDatabase}.$donateTable WHERE payment_date >= ? AND payment_date <= ? AND payment_status = ?";
		$sth  = $server->connection->getStatement($sql);
		$sth->execute(array($dateMin, $dateMax, 1));
		$transactionsWaiting = $sth->fetch();
		
		$sql  = "SELECT COUNT(id) AS total ";
		$sql .= "FROM {$server->loginDatabase}.$donateTable WHERE payment_date >= ? AND payment_date <= ? AND payment_status = ?";
		$sth  = $server->connection->getStatement($sql);
		$sth->execute(array($dateMin, $dateMax, 2));
		$transactionsApproved = $sth->fetch();
		
		$sql  = "SELECT COUNT(id) AS total ";
		$sql .= "FROM {$server->loginDatabase}.$donateTable WHERE payment_date >= ? AND payment_date <= ? AND payment_status = ?";
		$sth  = $server->connection->getStatement($sql);
		$sth->execute(array($dateMin, $dateMax, 3));
		$transactionsDisapproved = $sth->fetch();
		
		$sql  = "SELECT SUM(payment) AS total ";
		$sql .= "FROM {$server->loginDatabase}.$donateTable WHERE payment_date >= ? AND payment_date <= ? AND payment_status = ?";
		$sth  = $server->connection->getStatement($sql);
		$sth->execute(array($dateMin, $dateMax, 2));
		$transactionValue = $sth->fetch();
		
		$sql  = "SELECT SUM(payment) AS total ";
		$sql .= "FROM {$server->loginDatabase}.$donateTable WHERE payment_date >= ? AND payment_date <= ?";
		$sth  = $server->connection->getStatement($sql);
		$sth->execute(array($dateMin, $dateMax));
		$transactionValueFail = $sth->fetch();
		
	}
}
?>