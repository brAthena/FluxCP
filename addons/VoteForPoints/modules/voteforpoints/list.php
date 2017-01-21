<?php 
include ('function.php');
/*
FluxCP Vote For Points
Developed By: JayPee Mateo
Email: mandark022@yahoo.com
*/

//A login is required
$this->loginRequired();

//This will list the sites
$vp = Flux::config('FluxTables.Sites'); 
$serverLogDB = $server->loginDatabase;

$vp_voter = Flux::config('FluxTables.Voters'); 
$vp_logs = Flux::config('FluxTables.Logs'); 		
$serverObj = $server->connection;


$sql = "SELECT site_id,site_name,address,points,blocking_time,banner,banner_url FROM {$server->loginDatabase}.$vp";
$sth = $server->connection->getStatement($sql);
$sth->execute();

$vp = $sth->fetchAll();

?>