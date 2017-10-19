<?php
include 'ValidaTipo.php';
/*
	************** REQUERIMIENTOS ****************
	-- incluir clase ValidaTipo.php
	-- array de constantes cono nombre: $listado_inputs
	
	
	************** EJEMPLO DE CONSTANTES ****************
	$listado_inputs=array(	
		'srcactivos' =>array(	'INICIOPAGINA' =>array('size'=>6,
												'type'=>'integer',
												'if_null'=>'DROP'),

						'FINALPAGINA' =>array('size'=>6,
										'type'=>'integer',
										'if_null'=>'DROP'),

						'FOLIO' =>array('size'=>6,
										'type'=>'text',
										'if_null'=>'ERROR'),

						'ID_UBICACION' =>array(	'size'=>6,
											'type'=>'integer',
											'if_null'=>'ERROR'),

						'NOMBRE'=>array('size'=>90,
										'type'=>'text',
										'if_null'=>'PASS')),							
	
		'buscador' =>array(	'FOLIO' =>array('largo'=>6,
										'tipo'=>'integer',
										'valido_nulo'=>'si'),

						'ID_UBICACION' =>array(	'largo'=>6,
											'tipo'=>'integer',
											'valido_nulo'=>'si'),

						'NOMBRE'=>array('largo'=>90,
										'tipo'=>'text',
										'valido_nulo'=>'si'))
	);
	
	******************* USO DE LA CLASE BIND ******************
	--- DECLARACION DE VARIABLES
	$v = array('cod'=>'584526','ID_TRASPASO'=>'5','id_activo'=>6,'observacion'=>'texto de prueba <script>','fecha'=>'28/11/2016');
	$v = array('INICIOPAGINA'=>'','FINALPAGINA'=>'5343','FOLIO'=>'6','ID_UBICACION'=>'56','NOMBRE'=>' <script> sdfsd s  f ff ');
	--- INSTANCIA DE OBJETO BIND
	$g = new Bind($v,'srcactivos');	
	//print_r($g->vars());
	--- VERIFICACION PRIMARIA DE VARIABLES (fecha es fecha, texto es texto, numeros son numeros, etc)
	if($g->BindIsOk()){
		--- OBTENCION DE OBEJETO BIND
		print_r($g->vars());
	}else{
		--- OBTENCION DE ERROR
		print_r($g->getError());
	}
	//echo Bind::vars(array('cod'=>'584526','id_traslado'=>'5','id_activo'=>6,'observacion'=>'texto de prueba <script>','fecha'=>'28/11/2016'),'nuevo');*/

class Bind{
	private $includeVars;
	private $includeErrors;
	private $decode_UTF8 = true;
	
	public function __construct($getVars,$group){
		global $listado_inputs;
		
		if(!is_array($getVars))
			return;
		foreach( $getVars as $key=>$value ){
			if(array_key_exists( strtoupper($key), $listado_inputs[$group]) ){
				$_attr = $listado_inputs[$group][strtoupper($key)];
				$_attr = $this->Complete($_attr);
				if(!$value){
					if( $_attr['zero']=='NO' ){
						switch($_attr['if_null']){
							case 'ERROR':
								$this->setError($key,'Nulo.');
								$a = false;
								break;
							case 'PASS':
								$a = true;
								$c = true;
								break;
							case 'DROP':
								$a = false;
								
						}
					}else if($_attr['zero']=='YES'){
						$a = true;
					}
				}else{
					$a = true;
					$c = $this->checkType($_attr,$key,$value);
				}
				
				$b = $this->checkSize($_attr,$key,$value);
				
				if( $this->decode_UTF8 == true )
					$value = utf8_decode($value);
				//if($a)
					
				$value = $this->clearText($_attr['type'],$value);
				
				if($a && $b && $c){					
					$this->includeVars[] = array(
						':' . strtoupper($key),
						$value,
						'-1'
					);
				}
			
			
			}else{
				//$this->setError($key,'Sin Clasificacion.');
			}		
		}	
	}
	
	public function setEncoding($b){
		$this->decode_UTF8 = true;
	}
	
	public function rmBind($rmv){
		$rmv = ':'.mb_strtoupper($rmv);
		//$b=0;
		
		foreach( $this->includeVars as $key=>$val ){
			//print_r($val);
			if( $val[0] == $rmv ){
				unset($this->includeVars[$key]);
			}
			//++$b;
		}
		ksort($this->includeVars);
		return $this->includeVars;
	}	
	
	public function vars(){
		return $this->includeVars;
	}
	
	public function BindIsOk(){
		$c = count($this->includeErrors);
		if($c==0)
			return true;
		return false;
	}
	
	public function getError(){
		return $this->includeErrors;
	}
	
	
	private function clearText($type,$value){
		if($type=="text" || $type=="filename")
			return $this->clean_xss($value);
		return $value;
	}
	
	
	private function checkSize($_attr,$key,$value){
		if(array_key_exists('size',$_attr)){
			if ( $_attr['size'] >= mb_strlen($value, 'UTF-8') ){				
				return true;
			} 
		}
		$this->setError($key,'Largo maximo excedido.');
		return false;
	}
	private function checkType($_attr,$key,$value){
		$vld = new ValidaTipo();
		
		if ( $vld->validar($_attr['type'], $value)) {	
			return true;			
		} else {
			$this->setError($key,'Tipo de dato no compatible.');
			return false;
		}
		$this->setError($key,'Tipo de dato no encontrado.');
		return false;
	}
	
	private function Complete($temp){
		$_base = array(	'zero'=>'NO', // YES, NO
					'if_null'=>'ERROR' // ERROR, PASS, DROP,
		);
		if(is_array($temp)){
			return array_merge($_base,$temp);
		}
		return $temp;
	}
	private function setError($key,$error){
		$curr = $this->includeErrors[strtoupper($key)];
		
		$this->includeErrors[strtoupper($key)] = $error.', '.$curr;
	}
	
	protected function clean_xss($val){
		$_dic1 = array('\\','/',':','*','?','"','<','>','|','&','??');
		$_dic2 = array(
			'SCRIPT','OBJECT','APPLET','EMBED','FORM','script','object','applet','embed','form',
			'-->','&','<','>',"\\",'&amp;','&lt;','&gt;','&quot;','&#x27;','&#x2F;');
		$val = str_replace($_dic1, "", $val);
		$val = str_replace($_dic2, "", $val);
		return $val;
	}

}




/*.

ERROR -> 	COD -> LARGO, TIPO, NULO
			ID_USUARIO -> TIPO
			











*/
























?>