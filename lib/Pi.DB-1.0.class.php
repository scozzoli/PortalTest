<?php
/**
 * Definizioni delle costanti (usate per recuperare le sottoclassi)
 */
$PHPversion = explode('.',PHP_VERSION);
//define('PM_DB_INI_FILE',				__DIR__.'/../../settings/db.ini');
define('PI_DB_CLASS_CONNECTION',			    'connection/Pi.Connection-1.0.class.php');

define('PI_DB_CLASS_CONNECTION_ORACLE',			'connection/php'.$PHPversion[0].'/Pi.Connection.Oracle-1.0.class.php');
define('PI_DB_CLASS_CONNECTION_OCI8',			'connection/php'.$PHPversion[0].'/Pi.Connection.OCI8-1.0.class.php');
define('PI_DB_CLASS_CONNECTION_MSSQL',			'connection/php'.$PHPversion[0].'/Pi.Connection.MSSQL-1.0.class.php');
define('PI_DB_CLASS_CONNECTION_ODBC',			'connection/php'.$PHPversion[0].'/Pi.Connection.ODBC-1.0.class.php');
define('PI_DB_CLASS_CONNECTION_SQLITE3',		'connection/php'.$PHPversion[0].'/Pi.Connection.SQLite3-1.0.class.php');
define('PI_DB_CLASS_CONNECTION_MYSQL',			'connection/php'.$PHPversion[0].'/Pi.Connection.MySQL-1.0.class.php');
define('PI_DB_CLASS_CONNECTION_PostgreSQL',		'connection/php'.$PHPversion[0].'/Pi.Connection.PostgreSQL-1.0.class.php');

define('PI_DB_CLASS_CONNECTION_DEF_ORACLE',			'connection/Pi.Connection.Oracle-1.0.class.php');
define('PI_DB_CLASS_CONNECTION_DEF_OCI8',			'connection/Pi.Connection.OCI8-1.0.class.php');
define('PI_DB_CLASS_CONNECTION_DEF_MSSQL',			'connection/Pi.Connection.MSSQL-1.0.class.php');
define('PI_DB_CLASS_CONNECTION_DEF_ODBC',			'connection/Pi.Connection.ODBC-1.0.class.php');
define('PI_DB_CLASS_CONNECTION_DEF_SQLITE3',		'connection/Pi.Connection.SQLite3-1.0.class.php');
define('PI_DB_CLASS_CONNECTION_DEF_MYSQL',			'connection/Pi.Connection.MySQL-1.0.class.php');
define('PI_DB_CLASS_CONNECTION_DEF_PostgreSQL',		'connection/Pi.Connection.PostgreSQL-1.0.class.php');

/**
 * Inclusioni delle Sotto Classi necessarie per la connessione
 */
 
include PI_DB_CLASS_CONNECTION;						// Indispensabile
//if(file_exists(PI_DB_CLASS_CONNECTION_ORACLE)){ include PI_DB_CLASS_CONNECTION_ORACLE; }else{ include PI_DB_CLASS_CONNECTION_DEF_ORACLE; }
if(file_exists(PI_DB_CLASS_CONNECTION_OCI8)){ include PI_DB_CLASS_CONNECTION_OCI8; }else{ include PI_DB_CLASS_CONNECTION_DEF_OCI8; }
if(file_exists(PI_DB_CLASS_CONNECTION_MSSQL)){ include PI_DB_CLASS_CONNECTION_MSSQL; }else{ include PI_DB_CLASS_CONNECTION_DEF_MSSQL; }
//if(file_exists(PI_DB_CLASS_CONNECTION_ODBC)){ include PI_DB_CLASS_CONNECTION_ODBC; }else{ include PI_DB_CLASS_CONNECTION_DEF_ODBC; }
if(file_exists(PI_DB_CLASS_CONNECTION_SQLITE3)){ include PI_DB_CLASS_CONNECTION_SQLITE3; }else{ include PI_DB_CLASS_CONNECTION_DEF_SQLITE3; }
if(file_exists(PI_DB_CLASS_CONNECTION_MYSQL)){ include PI_DB_CLASS_CONNECTION_MYSQL; }else{ include PI_DB_CLASS_CONNECTION_DEF_MYSQL; }
if(file_exists(PI_DB_CLASS_CONNECTION_PostgreSQL)){ include PI_DB_CLASS_CONNECTION_PostgreSQL; }else{ include PI_DB_CLASS_CONNECTION_DEF_PostgreSQL; }

