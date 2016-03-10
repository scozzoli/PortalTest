<?
/**
 * Estensione di Connection per My SQL 
 */
class PiConnectionMySQL extends PiConnection{
	
	public function connect(){
		$this->link = mysql_connect($this->src["server"],$this->src["dbuser"],$this->src["dbpwd"]);
		mysql_select_db($this->src["dbname"],$this->link);
		$this->is_connected = true;
	}
	
	public function disconnect(){
		mysql_close($this->link);
		$this->is_connected = false;
	}
	
	public function get($iQry){
		$func = create_function('$key','if(!isset($key)){return("'.(str_replace('"','\\"',$this->opt["null"])).'");}else{return($key);}');
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
