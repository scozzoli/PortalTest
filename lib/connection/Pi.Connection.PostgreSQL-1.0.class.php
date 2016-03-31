<?
/**
 * Estensione di Connection per Postgre SQL 
 */
class PiConnectionPostgreSQL extends PiConnection{
	

	public function connect(){
		$this->link = pg_connect(' "host='.$this->src["server"].' user='.$this->src["dbuser"].' password='.$this->src["dbpwd"].' dbname='.$this->src["dbname"].' "');
		//$this->link = pg_connect("host=localhost user=postgres password=pi dbname=Pubbligraf");
		if($this->link === false){
			$this->error('Errore nella selezione del db del server PostgreSQL '.$this->src["server"].'\\<b>'.$this->src["dbname"].'</b>');
		}
		$this->is_connected = true;
	}
	
	public function disconnect(){
		pg_close($this->link);
		$this->is_connected = false;
	}
	
	public function get($iQry){
		$func = create_function('$key','if(!isset($key)){return("'.(str_replace('"','\\"',$this->opt["null"])).'");}else{return($key);}');
		$raw_data = pg_query($this->link,$iQry);
		if($row_data === false){
			$this->error('PostgreSQL Errore Query: '.pg_last_error()); 
		}
		$i = 0;
		$data = array();
		
		if($this->opt["associative"]){
			while($res = pg_fetch_assoc($raw_data)){
				$data[$i++] = array_map($func,$res);}
		}else{
			while($res = pg_fetch_row($raw_data)){
				
				$data[$i++] = array_map($func,$res);}
		}
		
		
		
		$this->opt['numrow'] = pg_num_rows($raw_data);
		pg_free_result($raw_data);
		return $data;
	}
	
	public function exec($iQry){
		$raw_data = pg_query($iQry);
		if($row_data === false){
			$this->error('PostgreSQL Errore Query: '.pg_last_error()); 
		}
		$this->opt['numrow'] = pg_affected_rows();//mysql_num_rows($raw_data);
	}
	
	public function __destruct(){
		if($this->is_connected===true){$this->disconnect();}
		parent::__destruct();
	}

	
}
?>
