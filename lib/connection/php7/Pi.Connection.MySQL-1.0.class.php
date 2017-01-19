<?php
/**
 * Estensione di Connection per My SQL 
 */
class PiConnectionMySQL extends PiConnection{
	
	public function connect(){
		$this->link = @mysqli_connect($this->src["server"],$this->src["dbuser"],$this->src["dbpwd"],$this->src["dbname"]) or $this->error('Errore nella connessione al server MySQL <b>'.$this->src["server"].'</b>');
		$this->is_connected = true;
	}
	
	public function disconnect(){
		mysqli_close($this->link);
		$this->is_connected = false;
	}
	
	public function get($iQry){
		$func = $this->getParseFunction();
		$raw_data = mysqli_query($this->link,$iQry);
		$i = 0;
		$data = array();
		if($this->opt["associative"]){
			while($res = mysqli_fetch_assoc($raw_data)){$data[$i++] = array_map($func,$res);}
		}else{
			while($res = mysqli_fetch_row($raw_data)){$data[$i++] = array_map($func,$res);}
		}
		$this->opt['numrow'] = mysqli_num_rows($raw_data);
		mysqli_free_result($raw_data);
		return $data;
	}
	
	public function exec($iQry){
		$raw_data = mysqli_query($this->link,$iQry);
		$this->opt['numrow'] = mysqli_affected_rows();//mysql_num_rows($raw_data);
	}
	
	public function __destruct(){
		if($this->is_connected===true){$this->disconnect();}
		parent::__destruct();
	}
}
?>
