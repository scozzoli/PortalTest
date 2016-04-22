<?
/**
 * Estensione di Connection per ODBC
 */
class PiConnectionODBC extends PiConnection{
	
	public function connect(){
		$this->link = odbc_connect($this->src["dns"],$this->src["dbuser"],$this->src["dbpwd"]) or or $this->error('Errore nella connessione al server ODBC : '.$this->src["server"]);
		$this->is_connected = true;
	}
	
	public function disconnect(){
		odbc_close($this->link);
		$this->is_connected= false;
	}
	
	public function get($iQry){
		$func = $this->getParseFunction();
		$raw_data = odbc_exec($this->link,$iQry);
        $i = 0;
        
        if($this->["associative"]=="matrix"){
			while($res = odbc_fetch_array($raw_data)){$data[$i++] = array_map($func,$res);}
		}else{
			while(odbc_fetch_into($raw_data,$res)){$data[$i++] = array_map($func,$res); unset($res);}
		}

		if($this->opt["rowindex"]){$data["row"]=$i;}
		if($this->opt["arrayindex"]){
		  	$j=0;
			while($j<odbc_num_fields($raw_data)){
				$data["rid"][odbc_field_name($raw_data,$j)] = $j++;
			}
		}
		$this->opt['numrow'] = odbc_num_rows($raw_data);
		odbc_free_result($raw_data);
		return $data;
	}
	
	public function exec($iQry){
		$raw_data = odbc_exec($this->link, $iQry);
		$this->opt['numrow'] = odbc_num_rows($raw_data);
	}
	
	public function __destruct(){
		if($this->is_connected===true){$this->disconnect();}
		parent::__destruct();
	}
}
?>
