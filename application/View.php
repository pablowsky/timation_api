<?php
class MView {	
	
	private $_array;
	
	public function setArray($array){
		$this->_array = $array;
		return $this;
	}
	
	public function printJSON(){
		$this->print_json($this->_array);
	}
	

	function page_render( $html, $template, $_data, $marker='LISTADO', $format='E' ){
		if( $template )
			$html .= $this->get_template($template);
		
		if( count($_data)>1 )
			$html = $this->renderGrid($html, $_data, $marker, $format);
		else
			$html = $this->renderDetail($html, $_data, $format);
		return $html;
	}
	
	
	
	
		
	function print_json($_data,$base64=false,$opc=''){
		if( $base64 ){
			foreach($_data as $key=>$val){
				foreach($val as $k=>$v ){
					$_data[$key][$k] = base64_encode($this->regula_texto($v,$opc));
				}
			}
		}
		echo json_encode($_data);
		exit;
		return true;
	}
	

	
	function regula_texto($texto,$opc){
		$opciones=str_split($opc);
		
		$opciones[0] = !isset($opciones[0]) ? null : $opciones[0];
		$opciones[1] = !isset($opciones[1]) ? null : $opciones[1];
		$opciones[2] = !isset($opciones[2]) ? null : $opciones[2];
		$opciones[3] = !isset($opciones[3]) ? null : $opciones[3];		
		
		switch($opciones[0]){			
			case 'E':
				$texto = utf8_encode($texto);
				break;
			case 'D':
				$texto = utf8_decode($texto);
		}
		switch($opciones[1]){
			case 'U':
				$texto = mb_strtoupper($texto,'UTF-8');
				break;
			case 'L':
				$texto = mb_strtolower($texto,'UTF-8');
		}		
		switch($opciones[2]){
			case 'W':
				$texto = ucwords($texto);
				break;
			case 'F':
				$texto = ucfirst($texto);
		}
		
		if($opciones[3]==1){
			$texto = trim($texto);	
		}
		return $texto;			
	}
	
	function renderCombo($html, $_data, $key, $selected=null, $reg='0000', $val1='P_KEY', $val2='NOMBRE', $val3="PARENT") {		
		$regex 	= 	'/<!--'.$key.'-->[\s\S]*?<!--'.$key.'-->/';
		$match 	= 	preg_match($regex, $html,$matches);		
		$a	=0;
		$tabla = null;
		if( isset($matches[0]) ){
			$test	=	str_replace("<!--".$key."-->","",$matches[0]);
			while($a<count($_data)){
				$fila	= $test;
				$_sel 	= ( $selected == $_data[$a][$val1] )? 'selected' : '';
				$at 	= array(0=>array('SELECTED'=>$_sel,'CODIGO'=>$_data[$a][$val1],'DENOMINACION'=>$_data[$a][$val2],'PARENT'=>$_data[$a][$val3]));
				$fila 	= $this->renderDetail($fila, $at, $reg);		
				$tabla .= $fila;
				$a++;
			}
			$html = str_replace($matches[0],$tabla,$html);
		}
		return $html;
	}
	
	function renderGrid($html, $array_data,$key, $reg='0000') {
		if( is_array($array_data) ){
			$regex = '/<!--'.$key.'-->[\s\S]*?<!--'.$key.'-->/';
			$match = preg_match($regex, $html,$matches);
			
			$a=0;
			$tabla = null;
			if( isset($matches[0]) ){
				$test = str_replace("<!--".$key."-->","",$matches[0]);
				$b = count($array_data);
				while( $a<$b ){
					if ($a % 2) { $fondolinea="itemParTabla"; } else { $fondolinea="itemImparTabla"; }
					$fila=$test;
					$fila;
					$fila = str_replace('{fondolinea}', $fondolinea, $fila);
					foreach($array_data[$a] as $key=>$val){
						$fila = str_replace('{'.$key.'}', $this->regula_texto($val,$reg), $fila);		
					}
					
					$tabla .= $fila;
					$a++;
				}
				$html = str_replace($matches[0],$tabla,$html);
			}
			return $html;
		}else
			return false;
		
	}

	function renderDetail($html, $array_data, $reg='0000') {
		if(is_array($array_data[0])){
			foreach($array_data[0] as $key=>$val){
				$html = str_replace('{'.$key.'}', $this->regula_texto($val,$reg), $html);		
			}	
		}
		return $html;
	}
	


	function getTemplate($view) {
		$view = strtolower($view);
		
		if($view==MODULO || $view==''){ 
			$template = 'index'; 
		}else{
			$template = $view;
		}
		
		$file = SERVER_ROOT . '/site_media/html/'.MODULO.'/'.$template.'.html';
		
		if(!file_exists($file)){
			$file = SERVER_ROOT . '/site_media/html/error_404.html';
		}	
		
		$template = file_get_contents($file);	
		return $template;
	}

}