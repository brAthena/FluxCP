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
$vp_site = Flux::config('FluxTables.Sites'); 
$error = array();
$site_id = $params->get('sid');

if(preg_match("/^[0-9]{1,}$/",$site_id))
{
	$sql = "SELECT site_name,address,points,blocking_time,banner,banner_url,banner_file_type FROM {$server->loginDatabase}.{$vp_site} WHERE site_id=?";
	$sth = $server->connection->getStatement($sql);
	$sth->execute(array($site_id));
	$vp = $sth->fetch();

	if(empty($vp))
		$error[count($error)] = Flux::message("VOTING_SITE_NOT_FOUND");
	else
	{
	
	$b_time = strBlockTime($vp->blocking_time);
	$blocking_time = explode(":",$b_time);
	if($blocking_time[0] == "00")
		$hours = 24;
	else
		$hours = $blocking_time[0];

	$minutes = $blocking_time[1];
	}

	$edit = $params->get('Edit');
	//Allowed File Types
	$types = array(
		'image/gif',
		'image/jpeg',
		'image/jpg',
		'image/png',
		'image/x-png',
	);
		
	$file_types = "";
	foreach($types as $type)
	{
		$file_types .= str_replace("image/",".",$type)." | ";
	}

	if(!empty($edit))
	{
		$site_name 	= $params->get('site_name');
		if(empty($site_name))
			$error[count($error)]  = Flux::message("SITE_NAME_ERROR");
		$address 	= $params->get('site_address');
		if(empty($address))
			$error[count($error)] = Flux::message("URL/ADDRESS_ERROR");
		$points 	= $params->get('points');
		if(empty($points))
			$error[count($error)] = Flux::message("POINTS_ERROR");
			
		$use_banner_url = $params->get('cbox_banner_url');
		$block_time = (($params->get('blocking_hours')*60*60)+($params->get('blocking_minutes')*60));
		
		if(!empty($use_banner_url))
		{	
			$banner = "";
			$banner_url = $params->get('banner_url');
			$banner_file_type = "";		
			$sql = "UPDATE {$server->loginDatabase}.{$vp_site} SET site_name=?, address=?, points=?, blocking_time=?, banner=?, banner_url=?, banner_file_type=?";

			//Error Checking
			if(empty($banner_url))
				$error[count($error)] = Flux::message("BANNER_URL_ERROR");		
		}
		else
		{
		

			$banner_file = $files->get('banner_upload');
			$tmp_name = $banner_file->get('tmp_name');
			if(empty($tmp_name))
			{
				$banner = $vp->banner;
				$banner_file_type = $vp->banner_file_type;
			}
			else
			{
				$banner = file_get_contents($banner_file->get('tmp_name'));
				$banner_file_type = $banner_file->get('type');
			}

			$banner_url = null;

			$sql = "UPDATE {$server->loginDatabase}.{$vp_site} SET site_name=?, address=?, points=?, blocking_time=?, banner=?, banner_url=?, banner_file_type=?";

			if(!empty($tmp_name))
			{
				//Error Checking	
				if($banner_file->get('size')<=0)
					$error[count($error)] = Flux::message("BANNER_FILE_SIZE_ERROR");
				if(($banner_file->get('size')/1024)>Flux::config('MAX_FILE_SIZE'))
					$error[count($error)] = Flux::message("BANNER_MAX_FILE_SIZE_ERROR")."".Flux::config('MAX_FILE_SIZE')." kb";
				if(!in_array($banner_file_type,$types))
					$error[count($error)] = Flux::message("BANNER_FILE_TYPE_ERROR")." ".$file_types;
			}
		}
		$sql .= " WHERE site_id=?";
		
		if(count($error)==0)
		{
			$sth = $server->connection->getStatement($sql);
			$sth->execute(array($site_name,$address,$points,$block_time,$banner,$banner_url,$banner_file_type,$site_id));
			$this->redirect("index.php?module=voteforpoints&action=list");
		}	
	}
}
else
	$error[count($error)] = Flux::message("INVALID_VOTING_SITE");
?>