<?php
const MODULO = 'service';
require(SERVER_ROOT . '/includes/SendNotification.php');
include_once(SERVER_ROOT . MODULOS . '/mod_'.MODULO.'/constantes.php');
include_once(SERVER_ROOT . MODULOS . '/mod_'.MODULO.'/vista.php');
include_once(SERVER_ROOT . MODULOS . '/mod_'.MODULO.'/modelo.php');

class Controller extends Controllermass{
	
	public function main($getVars,$subpage){
		$Vista = new Vista;	
		$Model = new Model;	
		
		$Vista -> subpage = $subpage;
		switch($subpage){
			case 'accdata':				
				$_data['success'] = 1;
				
				$_data['nombre'] 	= 'Pablo Molina Cardoso';
				$_data['rut'] 		= '17950096-5';
				$_data['banco'] 	= 'Banco Estado';
				$_data['tipo_cuenta'] = 'Cuenta Vista';
				$_data['cuenta'] 	= '17950096';
				$_data['email'] 	= 'contacto@timation.cl';
				$_data['asunto'] 	= 'Asegurese de enviar un comprobante de transferencia incluyendo el numero de dispositivo {device}';
				
				echo json_encode($_data);
				break;
			case 'accountstat':
				$_data['success'] = 1;
			/*
			ESTADOS PAGOS
			
			I: ILIMITADO (nO NECESITA PAGO)
			A: AL DIA
			P: POR VENCER
			V: VENCIDO
			*/
				$_devices = explode(",",$getVars['devices']);
				$_pagos = array();
				foreach($_devices as $device){
					$v = array(
						'DEVICE'		=> $device,
						'ESTADO'		=> 'A',
						'VENCIMIENTO'	=> '15/11/2017',
						'ULTIMO_PAGO'	=> '15/09/2017',
						'COMENTARIO'	=> 'Pago al dia',
					);
					$_pagos[] = $v;
				}
				$_data['_data'] = $_pagos;
				echo json_encode($_data);
				break;
			case 'notif':
				set_time_limit ( 100 );
				$device = '11223344';
				$_info = array( 
					'msg' => 'notification',
					'ID'		=> '58',
					'TIPO'		=> 'I',
					'FECHA'		=> '14/07/2017',
					'MENSAJE'	=> 'Mensaje de prueba FCM dfsds fd dfs dsf sdfsd fdsfds dsf sdf fsfdsfs s df fds f fds dsf dsfds f',
					'TITULO'	=> 'Prueba FCM',
				);
				$v = array(
					'device'	=>	$device,
				);
				$h = new Bind($v, 'getvars');
				//print_r($h);
				if($h->BindIsOk()){
					$_pos 	= $Model->getTokenDevice($h->vars());
					foreach($_pos as $key=>$val){
						if($val['TOKEN']){
							$token = $val['TOKEN'];							
							$serverObject = new SendNotification(FCM_KEY);	
							$jsonString = $serverObject->sendPushNotificationToGCMSever($token,$_info);
							$_result = json_decode($jsonString, true);
							print_r($_result);
							if($_result['success']===0){
								$result = $_result['results'][0]['error'];
								$bind = array(
									'token'		=>	$val['ID_TOKEN'],
									'success'	=>	$_result['success'],
									'failure'	=>	$_result['failure'],
									'result'	=>	$result
								);
								$insert = new Bind($bind,'errorfcm');
								if($insert->BindIsOk()){
									$Model->insError($insert->vars());
								}
								if(trim(strtolower($result))==strtolower("NotRegistered") || 
									trim(strtolower($result))==strtolower("InvalidRegistration") ){
									$insert->rmBind('success');
									$insert->rmBind('failure');
									$insert->rmBind('result');
									$Model->unableToken( $insert->vars() );
								}
							}
						}
					}
				}
				exit;
			case 'history':
				$_data['success'] = 0;
				$v = array(
					'device'	=>	$getVars['device'],
					'start'		=>	$getVars['start'],//'2017-10-09 15:21:00',//$getVars['start'],
					'end'		=>	$getVars['end']//'2017-10-09 15:21:59'//$getVars['end']
				);
				$h = new Bind($v,'history');
				if($h->BindIsOk()){
					$_pos 	= $Model->getHistory($h->vars());
					$_data['success'] = 1;
					$_data['position']	= $_pos[0];
				}
				$Vista->setArray($_data)->printJSON();
				exit;
				
			case 'tracert':
				$_data['success'] = 0;
				$h = new Bind(array('device'	=>	$getVars['device']),'adddevice');
				if($h->BindIsOk()){
					$_pos 	= $Model->getTracert($h->vars());
					$_data['success'] = 1;
					$_data['tracerts']	= $_pos;
				}
				$Vista->setArray($_data)->printJSON();
				exit;
				
			case 'test2':
				$_resp = $Model->ins_virtual(11223344, 1);
				print_r($_test);
				exit;
				break;
			case 'test':
				
				break;
				
				
			case 'adddevice':
				$v = array(
					'device'	=>	$getVars['device'],
					'rut'		=>	$getVars['pers'],
					'Ftoken'	=>	$getVars['token']
				);
				$_data['success'] = 0;
				$g = new Bind($v, 'adddevice');
				$h = new Bind(array('device'	=>	$getVars['device']),'adddevice');
				if($g->BindIsOk() && $h->BindIsOk()){
					$_resp 	= $Model->existDevice($g->vars());
					$_pos 	= $Model->getPosition($h->vars());
					$_data['id_virtual']= $getVars['device'];
					$_data['token']		= $_resp['@TOKEN'];
					$_data['position']	= $_pos[0];
					if($_resp['@TOKEN']){						
						$_data['success'] 	= 1;				
						$_data['msg'] 		= "Agregado Correctamente";
					}else{
						$_data['success'] 	= 0;				
						$_data['msg'] 	= "No se pudo agregar el dispositivo";
					}
				}
				$Vista->setArray($_data)->printJSON();
				exit;
									
			default:				
				$Vista->_data[0] = array(
					'text1'=>'Hello',
					'text2'=>'World',
					'default'=>'Default'
				);
				break;
			
		}
		//$Vista -> Ver();
			
	}
	
	
}