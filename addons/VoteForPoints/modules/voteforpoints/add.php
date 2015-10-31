<?php if (!defined('FLUX_ROOT')) exit; 
/*
FluxCP Vote For Points
Developed By: JayPee Mateo
Email: mandark022@yahoo.com
*/


$this->loginRequired();

//Allowed File Types
$types = array(
	'image/gif',
	'image/jpeg',
	'image/jpg',
	'image/png',
	'image/x-png',
);

$add = $params->get('Add');
$error = array();

$file_types = "";
foreach($types as $type)
{
	$file_types .= str_replace("image/",".",$type)." | ";
}
if(!empty($add))
{

	$vp_site	= Flux::config('FluxTables.Sites'); 
	$site_name 	= $params->get('site_name');
	if(empty($site_name))
		$error[count($error)]  = Flux::message("SITE_NAME_ERROR");
	$address 	= $params->get('site_address');
	if(empty($address))
		$error[count($error)] = Flux::message("URL/ADDRESS_ERROR");
	$points 	= $params->get('points');
	if(empty($points))
		$error[count($error)] = Flux::message("POINTS_ERROR");
	if(!preg_match("/^[0-9]{1,}$/",$points))
		$error[count($error)] = Flux::message("POINTS_MUST_BE_NUMBER");
		
	
	$block_time = (($params->get('blocking_hours')*60*60)+($params->get('blocking_minutes')*60));
	$use_banner_url = $params->get('cbox_banner_url');
if(empty($use_banner_url))
{
	$banner_file = $files->get('banner_upload');
	$banner = file_get_contents($banner_file->get('tmp_name'));
	$banner_file_type = $banner_file->get('type');
	$sql = "INSERT INTO {$server->loginDatabase}.{$vp_site}(site_name,address,points,blocking_time,banner,banner_file_type)";
	
	//Error Checking	
	if($banner_file->get('size')<=0)
		$error[count($error)] = Flux::message("BANNER_FILE_SIZE_ERROR");
	if(($banner_file->get('size')/1024)>Flux::config('MAX_FILE_SIZE'))
		$error[count($error)] = Flux::message("BANNER_MAX_FILE_SIZE_ERROR").Flux::config('MAX_FILE_SIZE')." kb";		
	if(!in_array($banner_file->get('type'),$types))
		$error[count($error)] = Flux::message("BANNER_FILE_TYPE_ERROR");
}
else
{
	$banner = $params->get('banner_url');
	$banner_file_type = "";
	$sql = "INSERT INTO {$server->loginDatabase}.{$vp_site}(site_name,address,points,blocking_time,banner_url,banner_file_type)";	
	
	//Error Checking
	if(empty($banner))
		$error[count($error)] = Flux::message("BANNER_URL_ERROR");
}

if(count($error)==0)
{
	$sql .= "  VALUES(?,?,?,?,?,?)";
	$sth = $server->connection->getStatement($sql);
	$sth->execute(array($site_name,$address,$points,$block_time,$banner,$banner_file_type));
	$this->redirect("index.php?module=voteforpoints&action=list");
}

}
?>