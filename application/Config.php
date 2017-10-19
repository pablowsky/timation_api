<?php
	/**
	  * MODO 0 = DESARROLLO ;; MODO 1 = PRODUCCION ;; MODO 2 = PRUEBAS (SE CONECTA A LA BD DE PRODUCCION PERO EN FORMA LOCAL)
	  * http://mdr-codelco.bureauveritas.cl/  --- http://localhost/bvmr_poo
	  */
	
	if(APLICATION_MODE==1){
		define('SITE_ROOT' , 'http://'.$_SERVER['SERVER_NAME'].'/');
		define('SESSION_LIFE',60*40);
	}elseif(APLICATION_MODE==0 || APLICATION_MODE==2){
		define('SITE_ROOT' , 'http://localhost/clcframework/');
		define('SESSION_LIFE',60*60*24*7);
	}
	/** APP NAME**/
	define('NAME_APP','PIAM');
	
	/** INITIAL PAGE **/
	define('MAIN_PAGE','site');
	
	/** INITIAL PAGE WITH SESSION STARTED **/
	define('MAIN_PAGE_WITH_SESSION','main');
	
	/** MODULES DIR **/
	define('MODULOS','/modulos');
	
	/** USE LOGIN SCRIPT **/	
	define('USE_LOGIN',false);
	
	/*********************************************************************************************************
												NO PASSWORD PAGE
	*********************************************************************************************************/
	$no_pass_page = array(	'registro'=>array('area','newuser','validacion','download','delete','mkdir','rm','upload','history'),
							'login'=>array('','init','salir','reset','resetkey','newkey'));
	/*********************************************************************************************************
												RELATIVO A ARCHIVOS Y CARPETAS
	*********************************************************************************************************/
	define('MASTER_FOLDER','/folder');
	define('TEMP_FOLDER','/folder_temp');
	define('LIB_FOLDER','/biblioteca');	
	define('CURRENT_DIR','/'.date('Y/m/d'));
	if(!is_dir(SERVER_ROOT.MASTER_FOLDER.LIB_FOLDER.CURRENT_DIR.'/')){
		mkdir(SERVER_ROOT.MASTER_FOLDER.LIB_FOLDER.CURRENT_DIR.'/',0777,true);
	}
	
	/*********************************************************************************************************
												CONEXION ORACLE
	*********************************************************************************************************/
	if( APLICATION_MODE==1  || APLICATION_MODE==2 ){
		define('MyUSUARIO', 'admin_timation');
		define('MyCLAVE', 'T745g1s5f');
		define('MyHOST', 'timation.cl');
		define('MyBD', 'admin_timationtracker');
		define("HASH_KEY", "4ffddf1d3cae5");
	} elseif( APLICATION_MODE==0 ){		
		define('MyUSUARIO', 'root');
		define('MyCLAVE', 'Mysql001');
		define('MyHOST', 'localhost');
		define('MyBD', 'findit');
		define("HASH_KEY", "4ffddf1d3cae5");
	}	
	/*********************************************************************************************************
												ARCHIVOS XML
	*********************************************************************************************************/
	if(APLICATION_MODE==1 || APLICATION_MODE==2){
		define('XML_LISTBOX',SERVER_ROOT.'/xml/listas_desplegables.xml');
	}elseif(APLICATION_MODE==0){
		define('XML_LISTBOX',SERVER_ROOT.'/xml/dev_listas_desplegables.xml');
	}
	
?>