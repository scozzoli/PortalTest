<?php
/**
 * Estensione di Connection per MS SQL Server (per PHP 7.0)
 */
class PiConnectionMSSQL extends PiConnection{
	
	public function connect(){
		$connectionInfo = array(
			"Database" => $this->src["dbname"],
			"UID" => $this->src["dbuser"],
			"PWD" => $this->src["dbpwd"]
		);
		$this->link = sqlsrv_connect($this->src["server"],$connectionInfo) or $this->error('Errore nella connessione al server MSSQL : '.$this->src["server"]);//$this->error(print_r(sqlsrv_errors(),true));
		
		$this->is_connected = true;
	}
	
	public function disconnect(){
		sqlsrv_close($this->link);
		$this->is_connected = false;
	}
	
	public function get($iQry){
		$func = $this->getParseFunction();
		$raw_data = sqlsrv_query($this->link,$iQry);
		
		if($raw_data === false){
			$this->error(print_r(sqlsrv_errors(),true));
		}
		
		$i = 0;
		$data = array();
		if($this->opt["associative"]){
			while($res = sqlsrv_fetch_array($raw_data,SQLSRV_FETCH_ASSOC)){$data[$i++] = array_map($func,$res);}
		}else{
			while($res = sqlsrv_fetch_array($raw_data,SQLSRV_FETCH_NUMERIC)){$data[$i++] = array_map($func,$res);}
		}
		
		$this->opt['numrow'] = $i;
		sqlsrv_free_stmt($raw_data);
		return $data;
	}
	
	public function exec($iQry){
		$raw_data = sqlsrv_query($this->link,$iQry);
		if($raw_data === false){
			$this->opt['numrow'] = $raw_data ? 1 : 0;
			$this->error(print_r(sqlsrv_errors(),true));
		}else{
			$this->opt['numrow'] = sqlsrv_num_rows($raw_data);
		}
	}
	
	public function __destruct(){
		if($this->is_connected===true){$this->disconnect();}
		parent::__destruct();
	}
}
?>
