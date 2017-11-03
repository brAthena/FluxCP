<?php
if (!defined('FLUX_ROOT')) exit;

$title = Flux::message('PickLogTitle');

$sql = "SELECT COUNT(ItemID) AS total FROM {$server->logsDatabase}.pickdrop_log";
$sth = $server->connection->getStatementForLogs($sql);
$sth->execute();

$paginator = $this->getPaginator($sth->fetch()->total);
$paginator->setSortableColumns(array(
	'Date' => 'CharID', 'Name', 'Action', 'Source', 'ItemID', 'ItemName', 'Amount', 'Subject',
	'ItemRefiningLevel', 'ItemSerial', 'ItemSlot1', 'ItemSlot2', 'ItemSlot3', 'ItemSlot4', 'Mapname'
));

$col = "Date, CharID, Name, Action, Source, ItemID, ItemName, Amount, Subject, ItemRefiningLevel, ItemSerial, ItemSlot1, ItemSlot2, ItemSlot3, ItemSlot4, Mapname";
$sql = $paginator->getSQL("SELECT $col FROM {$server->logsDatabase}.pickdrop_log");
$sth = $server->connection->getStatementForLogs($sql);
$sth->execute();

$picks = $sth->fetchAll();

if ($picks) {
	$charIDs   = array();
	$itemIDs   = array();
	$mobIDs    = array();
	$pickTypes = Flux::config('PickTypes');
	
	if ($charIDs) {
		$ids = array_keys($charIDs);
		$sql = "SELECT char_id, name FROM {$server->charMapDatabase}.`char` WHERE char_id IN (".implode(',', array_fill(0, count($ids), '?')).")";
		$sth = $server->connection->getStatement($sql);
		$sth->execute($ids);

		$ids = $sth->fetchAll();

		// Map char_id to name.
		foreach ($ids as $id) {
			$charIDs[$id->char_id] = $id->name;
		}
	}
	
	require_once 'Flux/TemporaryTable.php';
	
	if ($mobIDs) {
		$mobDB      = "{$server->charMapDatabase}.monsters";
		$fromTables = array("{$server->charMapDatabase}.mob_db", "{$server->charMapDatabase}.mob_db2");
		$tempMobs   = new Flux_TemporaryTable($server->connection, $mobDB, $fromTables);

		$ids = array_keys($mobIDs);
		$sql = "SELECT ID, iName FROM {$server->charMapDatabase}.monsters WHERE ID IN (".implode(',', array_fill(0, count($ids), '?')).")";
		$sth = $server->connection->getStatement($sql);
		$sth->execute($ids);

		$ids = $sth->fetchAll();

		// Map id to name.
		foreach ($ids as $id) {
			$mobIDs[$id->ID] = $id->iName;
		}
	}

	if ($itemIDs) {
		$fromTables = array("{$server->charMapDatabase}.item_db", "{$server->charMapDatabase}.item_db2");
		$tableName = "{$server->charMapDatabase}.items";
		$tempTable = new Flux_TemporaryTable($server->connection, $tableName, $fromTables);
		$shopTable = Flux::config('FluxTables.ItemShopTable');

		$ids = array_keys($itemIDs);
		$sql = "SELECT id, name_japanese FROM {$server->charMapDatabase}.items WHERE id IN (".implode(',', array_fill(0, count($ids), '?')).")";
		$sth = $server->connection->getStatement($sql);
		$sth->execute($ids);

		$ids = $sth->fetchAll();

		// Map ItemID to name.
		foreach ($ids as $id) {
			$itemIDs[$id->id] = $id->name_japanese;
		}
	}
}

?>
