<?php
/**
 * Estensione di Connection per Oracle (driver vecchi NON oci)
 */
class PiConnectionOracle extends PiConnection{
	protected $cur;
	
	public function connect(){
		$this->link = ora_logon($this->src["dbuser"]."@".$this->src["server"],$this->src["dbpwd"]);
		$this->cur = ora_open($this->link);
		$this->is_connected = true;
	}
	
	public function disconnect(){
		ora_close($this->cur);
		ora_logoff($this->link);
		$this->is_connected = false;
	}
	
	public function get($iQry){
		ora_parse($this->cur,$iQry);
		ora_exec($this->cur);
		$n_col = ora_numcols($this->cur);
		$row = 0;
		while(ora_fetch_into($this->cur, $res)){
			for($i=0;$i!=$n_col;$i++){
			  	$index = ($this->opt["associative"]) ? ora_columnname($this->cur,$i) : $i;
				$data[$row][$index] = isset($res[$i]) ? $res[$i] : $this->opt["null"];
			}
			$row++;
			$res=null;
		}
		
		return $data;
	}
	
	public function exec($iQry){
		ora_parse($this->cur,$iQry);
		ora_exec($this->cur);
	}
	
	public function __destruct(){
		if($this->is_connected===true){$this->disconnect();}
		parent::__destruct();
	}
}
?>
