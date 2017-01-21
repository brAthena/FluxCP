<?php if (!defined('FLUX_ROOT')) exit; 
include ('function.php');
/*
FluxCP Vote For Points
Developed By: JayPee Mateo
Email: mandark022@yahoo.com
*/

//This will list the sites
$this->loginRequired();
$vp = Flux::config('FluxTables.Sites'); 
$vp_logs = Flux::config('FluxTables.Logs'); 

$site_id = (int)$params->get('sid');

if(preg_match("/^[0-9]{1,}$/",$site_id))
{
	$delete = trim($params->get('Delete'));
	if(!empty($delete))
	{
	//Delete site
		$sql = "DELETE FROM {$server->loginDatabase}.{$vp} WHERE site_id=?";
		$sth = $server->connection->getStatement($sql);
		$sth->execute(array($site_id));

	//We need to delete database that connected to the site
		$sql = "DELETE FROM {$server->loginDatabase}.{$vp_logs} WHERE f_site_id=?";
		$sth = $server->connection->getStatement($sql);
		$sth->execute(array($site_id));
		$this->redirect($this->url('voteforpoints','list'));
		
	}

	$sql = "SELECT site_name,site_id,address,points,blocking_time,banner,banner_url FROM {$server->loginDatabase}.$vp WHERE site_id=?";
	$sth = $server->connection->getStatement($sql);
	$sth->execute(array($params->get('sid')));
	$vpdel = $sth->fetch();

	if(!empty($vpdel))
	{
	$b_time = strBlockTime($vpdel->blocking_time);
	$blocking_time = explode(":",$b_time);
	if($blocking_time[0] == "00")
		$hours = 24;
	else
		$hours = $blocking_time[0];

	$minutes = $blocking_time[1];
	}
}
?>