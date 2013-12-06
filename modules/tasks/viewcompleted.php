<?php
/* Tasklist Addon
 * Created and maintained by Akkarin
 * Current Version: 1.00.04
 */
 
if (!defined('FLUX_ROOT')) exit;
$this->loginRequired();


$tblsettings = Flux::config('FluxTables.TaskListStaffTable'); 

$sth = $server->connection->getStatement("SELECT * FROM {$server->loginDatabase}.$tblsettings WHERE account_id = ?");
$sth->execute(array($session->account->account_id));
$staff = $sth->fetchAll();
if(!$staff){
	$session->setMessageData('!!!Erro!!! Conta não existe na tabela de configurações de equipe! Por favor, envie seu nome antes de utilizar a lista de tarefas.'); $this->redirect($this->url('xtasklist','staffsettings'));
} else {
	foreach($staff as $staffsess){}
}


$tbl = Flux::config('FluxTables.TaskListTable'); 
$sql = "SELECT * FROM {$server->loginDatabase}.$tbl WHERE status = 5 ORDER BY id";
$task = $server->connection->getStatement($sql);
$task->execute();
$tasklist = $task->fetchAll();
?>