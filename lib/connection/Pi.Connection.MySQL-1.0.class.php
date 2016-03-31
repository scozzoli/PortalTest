<?
/**
 * Estensione di Connection per My SQL 
 */
class PiConnectionMySQL extends PiConnection{
	
	public function connect(){
		$this->link = @mysql_connect($this->src["server"],$this->src["dbuser"],$this->src["dbpwd"]) or $this->error('Errore nella connessione al server MySQL <b>'.$this->src["server"].'</b>');
		if(!@mysql_select_db($this->src["dbname"],$this->link)){
			$this->error('Errore nella selezione del db del server MySQL '.$this->src["server"].'\\<b>'.$this->src["dbname"].'</b>');
		}
		$this->is_connected = true;
	}
	
	public function disconnect(){
		mysql_close($this->link);
		$this->is_connected = false;
	}
	
	public function get($iQry){
		$func = $this->getParseFunction();
		$raw_data = mysql_query($iQry,$this->link);
		$i = 0;
		$data = array();
		if($this->opt["associative"]){
			while($res = mysql_fetch_assoc($raw_data)){$data[$i++] = array_map($func,$res);}
		}else{
			while($res = mysql_fetch_row($raw_data)){$data[$i++] = array_map($func,$res);}
		}
		$this->opt['numrow'] = mysql_num_rows($raw_data);
		mysql_free_result($raw_data);
		return $data;
	}
	
	public function exec($iQry){
		$raw_data = mysql_query($iQry);
		$this->opt['numrow'] = mysql_affected_rows();//mysql_num_rows($raw_data);
	}
	
	public function __destruct(){
		if($this->is_connected===true){$this->disconnect();}
		parent::__destruct();
	}
}
?>
