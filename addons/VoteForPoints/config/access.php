<?php
/*
FluxCP Vote For Points
Developed By: JayPee Mateo
Email: mandark022@yahoo.com
*/

return array(
	'modules' => array(
		'voteforpoints' => array(
            'index' 	=> AccountLevel::NORMAL,
            'vote' 		=> AccountLevel::NORMAL,
            'image' 	=> AccountLevel::NORMAL,
            'add' 		=> AccountLevel::ADMIN,
            'edit' 		=> AccountLevel::ADMIN,
            'delete' 	=> AccountLevel::ADMIN,
            'list' 		=> AccountLevel::ADMIN,
		),
	),
)
?>