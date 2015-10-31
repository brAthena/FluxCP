<?php if (!defined('FLUX_ROOT')) exit;

$this->loginRequired();
$donateTable = Flux::config('FluxTables.DonateTable');
$sqlpartial  = "WHERE account_id = ? AND payment_status = 2 ";
$sqlpartial .= "ORDER BY payment_date DESC LIMIT 0,10";

$sql = "SELECT COUNT(id) AS total FROM {$server->loginDatabase}.$donateTable $sqlpartial";
$sth = $server->connection->getStatement($sql);

$sth->execute(array($session->account->account_id));
$aprovadaTotal = $sth->fetch()->total;

$sql = "SELECT * FROM {$server->loginDatabase}.$donateTable $sqlpartial";
$sth = $server->connection->getStatement($sql);

$sth->execute(array($session->account->account_id));
$aprovadas = $sth->fetchAll();

$sqlpartial  = "WHERE account_id = ? AND payment_status = 1 ";
$sqlpartial .= "ORDER BY payment_date DESC LIMIT 0,10";

$sql = "SELECT COUNT(id) AS total FROM {$server->loginDatabase}.$donateTable $sqlpartial";
$sth = $server->connection->getStatement($sql);

$sth->execute(array($session->account->account_id));
$pendenteTotal = $sth->fetch()->total;

$sql = "SELECT * FROM {$server->loginDatabase}.$donateTable $sqlpartial";
$sth = $server->connection->getStatement($sql);

$sth->execute(array($session->account->account_id));
$pendentes = $sth->fetchAll();

$sqlpartial  = "WHERE account_id = ? AND payment_status = 3 ";
$sqlpartial .= "ORDER BY payment_date DESC LIMIT 0,10";

$sql = "SELECT COUNT(id) AS total FROM {$server->loginDatabase}.$donateTable $sqlpartial";
$sth = $server->connection->getStatement($sql);

$sth->execute(array($session->account->account_id));
$recusadaTotal = $sth->fetch()->total;

$sql = "SELECT * FROM {$server->loginDatabase}.$donateTable $sqlpartial";
$sth = $server->connection->getStatement($sql);

$sth->execute(array($session->account->account_id));
$recusadas = $sth->fetchAll();
?>