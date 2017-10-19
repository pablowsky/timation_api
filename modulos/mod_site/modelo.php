<?php
class Model extends ABModel{
	
		
	public function getCountries($bindvars) {
		$sql = "SELECT * FROM COUNTRIES WHERE REGION_ID=:COD";
		return $this->query_fetch($sql,$bindvars);
	}
	
	
}
	




