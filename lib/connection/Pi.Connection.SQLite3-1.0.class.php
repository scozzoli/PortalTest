<?
/**
 * Estensione di Connection per SQlite
 */
class PiConnectionSQLite3 extends PiConnection{
	
	public function connect(){
		$this->link = new sqlite3($this->src["name"],SQLITE3_OPEN_CREATE);
		$this->is_connected = true;
	}
	
	public function disconnect(){
		$this->link->close();
		$this->is_connected = false;
	}
	
	public function get($iQry){
		$func = create_function('$key','if(!isset($key)){return("'.(str_replace('"','\\"',$this->opt["null"])).'");}else{return($key);}');
		$row_data = $this->link->query($iQry);
        $i = 0;

        if($this->opt["associative"]){
			while($row_data->columnType(0) != SQLITE3_NULL){$data[$i++] = array_map($func,$row_data->fetch_array("SQLITE3_ASSOC"));}
		}else{
			while($row_data->columnType(0) != SQLITE3_NULL){$data[$i++] = array_map($func,$row_data->fetch_array("SQLITE3_NUM"));}
		}
		
        unset($row_data);
		return $data;
	}
	
	public function exec($iQry){
		$this->link->exec($iQry);
	}
	
	public function __destruct(){
		if($this->is_connected){$this->disconnect();}
		parent::__destruct();
	}
}
?>
