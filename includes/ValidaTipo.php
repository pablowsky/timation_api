<?php
class ValidaTipo{
	
	public function validar($tipo, $valor){
		$b = false;
        if ($tipo && $valor) {
            switch ($tipo) {
                case 'integer':
                    $b = $this->is_valid_digit($valor);
                    break;                
                case 'alphanum':
                    $b = $this->is_valid_alnum($valor);
                    break;                
                case 'chars':
                    $b = $this->is_valid_char($valor);
                    break;					
                case 'email':
                    $b = $this->is_valid_email($valor);
                    break;					
                case 'date':
                    $b = $this->is_valid_date($valor);
					break;					
                case 'filename':
                    $b = true;                    
                    break;					
                case 'text':
                    $b = true;                
                    break;						
                case 'data':
                    $b = true;                
                    break;				
                case 'number':
                    $b = $this->is_valid_number($valor);                    
                    break;
            }
        }
		return $b;
    }
	
	protected function is_valid_date($val){
		$val = str_replace('-','/',$val);
        $partes = explode("/", $val);
        if ($this->is_valid_digit($partes[1]) && $this->is_valid_digit($partes[0]) && $this->is_valid_digit($partes[2])) {
            if (checkdate($partes[1], $partes[0], $partes[2])) {
                return true;
            }
        }
        return true;
    }
    
    protected function is_valid_digit($val){
        if (ctype_digit($val)) {
            return true;
        }
        return false;
    }
	
	protected function is_valid_number($val){
        if (is_numeric($val)) {
            return true;
        }
        return false;
    }
    
    protected function is_valid_char($val){
        if (ctype_alpha($val)) {
            return true;
        }
        return false;
    }
    
    protected function is_valid_alnum($val){
        if (ctype_alnum($val)) {
            return true;
        }
        return false;
    }
	
    protected function is_valid_email($val){
        if (filter_var($val, FILTER_VALIDATE_EMAIL)) {
            return true;
        }
        return false;
    }	
	
}