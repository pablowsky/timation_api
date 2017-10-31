<?php

	
	$listado_inputs=array(	
		'errorfcm'=>array(	
				'TOKEN' =>array(	'size'=>1000,
									'type'=>'data',
									'if_null'=>'ERROR'),
				'SUCCESS' =>array(	'size'=>20,
									'type'=>'text',
									'if_null'=>'PASS'),
				'FAILURE' =>array(	'size'=>20,
									'type'=>'text',
									'if_null'=>'PASS'),
				'RESULT' =>array(	'size'=>200,
									'type'=>'text',
									'if_null'=>'PASS')),
											
		'getvars'=>array(	
				'DEVICE' =>array(	'size'=>11,
									'type'=>'integer',
									'if_null'=>'ERROR')),
											
		'history' =>array(
				'DEVICE' =>array(	'size'=>11,
									'type'=>'integer',
									'if_null'=>'ERROR'),

				'START' =>array(	'size'=>20,
									'type'=>'data',
									'if_null'=>'ERROR'),

				'END' => array(		'size'=>20,
									'type'=>'data',
									'if_null'=>'ERROR')),
											
		'tracert' =>array(
				'DEVICE' =>array(	'size'=>11,
									'type'=>'integer',
									'if_null'=>'ERROR'),

				'MINUTES' =>array(	'size'=>4,
									'type'=>'integer',
									'if_null'=>'ERROR')),
											
		'adddevice' =>array(
				'DEVICE' =>array(	'size'=>11,
									'type'=>'integer',
									'if_null'=>'ERROR'),

				'RUT' =>array(	'size'=>10,
								'type'=>'alphanum',
								'if_null'=>'ERROR'),

				'FTOKEN' => array(	'size'=>1000,
									'type'=>'data',
									'if_null'=>'PASS'))
	);
	
	const FCM_KEY = 'AAAAvAuEkHc:APA91bHrFuhfUvXJ7AVH05ss4Xq9i_433BR7aABRsQt9rw2zf_VHhEH_qerD06SR6YDICdOyqJJrEsLX3RlIJO41soIlgt--0-gWWvRWObQ3Gu3jj2INCoLR3H5m9ahyP0YDPR0jMm63';

?>
