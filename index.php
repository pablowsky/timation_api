<?php
	const APLICATION_MODE = 2;

	if(APLICATION_MODE==1){
		define('SERVER_ROOT' , '/home/admin/web/timation.cl/public_html/api');
	}elseif(APLICATION_MODE==0 || APLICATION_MODE==2){
		define('SERVER_ROOT' , 'D:/AppServ/www/findit_api');
	}

	//ini_set('upload_tmp_dir', SERVER_ROOT."/tempdir"); 
	//ini_set('memory_limit', "-1"); 
	ini_set('memory_limit', '-1');
	ini_set('set_time_limit', '0');
	

	require_once(SERVER_ROOT . '/libraries/drivers/mysqlimproved.php');
	require_once(SERVER_ROOT . '/application/' . 'Config.php');
	require_once(SERVER_ROOT . '/application/' . 'Controller.php');
	require_once(SERVER_ROOT . '/application/' . 'Session.php');
	require_once(SERVER_ROOT . '/application/' . 'View.php');
	require_once(SERVER_ROOT . '/application/' . 'MyModel.php');
	require_once(SERVER_ROOT . '/includes/' . 'Bind.php');
	require_once(SERVER_ROOT . '/application/' . 'Router.php');

?>