<?php
class Model extends ABModel{
		
	public function getDevice($bindvars) {
		$sql = "SELECT  P_KEY, NOMBRE
				FROM ".$this->Table."
				WHERE P_KEY=:COD";
		return $this->query_fetch($sql,$bindvars);
	}
	
	public function existDevice($bindvars){		
		$sql = "ADDDEVICE(:DEVICE, :RUT, :FTOKEN, @TOKEN)";
		$this->proc2($sql,$bindvars);		
		return $this->rQuery('SELECT @TOKEN');
	}
	public function ins_virtual($virtual, $dispositivo){	
		$sql = "CALL INS_VIRTUAL(".$virtual.",".$dispositivo.".,null)";
		return $this->single_query($sql,$bindvars);		
		//return $this->rQuery('SELECT @TOKEN');
	}
	public function getTracert($bindvars){	
		$sql = "SEL_TRACEROUTE(:DEVICE)";
		return $this->proc($sql,$bindvars);
	}
	public function getPosition($bindvars){	
		$sql = "SEL_POSITION(:DEVICE)";
		return $this->proc($sql,$bindvars);
	}
	
	public function getHistory($bindvars){	
		$sql = "SEL_POSITION_BY_DATE(:DEVICE, :START, :END)";
		return $this->proc($sql,$bindvars);
	}
	public function getTokenDevice($bindvars){	
		$sql = "GET_TOKEN_BY_DEVICE(:DEVICE)";
		return $this->proc($sql,$bindvars);
	}
	public function insError($bindvars){	
		$sql = "INS_FCM_ERROR(:TOKEN, :SUCCESS, :FAILURE, :RESULT)";
		return $this->proc2($sql,$bindvars);
	}
	
	public function unableToken($bindvars){	
		$sql = "UNABLE_TOKEN(:TOKEN)";
		return $this->proc2($sql,$bindvars);
	}
	
	
}
