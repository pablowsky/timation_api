<?php

class OracleImproved_Driver {

    protected $conn = null;
    protected $stid = null;
    protected $prefetch = 100;


    function connect() {
	
		$this->conn = @oci_connect(USUARIO,CLAVE, '(DESCRIPTION=(ADDRESS_LIST=(ADDRESS=(PROTOCOL=TCP)(HOST='.HOST.')(PORT='.PUERTO.')))(CONNECT_DATA=(SERVICE_NAME='.SID.')))', 'WE8ISO8859P1');
        if (!$this->conn) {
            $m = oci_error();
			echo 'Cannot connect to database: ' . $m['message'];
			return false;
            //throw new \Exception('Cannot connect to database: ' . $m['message']);
        }
    }

    function disconnect() {
        if ($this->stid)
            oci_free_statement($this->stid);
        if ($this->conn)
            oci_close($this->conn);
    }

    public function prepare($sql) { //**************
		if($this->conn){
			$this->stid = oci_parse($this->conn, $sql);
			if ($this->prefetch >= 0) {
				oci_set_prefetch($this->stid, $this->prefetch);
			}
		}else
			return false;
    }
	
	public function sanitize2($bindvars){
		$r = null;
		if ($this->stid){
			if( is_array($bindvars) ){
				foreach ($bindvars as $key=>$bv) {
					oci_bind_by_name($this->stid, $bindvars[$key][0], $bindvars[$key][1], $bindvars[$key][2]);
				}
				$r = $bindvars;
			}
		}
		return $r;
	}
	
	public function sanitize($bindvars){
		if ($this->stid){
			if( is_array($bindvars) ){
				foreach ($bindvars as $bv) {
					// oci_bind_by_name(resource, bv_name, php_variable, length)
					//oci_bind_by_name($this->stid, $bv[0], $bv[1], $bv[2]);
					if( is_array($bv)){
						oci_bind_by_name($this->stid, $bv[0], $bv[1], $bv[2]);
					}else
						return false;
				}
			}
			return true;
		}
	}

	public function return_key($bind_key){
		oci_bind_by_name($this->stid, ':id', $theID, -1, SQLT_INT);
		return $theID;
	}

	public function exec_w_commit(){
		$action = null;
		if($this->stid){
			oci_set_action($this->conn, $action);

			//oci_execute($this->stid);
			$r = oci_execute($this->stid);
			if (!$r) {
				//$e = oci_error($this->stid);  // For oci_execute errors pass the statement handle
				//print htmlentities($e['sqltext']);
				return false;
			}else
				return true;
		}else
			return false;
	}

    public function execFetchAll() {
		if($this->stid){
			oci_fetch_all($this->stid, $res, 0, -1, OCI_FETCHSTATEMENT_BY_ROW);
			$this->stid = null; 
			return $res;
		}else
			return false;
    }

}