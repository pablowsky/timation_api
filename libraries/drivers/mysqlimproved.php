<?php
/**
 * The MySQL Improved driver extends the Database_Library to provide 
 * interaction with a MySQL database
 */
class MysqlImproved_Driver{
    protected $conn = null;
    protected $stid = null;
    protected $prefetch = 100;


    function connect() {
		$this->conn = new mysqli(MyHOST, MyUSUARIO, MyCLAVE, MyBD);
        if (!$this->conn) {
            $m = mysqli_connect_error();
            throw new \Exception('Cannot connect to database: ' . $m);
        }
    }
	
	function last_key(){
		return mysqli_insert_id($this->conn);
	}
	
 
    function disconnect() {
        if ($this->stid)
            oci_free_statement($this->stid);
        if ($this->conn)
            oci_close($this->conn);
    }

    public function prepare($sql) {
		$this->stid = $this->conn->prepare($sql);
    }
	

	public function sanitize($bindvars){
		$params = array_merge(array(str_repeat('s', count($bindvars))), array_values($bindvars));
		call_user_func_array(array($this->stid, 'bind_param'), $this->refValues($params));
	}
	
	function refValues($arr){ 
		if (strnatcmp(phpversion(),'5.3') >= 0){ 
			$refs = array(); 
			foreach($arr as $key => $value) 
				$refs[$key] = &$arr[$key]; 
			return $refs; 
		} 
		return $arr; 
	}
	
	public function exec_w_commit(){
		$this->stid->execute();	
	}
	
	public  function execFetchAssoc(){
		$meta = $this->stid->result_metadata(); 

		while ($field = $meta->fetch_field()) { 
			$params[] = &$row[$field->name]; 
		} 
		
		call_user_func_array(array($this->stid, 'bind_result'), $params);            
		while ($this->stid->fetch()) { 
			foreach($row as $key => $val) { 
				$c[$key] = $val; 
			} 
			//$hits[] = $c; 
		}
		return $c;
	}
	public  function execFetchAll(){
		$meta = $this->stid->result_metadata(); 

		while ($field = $meta->fetch_field()) { 
			$params[] = &$row[$field->name]; 
		} 
		
		call_user_func_array(array($this->stid, 'bind_result'), $params);            
		while ($this->stid->fetch()) { 
			foreach($row as $key => $val) { 
				$c[$key] = $val; 
			} 
			$hits[] = $c; 
		}
		return $hits;
	}
}