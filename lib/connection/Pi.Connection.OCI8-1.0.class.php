<?
/**
 * Estensione di Connection per Oracle (driver nuovi... quasi)
 */
class PiConnectionOCI8 extends PiConnection{
	protected $cur;
	
	public function connect(){
		$this->link = oci_connect($this->src["dbuser"],$this->src["dbpwd"],$this->src["server"],$this->src['lang']) or $this->error('Errore nella connessione al server OCI8 : '.$this->src["server"]);
		$this->is_connected = true;
	}
	
	public function disconnect(){
		oci_close($this->link);
		$this->is_connected = false;
	}
	
	public function get($iQry){
		$this->opt['numrow'] = false;
		$this->cur = oci_parse($this->link,$iQry);
		oci_execute($this->cur);
		$n_col = oci_num_fields($this->cur);
		$row = 0;
		$flag = OCI_RETURN_NULLS + ($this->opt["associative"] ? OCI_ASSOC : OCI_NUM);
		$data = array();
		while($res = oci_fetch_array($this->cur,$flag)){
			foreach($res as $k => $v){
				if($this->opt["associative"] && $this->opt["lowercase"]){
					$data[$row][strtolower($k)] = ($v === null ?  $this->opt["null"] : $v);
				}else{
					$data[$row][$k] = ($v === null ?  $this->opt["null"] : $v);
				}
			}
			$row++;
		}
		$this->opt['numrow'] = oci_num_rows($this->cur);
		oci_free_statement($this->cur);
		return $data;
	}
	
	public function exec($iQry){
		$this->opt['numrow'] = false;
		$this->cur = oci_parse($this->link,$iQry);
		oci_execute($this->cur);
		$this->opt['numrow'] = oci_num_rows($this->cur);
		oci_free_statement($this->cur);
	}
	
	public function __destruct(){
		if($this->is_connected===true){$this->disconnect();}
		parent::__destruct();
	}
}
?>
