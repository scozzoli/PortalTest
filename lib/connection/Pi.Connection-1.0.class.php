<?php
/**
 * Classe Astratta per la gestione delle connessioni
 */
abstract class PiConnection{
	protected $link;
	protected $is_connected = false;
	protected $src;
	protected $pr;
	protected $opt = array(
		'associative' 	=> true,	// Crea una Matrice associativa
		'null'			=> ' --- ', // Al posto di 'null'
		'lowercase'		=> true,	// Esegue un lowercase delel intestazioni (solo oci8 per ora)
		'numrow'		=> false, 	// numero di righe su cui ha avuto effetto l'operazione (solo oci8 per ora)
		'utf8'			=> false,	// Decodifica in utf8 i dati del DB
		'catchErros'	=> false	// Indica se deve lanciare un'eccezione su errore o uscire con un die() o  pr->error()
		//'arrayindex'	=> false,	// [DEPRECATO] Crea un Array assoviatvo ed una matrice numerica $d[<0>][<0>] $d['rid']['id'] = <0>
		//'rowindex' 	=> true,	// [DEPRECATO] crea una voce con il numero di righe $d["row"] = <0>
		//'reverse'		=> false,   // [DEPRECATO] inverte righe con colonne [da implementare]
	);

	public function __construct($iDbSource,$iResponse = false){
		$this->src = $iDbSource;
		$this->pr = $iResponse;
	}
	
	public function connected(){
		return $this->is_connected;
	}	

	public function set_opt($iKey,$iVal){
		if(!array_key_exists($iKey,$this->opt)){
			die("Portal 1 Connection : L'opzione '{$iKey}' non esiste!");
		}
		$this->opt[$iKey] = $iVal;
	}
	public function get_opt($iKey){
		if(!array_key_exists($iKey,$this->opt)){
			return null;
		}else{
			return $this->opt[$iKey];
		}
	}
	public function grant($iDbUser,$iDbPassword){
		$this->src['dbuser'] = $iDbUser;
		$this->src['dbpwd'] = $iDbPassword;
	}
	
	protected function error($iMsg){
		if($this->opt['catchErros']){
			if($this->pr){
				$this->pr->error('Portal 1 <i>Connection</i> : '.$iMsg);
			}else{
				die('Portal 1 Connection : '.$iMsg);
			}
		}else{
			throw new Exception('Portal 1 Connection : '.$iMsg);
		}
	}
	
	protected function getParseFunction(){
		if($this->opt['utf8']){
			return create_function('$key','if(!isset($key)){return("'.(str_replace('"','\\"',$this->opt["null"])).'");}else{return(utf8_encode($key));}');
		}else{
			return create_function('$key','if(!isset($key)){return("'.(str_replace('"','\\"',$this->opt["null"])).'");}else{return($key);}');
		}
	}
	
	public abstract function connect();
	public abstract function disconnect();
	public abstract function get($iQry);
	public abstract function exec($iQry);
	public function __destruct(){}
}
?>
