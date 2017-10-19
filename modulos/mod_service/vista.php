<?php
class Vista extends MView {
	public $subpage;
	public $_data;
	public $filas;
	
	function Ver(){
		//global $diccionario;			
		$html = $this->getTemplate($this->subpage);
		//$html = $this->render_dinamic_data($html, $diccionario['formulario']);
		
		switch($this->subpage){
			case 'main':
				$html = $this->renderDetail($html, $this->_data);
				break;
									
			default:
				$html = $this->renderDetail($html, $this->_data);
				
				break;
		}			
		print $html;
			
		
	}
	

}

	
	