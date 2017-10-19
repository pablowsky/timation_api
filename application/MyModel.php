<?php

class ABModel extends MysqlImproved_Driver{

		private $regeX = '/\:[A-Z0-9_-]{1,}/';
		
		public function query_fetch($sql_l,$bindvars_l){
			/******************************************/
			$match = preg_match_all($this->regeX, $sql_l,$matches);
			$sql = preg_replace($this->regeX, ' ? ',$sql_l);
			
			$bindvars=array();
			foreach($matches[0] as $val){
				foreach($bindvars_l as $v){
					if($v[0] == $val){
						$bindvars[] = $v[1];
					}
				}
			}
			/*****************************************/
			$this->connect();
			$this->prepare($sql);
			if(!empty($bindvars)){ $this->sanitize($bindvars); }			
			$this->exec_w_commit();
			$res = $this->execFetchAll();
			return $res;
			
		}
		
		public function proc2($sql0,$bindvars_l){
			$sql_l = 'CALL '.$sql0;			
			/******************************************/
			$match = preg_match_all($this->regeX, $sql_l,$matches);
			$sql = preg_replace($this->regeX, ' ? ',$sql_l);
			
			$bindvars=array();
			foreach($matches[0] as $val){
				foreach($bindvars_l as $v){
					if($v[0] == $val){
						$bindvars[] = $v[1];
					}
				}
			}
			/*****************************************/
			$this->connect();
			$this->prepare($sql);
			if(!empty($bindvars)){ $this->sanitize($bindvars); }			
			$this->exec_w_commit();
		}
		
		public function proc($sql0,$bindvars){
			$sql = 'CALL '.$sql0;
			return $this->query_fetch($sql,$bindvars);
		}
		
		public function single_query($sql_l,$bindvars_l){
			/******************************************/
			$match = preg_match_all($this->regeX, $sql_l,$matches);
			$sql = preg_replace($this->regeX, ' ? ',$sql_l);
			
			
			$bindvars=array();	
			foreach($matches[0] as $val){
				$bindvars[]=$bindvars_l[trim($val)];// $bindvars[$val]=$bindvars_l[trim($val)];
			}
			/*****************************************/
			$this->connect();
			$this->prepare($sql);
			if(!empty($bindvars)){ $this->sanitize($bindvars); }			
			$this->exec_w_commit();
			return $this->last_key();
		}
		public function rQuery($sql){
			$this->prepare($sql);		
			$this->exec_w_commit();
			return $this->execFetchAssoc();
		}
		
		
		/*****************************************************************************************************************
												ELIMINAR REGISTROS
		******************************************************************************************************************/
		public function recicla_elemento($tabla,$clave,$bindvars){
			$sql="UPDATE ".$tabla."  SET ESTADO = 5 WHERE ".$clave."=:COD";
			return $this->single_query($sql,$bindvars);			
		}
		
		
		/*****************************************************************************************************************
												
		******************************************************************************************************************/
		
		
		public function last_id($secuencia) {
			$sql = "SELECT LAST_INSERT_ID(P_KEY) ".$secuencia;
			$res = $this->query_fetch($sql,'');
			//$this->disconnect();
			return $res;
		}
		
		
		/*****************************************************************************************************************
												COMBOBOX
		******************************************************************************************************************
		public function carga_combo($tabla, $columnas='P_KEY, NOMBRE', $orden_por='P_KEY') {
			$sql = "SELECT ".$columnas." FROM ".$tabla."  WHERE ESTADO='1' ORDER BY ".$orden_por;
			return $this->query_fetch($sql,$bindvars);
		}
		
		public function combo_unidades() {
			$sql = "SELECT P_KEY, NOMBRE FROM A_MOTORES WHERE ESTADO = '1' ORDER BY NOMBRE";
			return $this->query_fetch($sql,$bindvars);
		}
		
		public function combo_users() {
			$sql = "SELECT ID, USUARIO FROM USER_LIST ORDER BY ID";
			return $this->query_fetch($sql,$bindvars);
		}
		
		public function combo_personal() {
			$sql = "SELECT P_KEY, NOMBRES AS NOMBRE FROM A_PERSONAL  WHERE ESTADO='1' AND CARGO='1' ORDER BY NOMBRES";
			return $this->query_fetch($sql,$bindvars);
		}
		public function combo_supervisores() {
			$sql = "SELECT P_KEY, NOMBRES AS NOMBRE FROM A_PERSONAL  WHERE ESTADO='1' AND CARGO='2' ORDER BY NOMBRES";
			return $this->query_fetch($sql,$bindvars);
		}
		
		public function combo_proyectos_id($bindvars) {
			$sql = "SELECT CENTRO_COSTO, NOMBRE FROM A_PROYECTOS  WHERE estado='1' AND CENTRO_COSTO = :COD LIMIT 1";
			return $this->query_fetch($sql,$bindvars);
		}
		
		public function combo_comuna() {
			$sql = "SELECT P_KEY, NOMBRE FROM B_COMUNAS WHERE ESTADO=1 ORDER BY NOMBRE";
			return $this->query_fetch($sql,$bindvars);
		}
		public function combo_ciudad() {
			$sql = "SELECT P_KEY, NOMBRE FROM B_CIUDADES WHERE ESTADO=1 ORDER BY NOMBRE";
			return $this->query_fetch($sql,$bindvars);
		}
		public function combo_jornada() {
			$sql = "SELECT P_KEY, NOMBRE FROM B_JORNADAS WHERE ESTADO=1 ORDER BY NOMBRE";
			return $this->query_fetch($sql,$bindvars);
		}
		public function combo_cargo() {
			$sql = "SELECT P_KEY, NOMBRE FROM B_CARGOS WHERE ESTADO=1 ORDER BY NOMBRE";
			return $this->query_fetch($sql,$bindvars);
		}*/
		
	
}