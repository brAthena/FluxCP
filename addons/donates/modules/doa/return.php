<?php if (!defined('FLUX_ROOT')) exit; 
$this->loginRequired();
$title = 'Retorno da Transação';

require_once Flux::config('PagSeguroLib');
$donateTable = Flux::config('FluxTables.DonateTable');
$tableBan    = Flux::config('FluxTables.AccountBanTable');
$donatePromo = Flux::config('Promotion');
$initPromo   = Flux::config('InitPromo');
$donateVar   = Flux::config('PagSeguroVar');
$donateFlux  = Flux::config('PagSeguroFlux');
$rate        = Flux::config('rate');
$hercules    = Flux::config('hercules');

if (count($_GET) && isset($_GET['transaction_id'])) {
			
	$transactionCode = str_replace(' ', '',strtoupper($_GET['transaction_id']));
		
	if(!preg_match('/^[A-Z 0-9]{8}[-]?[A-Z 0-9]{4}[-]?[A-Z 0-9]{4}[-]?[A-Z 0-9]{4}[-]?[A-Z 0-9]{12}$/',$transactionCode)) {
		$errorMessage = sprintf('Formato do código de transação incorreto! O formato deve ser: XXXXXXXX-XXXX-XXXX-XXXX-XXXXXXXXXXXX.');
	} else {	
		
		$transactionCredencial = new PagSeguroAccountCredentials(Flux::config('EmailPagSeguro'), Flux::config('TokenPagseguro'));
		$transactionPagseguro  = PagSeguroTransactionSearchService::searchByCode($transactionCredencial, $transactionCode);
			
		$donateStatus = $transactionPagseguro->getStatus()->getValue();
		$donateRef    = $transactionPagseguro->getReference();
		
		$sql  = "SELECT * FROM {$server->loginDatabase}.$donateTable WHERE payment_id = ?";
		$sth = $server->connection->getStatement($sql);
		$sth->execute(array($donateRef));
		$donate     = $sth->fetch();
		$account    = $donate->account_id;
		$donateVal  = $donate->payment;
		$status     = $donate->payment_status_pagseguro;
		
		if ($donateStatus != $status){
			switch ($donateStatus){
				case 1:
					$sql  = "UPDATE {$server->loginDatabase}.$donateTable ";
					$sql .= "SET payment_code = ?, payment_status_pagseguro = ?, payment_status = ? ";
					$sql .= "WHERE payment_id = ?";
					$sth  = $server->connection->getStatement($sql);
					$sth->execute(array($transactionCode, $donateStatus, 1, $donateRef));
				break;
				
				case 2:
					$sql  = "UPDATE {$server->loginDatabase}.$donateTable ";
					$sql .= "SET payment_code = ?, payment_status_pagseguro = ?, payment_status = ? ";
					$sql .= "WHERE payment_id = ?";
					$sth  = $server->connection->getStatement($sql);
					$sth->execute(array($transactionCode, $donateStatus, 1, $donateRef));
				break;
				
				case 3:
					$credits = floor(($donateVal >= $initPromo ? ($donateVal + ($donatePromo*$donateVal)/100) : $donateVal) / $rate);
				
					if ($donateFlux){
						$server->loginServer->depositCredits($account, $credits, $donateVal);
					} 
					elseif ($hercules){
						$sql  = "INSERT INTO {$this->charMapDatabase}.`acc_reg_num_db` (`account_id`, `key`, `index`, `value`) ";
						$sql .= "VALUES (?,?,0,?) ON DUPLICATE KEY UPDATE value = value + ?";
						$sth  = $server->connection->getStatement($sql);
						$sth->execute(array($account, $donateVar, $credits, $credits));
					}
					else{
						$sql  = "INSERT INTO {$server->charMapDatabase}.`global_reg_value` (`char_id`, `str`, `value`, `type`, `account_id`) ";
						$sql .= "VALUES (?, ?, ?, ?, ?) ON DUPLICATE KEY UPDATE value = value + ?";
						$sth  = $server->connection->getStatement($sql);
						$sth->execute(array(0, $donateVar, $credits, 2, $account, $credits));
					}
		
					$sql  = "UPDATE {$server->loginDatabase}.$donateTable ";
					$sql .= "SET payment_code = ?, payment_status_pagseguro = ?, payment_status = ? ";
					$sql .= "WHERE payment_id = ?";
					$sth  = $server->connection->getStatement($sql);
					$sth->execute(array($transactionCode, $donateStatus, 2, $donateRef));
				break;
		
				case 4:
					$sql  = "UPDATE {$server->loginDatabase}.$donateTable ";
					$sql .= "SET payment_code = ?, payment_status_pagseguro = ?, payment_status = ? ";
					$sql .= "WHERE payment_id = ?";
					$sth  = $server->connection->getStatement($sql);
					$sth->execute(array($transactionCode, $donateStatus, 2, $donateRef));
				break;
			
				case 5:
					$sql  = "INSERT INTO {$server->loginDatabase}.$tableBan (account_id, banned_by, ban_type, ban_until, ban_date, ban_reason) ";
					$sql .= "VALUES (?, ?, 2, '0000-00-00 00:00:00', NOW(), ?)";
					$sth  = $server->connection->getStatement($sql);
					$sth->execute(array($account, 'PagSeguro', 'Tentativa de fraude ao sistema do PagSeguro: O doador abriu uma disputa após recebimento dos créditos e está banido.'));
				
					$sql  = "UPDATE {$server->loginDatabase}.login SET state = 5, unban_time = 0 WHERE account_id = ?";
					$sth  = $server->connection->getStatement($sql);
					$sth->execute(array($account));
				
					$sql  = "UPDATE {$server->loginDatabase}.$donateTable ";
					$sql .= "SET payment_code = ?, payment_status_pagseguro = ?, payment_status = ? ";
					$sql .= "WHERE payment_id = ?";
					$sth  = $server->connection->getStatement($sql);
					$sth->execute(array($transactionCode, $donateStatus, 3, $donateRef));
				break;

				case 6:
					$sql  = "INSERT INTO {$server->loginDatabase}.$tableBan (account_id, banned_by, ban_type, ban_until, ban_date, ban_reason) ";
					$sql .= "VALUES (?, ?, 2, '0000-00-00 00:00:00', NOW(), ?)";
					$sth  = $server->connection->getStatement($sql);
					$sth->execute(array($account, 'PagSeguro', 'Tentativa de fraude ao sistema do PagSeguro: O doador recebeu novamente seu dinheiro e está banido.'));
				
					$sql  = "UPDATE {$server->loginDatabase}.login SET state = 5, unban_time = 0 WHERE account_id = ?";
					$sth  = $server->connection->getStatement($sql);
					$sth->execute(array($account));
				
					$sql  = "UPDATE {$server->loginDatabase}.$donateTable ";
					$sql .= "SET payment_code = ?, payment_status_pagseguro = ?, payment_status = ? ";
					$sql .= "WHERE payment_id = ?";
					$sth  = $server->connection->getStatement($sql);
					$sth->execute(array($transactionCode, $donateStatus, 3, $donateRef));
				break;
			
				case 7:
					$sql  = "UPDATE {$server->loginDatabase}.$donateTable ";
					$sql .= "SET payment_code = ?, payment_status_pagseguro = ?, payment_status = ? ";
					$sql .= "WHERE payment_id = ?";
					$sth  = $server->connection->getStatement($sql);
					$sth->execute(array($transactionCode, $donateStatus, 3, $donateRef));
				break;
			}
		}
	}
}
?>