/**
 * Classe vera e propria utilizzata per la connessione alle basi di dati
 */

class PiDB{
	private $db;
	private $src;
	
	/**
	 * Costruttore della classe
	 * @param string $iDbSource Connessione al DB nel formato PmDB
	 */
	public function __construct($iDbSource){
		$this->src = $iDbSource;
		switch(strtoupper($this->src['DB'])){
			case "ORACLE"	: $this->db = new PiConnectionOracle($this->src,false);		break;
			case "OCI8"		: $this->db = new PiConnectionOCI8($this->src,false);		break;
			case "MSSQL"	: $this->db = new PiConnectionMSSQL($this->src,false);		break;
			case "ODBC"		: $this->db = new PiConnectionODBC($this->src,false);		break;
			case "SQLITE3"	: $this->db = new PiConnectionSQLite3($this->src,false);	break;
			case "MYSQL"	: $this->db = new PiConnectionMySQL($this->src,false);		break;
			case "POSTGRESQL": $this->db = new PiConnectionPostgreSQL($this->src,false);		break;
			default : 
				die('Portal 1 DB : Tipo base dati non supportata ('.$this->src['DB'].')');	
			break;
		}
		return $this;
	}

	
	/**
	 * Cambio delle credenziali per la connessione al db
	 * In futuro questa funzione deve diventare automatica in corrispondenza
	 * dei parametri "userid = 1" e "userpwd = 1" (basta passare la sessione)
	 * @param string $in_dbuser Nome utente
	 * @param string $in_dbpwd Password utente
	 * @return PmDB
	 */
	public function grant($iDbUser,$iDbPassword){
		$this->db->grant($iDbUser,$iDbPassword);
		return($this);
	}
	
	/**
	 * Impostazione dei parametri (vedi PI_Connection)
	 * associative		->		true/false 		true
	 * null				->		string			' --- '
	 * lowercase		->		true/false		false (only oci8)
	 * @param string $Key Nome dell'opzione da reimpostare
	 * @param string $Val [opzionale] Valore da reimpostare
	 * @return PmDB
	 * @return string
	 */
	public function opt(){ //$iKey,$iVal
		if (func_num_args() == 1) { 
			// Getter
			return $this->db->get_opt(func_get_arg(0));
		} elseif(func_num_args() == 2) { 
			// setter
			$this->db->set_opt(func_get_arg(0),func_get_arg(1));
			return($this);
		} else { 
			// Numero di Parametri errato
			die("Portal 1 DB : Numero di parametri errato in opt");
		}
		
	}
	
	/**
	 * Recupero della matrice di dati dal DB
	 * @param string $iQry Query da elaborare
	 * @param boolean $iDisconnect Disconnettere dal DB alla fine
	 * @return mixed
	 */
	public function get($iQry,$iDisconnect = false){
		if(!$this->db->connected()){$this->db->connect();}
		$data = $this->db->get($iQry);
		if($iDisconnect){$this->db->disconnect();}
		return $data;
	}
	/**
	 * Invio dati al DB (nessuna richiesta di output)
	 * Qualunque errore viene stampato nello standar output
	 * @param string $in_qry Query da elaborare
	 * @param boolean $disconnect Disconnettere dal DB alla fine
	 * @return mixed
	 */
	public function exec($iQry,$iDisconnect = false){
		if(!$this->db->connected()){$this->db->connect();}
		$data = $this->db->exec($iQry);
		if($iDisconnect){$this->db->disconnect();}
		return $this;
	}
	
	/**
	 * Controlla se il database è aperto
	 * @return boolean
	 */
	public function isOpen(){
		return $this->db->connected();
	}
	
	/**
	 * Chiude la connessione con il DB
	 * @return PmDB
	 */
	public function close(){
		if($this->db->connected()){$this->db->disconnect();}
		return $this;
	}
	public function __destruct(){
		if($this->db->connected()){$this->db->disconnect();}
	}
}
?>
