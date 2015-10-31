<?php 

function strBlockTime($blocktime)
{
	$getHour = (int)($blocktime/3600);
	$getMinute = $blocktime-($getHour*3600);
	$getMinute = ($getMinute/60);
	if($getHour<10)
		$getHour = "0".$getHour;
		
	if($getMinute<10)
		$getMinute = "0".$getMinute;
		
	$block_time = $getHour.":".$getMinute.":00";
	return $block_time;
}


?>