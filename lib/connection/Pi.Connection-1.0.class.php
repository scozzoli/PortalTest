<?
/**
 * Classe Astratta per la gestione delle connessioni
 */
abstract class PiConnection{
	protected $link;
	protected $is_connected = false;
	protected $src;
	protected $opt = array(
		'associative' 	=> true,	// Crea una Matrice associativa
		'null'			=> ' --- ', // Al posto di 'null'
		'lowercase'		=> false,	// Esegue un lowercase delel intestazioni (solo oci8 per ora)
		'numrow'		=> false 	// numero di righe su cui ha avuto effetto l'operazione (solo oci8 per ora)
		//'arrayindex'	=> false,	// [DEPRECATO] Crea un Array assoviatvo ed una matrice numerica $d[<0>][<0>] $d['rid']['id'] = <0>
		//'rowindex' 		=> true,	// [DEPRECATO] crea una voce con il numero di righe $d["row"] = <0>
		//'reverse'		=> false,   // [DEPRECATO] inverte righe con colonne [da implementare]
	);

	public function __construct($iDbSource,$in_connect = false){
		$this->src = $iDbSource;
		if($in_connect){
			$this->connect();
		}
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
	public abstract function connect();
	public abstract function disconnect();
	public abstract function get($iQry);
	public abstract function exec($iQry);
	public function __destruct(){}
}
?>
