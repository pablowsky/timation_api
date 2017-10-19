<?php
const MODULO = 'site';
include_once(SERVER_ROOT . MODULOS . '/mod_'.MODULO.'/constantes.php');
include_once(SERVER_ROOT . MODULOS . '/mod_'.MODULO.'/vista.php');
include_once(SERVER_ROOT . MODULOS . '/mod_'.MODULO.'/modelo.php');

class Controller extends Controllermass{
	
	public function main($getVars,$subpage){
		$Vista = new Vista;	
		$Model = new Model;	
		
		$Vista -> subpage = $subpage;
		switch($subpage){
			case 'main':
				$Vista->_data[0] = array(
					'h'=>'Hello',
					'w'=>'World'
				);
				break;
									
			default:				
				$Vista->_data[0] = array(
					'text1'=>'Hello',
					'text2'=>'World',
					'default'=>'Default'
				);
				break;
			
		}
		$Vista -> Ver();
			
	}
	
	
}