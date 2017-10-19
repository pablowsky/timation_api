<?php
	/***************************************************************************************************************
												OBTENGO PAGINA Y SUBPAGINA
	 ***************************************************************************************************************/
	 
	$request = $_SERVER['QUERY_STRING'];	
	$getVars=array();
	$subpage='';
		
	/**********************VARIBLES GET POST**************************/
	if($request){	
		// extraigo la pgina solicitada - la pagina es el primer elemento
		$parsed = explode('&' , $request);
		$temp_page = array_shift($parsed);
						
		// extraigo la subpagina - divido entre pagina y subpagina
		$temp_page = explode('_',$temp_page);
		$page = array_shift($temp_page);
		$subpage = array_pop($temp_page);
		
		// ordeno las variables recibidas
		$test=array();
		foreach($parsed as $key){			
			$pieces=explode("=",$key);
			$temp=$pieces[0];
			$test[$temp]=$pieces[1];			
		}		
		$getVars = fillpost('ALL','cadena_busqueda',$test);
		
	}else{
		$page	= MAIN_PAGE;	
		$subpage= '';
	}	
	
	
	
	if(USE_LOGIN){
		if( Session::get('autenticado') ){		
			if( (time()-Session::get('tiempo'))>SESSION_LIFE ){
				Session::set('autenticado', false);
				if($request) define('QUERY_STRING',$request);
				if( !array_key_exists($page,$no_pass_page) ){
					$page=PAGINA_PRINCIPAL;
				}else{
					if( !in_array($subpage,$no_pass_page[$page]) ){
						$page=PAGINA_PRINCIPAL;
					}
				}
			}else{
				Session::set('tiempo', time());	
				if($page=='login' || $page=='registro'){
					$page = PAGINA_PRINCIPAL_SS_INICIADA;
				}
			}
		}else{
			if( !array_key_exists($page,$no_pass_page) ){				
				if($request) define('QUERY_STRING',$request);
				$page=PAGINA_PRINCIPAL;
			}else{
				if( !in_array($subpage,$no_pass_page[$page]) ){
					if($request) define('QUERY_STRING',$request);
					$page=PAGINA_PRINCIPAL;
				}
			}
		}
	}
	
	/*******************************************************************************************
	 *  						REDIRECCION AL CONTROLADOR									   *
	 *******************************************************************************************/
	$target = SERVER_ROOT . '/modulos/mod_'.$page.'/control.php';


	if ($target != 'error') {
		if (file_exists($target)) {
			include_once($target);
			$class = 'Controller';
			if (class_exists($class)) {
				$controller = new $class;
			} else {
				die('Clase no Existe!');
			}
			
		} else {
			die('Pagina No existe!');
		}		
		
		$controller->main($getVars, $subpage);
		
	} else {		
		die('Pagina no Encontrada');		
	}

	function fillPost($keys,$exclude,$parsed){
		$array = array();
		foreach ($_POST as $key=>$val){
			if (is_array($keys)){
				if (in_array($key, $keys)) $array[$key] = $val;
			}elseif($keys==="ALL"){
				if (isset($exclude)){
					if(is_array($exclude)){
						if (!in_array($key,$exclude)) $array[$key] = $val;
					}else{
						if ($key!=$exclude) $array[$key] = $val;
					}
				}else{
					$array[$key] = $val;
				}
			}else return $_POST[$keys];
		}
		foreach ($parsed as $key=>$val){
			if (is_array($keys)){
				if (in_array($key, $keys)) $array[$key] = $val;
			}elseif($keys==="ALL"){
				if (isset($exclude)){
					if(is_array($exclude)){
						if (!in_array($key,$exclude)) $array[$key] = $val;
					}else{
						if ($key!=$exclude) $array[$key] = $val;
					}
				}else{
					$array[$key] = $val;
				}
			}else return $_GET[$keys];
		}
		return $array;
	}