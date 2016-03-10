<?
/**
 * Estensione di Connection per ODBC
 */
class PiConnectionODBC extends PiConnection{
	
	public function connect(){
		$this->link = odbc_connect($this->src["dns"],$this->src["dbuser"],$this->src["dbpwd"]);
		$this->is_connected = true;
	}
	
	public function disconnect(){
		odbc_close($this->link);
		$this->is_connected= false;
	}
	
	public function get($iQry){
		$func = create_function('$key','if(!isset($key)){return("'.(str_replace('"','\\"',$this->opt["null"])).'");}else{return($key);}');
		$row_data = odbc_exec($this->link,$iQry);
        $i = 0;
        
        if($this->["associative"]=="matrix"){
			while($res = odbc_fetch_array($row_data)){$data[$i++] = array_map($func,$res);}
		}else{
			while(odbc_fetch_into($row_data,$res)){$data[$i++] = array_map($func,$res); unset($res);}
		}

		if($this->opt["rowindex"]){$data["row"]=$i;}
		if($this->opt["arrayindex"]){
		  	$j=0;
			while($j<odbc_num_fields($row_data)){
				$data["rid"][odbc_field_name($row_data,$j)] = $j++;
			}
		}
		$this->opt['numrow'] = odbc_num_rows($row_data);
		odbc_free_result($row_data);
		return $data;
	}
	
	public function exec($iQry){
		$row_data = odbc_exec($this->link, $iQry);
		$this->opt['numrow'] = odbc_num_rows($row_data);
	}
	
	public function __destruct(){
		if($this->is_connected===true){$this->disconnect();}
		parent::__destruct();
	}
}
?>
