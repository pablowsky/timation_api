<?php


class Session
{
    public static function init()
    {
        if(!isset($_SESSION)) 
		{ 
			session_name(NAME_APP);
			session_start(); 
		}
    }
    
    public static function destroy($clave = false)
    {
        if($clave){
            if(is_array($clave)){
                for($i = 0; $i < count($clave); $i++){
                    if(isset($_SESSION[$clave[$i]])){
                        unset($_SESSION[$clave[$i]]);
                    }
                }
            }
            else{
                if(isset($_SESSION[$clave])){
                    unset($_SESSION[$clave]);
                }
            }
        }
        else{
            session_destroy();
        }
    }
    
    public static function set($clave, $valor)
    {
        if(!empty($clave))
        $_SESSION[$clave] = $valor;
		
    }
    
    public static function get($clave)
    {
        if(!isset($_SESSION)) 
		{ 
			session_name(NAME_APP);
			session_start(); 
		}
		/*
		session_name(NAME_APP);
		session_start();	*/	
		if(isset($_SESSION[$clave]))
            return $_SESSION[$clave];
    }
	public function close(){
		session_write_close();
	}
}

?>