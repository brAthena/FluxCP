<?php 

/*
FluxCP Vote For Points
Developed By: JayPee Mateo
Email: mandark022@yahoo.com
*/

//A login is required
$this->loginRequired();
$site_id = $params->get('sid');
if(preg_match("/^[0-9]{1,}$/",$site_id))
{

	//Somewhat Prevent of using Proxy Servers
	$xcf = $_SERVER["HTTP_CF_CONNECTING_IP"];
	$xforward= $_SERVER["HTTP_X_FORWARDED_FOR"];
	if (empty($xcf) && !empty($xforward)) {
		$error = Flux::message('PROXY_NOT_ALLOWED');
	}
	else
	{
	//User Account_ID and IP Address
	$account_id = $session->account->account_id;
	$ip_address = 0;
	if(Flux::config('IP_BLOCKING'))
		$ip_address = $_SERVER['REMOTE_ADDR'];
		
	$current_time= date("Y-m-d G:i:s",time());

	//This will list the sites
	$vp_site = Flux::config('FluxTables.Sites'); 
	$vp_voter = Flux::config('FluxTables.Voters'); 
	$vp_logs = Flux::config('FluxTables.Logs'); 


	$check = null;
	if($ip_address!=0)
	{
		/*
			IP BLOCKING SYSTEM IS ON/ENABLED
			This will check if the IP is unblocked for the specified site
		*/
		$sql = "SELECT `rtid`,`unblock_time`,`ip_address` FROM {$server->loginDatabase}.{$vp_logs} WHERE f_site_id=? AND unblock_time>? AND ip_address=? ORDER BY unblock_time ASC";
		$sth = $server->connection->getStatement($sql);
		$sth->execute(array($site_id,$current_time,$ip_address));
		$check = $sth->fetchAll();
	}
		
	if(empty($check))
	{
		$sql = "SELECT `address`,`points`,`blocking_time` FROM {$server->loginDatabase}.{$vp_site} WHERE site_id=? LIMIT 1";
		$sth = $server->connection->getStatement($sql);
		$sth->execute(array($site_id));
		$vp_site = $sth->fetch();
			
	//Incase the user tamper the siteid
	if(!empty($vp_site))
	{
		//Site Information
		$address 		= $vp_site->address;
		$blocking_time 	= $vp_site->blocking_time;
		$points 		= $vp_site->points;


		//Calculate the Unblocking Time
		$unblock_time = date("Y-m-d G:i:s",time()+$blocking_time);

		//Check if the User has an existing voter's Record

		//In Vote Logs

			$sql = "SELECT `rtid`,`ip_address`,`unblock_time` FROM {$server->loginDatabase}.{$vp_logs} WHERE account_id=? AND f_site_id=? ";
			$sth = $server->connection->getStatement($sql);
			$sth->execute(array($account_id,$site_id));
			$check = $sth->fetch();
			
		if(!empty($check))
			$diff_time = strtotime($check->unblock_time)-strtotime(date("Y-m-d G:i:s",time()));
		else
			$diff_time = 0;
		
		if($diff_time<=0)
		{
			//Can Vote
			if(empty($check)){
				//If Not Voters Record For the specific site make an Insertion
				$sql = "INSERT INTO {$server->loginDatabase}.{$vp_logs} (f_site_id,unblock_time,account_id,ip_address) VALUES(?,?,?,?)";
				$sth = $server->connection->getStatement($sql);
				$sth->execute(array($site_id,$unblock_time,$account_id,$ip_address));
			}
			else{
				//If the voter has an existing log
					$sql = "UPDATE {$server->loginDatabase}.{$vp_logs} SET unblock_time=?, ip_address=? WHERE rtid=?";
					$sth = $server->connection->getStatement($sql);
					$sth->execute(array($unblock_time,$ip_address,$check->rtid));	
			}

			//In Voters Records
			$sql = "SELECT `account_id`,`points` FROM {$server->loginDatabase}.{$vp_voter} WHERE account_id=?";
			$sth = $server->connection->getStatement($sql);
			$sth->execute(array($account_id));
			$check = $sth->fetch();

			if(empty($check)){
				//If Not Voters Record For the specific site make an Insertion
				$sql = "INSERT INTO {$server->loginDatabase}.{$vp_voter}(account_id,points) VALUES(?,?)";
				$sth = $server->connection->getStatement($sql);
				$sth->execute(array($account_id,$points));
			}
			else{
				//If the voter is has an existing record
					$sql = "UPDATE {$server->loginDatabase}.{$vp_voter} SET points=? WHERE account_id=?";
					$sth = $server->connection->getStatement($sql);
					$points = $vp_site->points+$check->points;
					$sth->execute(array($points,$account_id));
			}
			$address = str_replace("http://","",$address);
			$address = str_replace("www.","",$address);
			$this->redirect("http://www.".$address);
		}
		else
			$error = Flux::message('BLOCK_VOTING_SITE').$check->unblock_time;						
	}
	else
		$error = Flux::message('VOTING_SITE_NOT_FOUND');
	}//--End
	else
		$error = Flux::message('BLOCK_VOTING_SITE').$check[0]->unblock_time;						
	}
}
else
	$error = Flux::message('INVALID_VOTING_SITE');

?>
