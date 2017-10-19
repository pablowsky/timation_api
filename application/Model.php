<?php
class ABModel extends OracleImproved_Driver{

		public function query_fetch($sql,$bindvars){
			$this->connect();
			$this->prepare($sql);
			if( $this->sanitize($bindvars) ){
				if( $this->exec_w_commit() ){
					return $this->execFetchAll();
				}else
					return false;
			}
			return false;
		}
		
		public function query_return($sql,$bindvars){
			$this->connect();
			$this->prepare($sql);
			$bindvars = $this->sanitize2($bindvars);
			if( $this->exec_w_commit() ){
				return $bindvars;
			}
			return null;
		}
		
		public function single_query($sql,$bindvars){
			$this->connect();
			$this->prepare($sql);
			if( !empty($bindvars) ){ 
				if( $this->sanitize($bindvars) ){
					//$this->sanitize($bindvars);
					return $this->exec_w_commit();
					return 'ok';
				}else{
					return false;
				}
			}
		}
		
		
		public function activa_nls_sort() {
			$sql = "ALTER SESSION SET NLS_COMP='LINGUISTIC'";
			$res = $this->single_query($sql,'');
		}
		public function activa_nls_comp() {
			$sql = "ALTER SESSION SET NLS_SORT='BINARY_AI'";
			$res = $this->single_query($sql,'');
		}
		
		public function last_id($secuencia) {
			$sql = "SELECT ".$secuencia.".CURRVAL FROM DUAL";
			$res = $this->query_fetch($sql,'');
			$this->disconnect();
			return $res;
		}
		
		/*****************************************************************************************************************
												NUEVA SECUENCIA
		******************************************************************************************************************/
		
		
		public function giveMeID($sqc) {
			$sql = "SELECT ".$sqc.".nextval as P_KEY FROM dual";
			$resp = $this->query_fetch($sql,'');
			return $resp[0]['P_KEY'];
		}
		
		/*****************************************************************************************************************
												ELIMINAR REGISTROS
		******************************************************************************************************************/
		public function recicla_elemento($tabla,$clave,$bindvars){
			$sql="UPDATE ".$tabla."  SET ESTADO = 5 WHERE ".$clave."=:COD";
			return $this->single_query($sql,$bindvars);			
		}
		
	
	
}