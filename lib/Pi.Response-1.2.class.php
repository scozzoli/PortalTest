<?php
/**
 *  Classe per la generazione dell risposte Ajax
 */
 class PiFile{
   private $file;
   private $name;
   private $tmpName;
   private $error;
   public function __construct($iFileObj){
     $this->file = $iFileObj;
     $this->tmpName = false;
     $this->name = false;

     switch($iFileObj['error']){
       case UPLOAD_ERR_INI_SIZE : $this->error = 'File error: file troppo grande (php.ini)'; break;
       case UPLOAD_ERR_FORM_SIZE : $this->error = 'File error: file troppo grande (html form)'; break;
       case UPLOAD_ERR_PARTIAL : $this->error = 'File error: caricamento parziale'; break;
       case UPLOAD_ERR_NO_FILE : $this->error = 'File error: file non caricato'; break;
       case UPLOAD_ERR_NO_TMP_DIR : $this->error = 'File error: manca la directory temporanea'; break;
       case UPLOAD_ERR_CANT_WRITE : $this->error = 'File error: scrittura su disco impossibile'; break;
       case UPLOAD_ERR_EXTENSION : $this->error = 'File error: errore per estensione php'; break;
       default :
        $this->error = false;
        $this->tmpName = $iFileObj["tmp_name"];
        $this->name = $iFileObj["name"];
     }
   }

   public function name(){
     return $this->name;
   }

   public function printError($iPr = false){
     if($iPr && $this->error != false){
       $iPr->error($this->error);
     }
     return $this->error;
   }

   public function save($iPath,$iName = false){
     $name = $iName ?: $this->name;
     if($this->error == false){
       return move_uploaded_file($this->tmpName,"$iPath/$name");
     }else{
       return false;
     }
   }
 }

 class PiRespose{
	const HTML_INNER	=	'innerHTML';
	const HTML_APPEND	=	'append';
	const HTML_BEFORE	=	'appendBefore';

	const MSG_INFO		=	'info';
	const MSG_ALERT		=	'alert';
	const MSG_ERROR		=	'error';
	const MSG_BUG		=	'bug';

	const FILL_GETNAME	= 	'name';
	const FILL_GETID	= 	'id';

	const GET_STR_UPPER		=	1;
	const GET_STR_SQLSAFE 	= 	2;
	const GET_STR_EURO 		=	4;
	const GET_STR_NOASTERIX = 	8;

	const GET_NUM_INT		=	1;

	const GET_DATE_COBOL	=	1; // per ora non usate
	const GET_DATE_CSV		=	2; // per ora non usate

	private $opt;
	private $actions;
	private $actionsFill;
	private $actionsFinally;
	private $postPi;
	private $postCall;
	private $usr;
	private $db;
	private $config;
  private $fileList;

	public function __construct($post,$session){
		if(!isset($session)){$this->error('Sessione non presente o scaduta!');}
		if(!isset($post['pi'])){$this->error('Variabili d\'ambiente non presente (sistema)');}
		if(!isset($post['call'])){$this->error('Variabili d\'ambiente non presente (chiamata remota)');}

		//$this->postPi = json_decode(utf8_encode($post['pi']),true);
		//$this->postCall = json_decode(utf8_encode($post['call']),true);
		$this->postPi = json_decode($post['pi'],true);
		$this->postCall = json_decode($post['call'],true);

		$this->usr = $session[$this->postPi['MSID']]['usr'] ?: false;
		$this->config = $session[$this->postPi['MSID']]['config'] ?: false;
		$this->db = $session[$this->postPi['MSID']]['db'] ?: false;

		if(!isset($this->postCall['Q'])){$this->error('Nessuna operazione specificata!');}


		$this->opt = array(
				'CloseLoader'	=>	true,
				'CloseWin'		=>	true,
				'DoItBefore'	=>	false, //se impostato a true esegue CloseLoader e CloseWin PRIMA dei tag Action
				'CallBack'		=>  false, 	// Variabile di appoggio per la gestione delle chiamate multiple
				'NextCall'		=>  $this->postCall['Q'] ?: false, 	// Presa in considerazione solo CallBack == true
				'root'			=>  '../' //Path della root (usata da getLocalPath per avere il percorso corretto del modulo)
		);
		$this->actions = array();
		$this->actionsFill = array();
		$this->actionsFinally = array();
		$this->fileList = array();

		foreach ($_FILES ?: [] as $key => $value) {
		  if(strpos($key,'file_') == 0){
			$comp = explode('_',$key);
			if(!isset($this->fileList[$comp[1]])){
			  $this->fileList[$comp[1]] = array();
			}
			$this->fileList[$comp[1]][intval($comp[2])] = $value;
		  }
		}
	}

	public function post(){	//$iVar,$iDefault

		if(array_key_exists(func_get_arg(0),$this->postCall)){
			return $this->postCall[func_get_arg(0)];
		}else{
			if(func_num_args() == 1){
				$this->error("Portal 1 Response : Nessuna variabile ".func_get_arg(0)." definita in POST" );
			}else{
				return func_get_arg(1);
			}
		}

	}

	public function files($iName){
		return count($this->fileList[$iName] ?: []);
	}

	public function file($iName,$iFileId = 0){
		$file = new PiFile($this->fileList[$iName][$iFileId]);
		$file->printError($this);
		return $file;
	}

	public function getString($iVar,$iFlags = 0){
		$out = $this->post($iVar);
		$out = ($iFlags & PiRespose::GET_STR_EURO) ? iconv("UTF-8", "CP1252", $out) : utf8_decode($out);

		if($iFlags & PiRespose::GET_STR_UPPER){ $out = strtoupper($out);}

		if($iFlags & PiRespose::GET_STR_SQLSAFE){
			$out = str_replace("'","''",$out);
			if(!($iFlags & PiRespose::GET_STR_NOASTERIX)){$out = str_replace("*","%",$out);}
			$out = str_replace('€',chr(164),$out); // funziona solo se converto in CP1252
		}

		return $out;
	}

	public function getNumber($iVar,$iFlags = 0){
		$out = $this->post($iVar);
		$out = str_replace(',','.',$out);
		if($iFlags & PiRespose::GET_NUM_INT){ 
			$out = intval($out); 
		}else{
			$out = floatval($out); 
		}
		return $out;
	}

	public function getDate($iVar,$iDateFormat=0){
		$out = $this->post($iVar);
		$res = preg_match('/^(?:(?:31(\/|-|\.)(?:0?[13578]|1[02]))\1|(?:(?:29|30)(\/|-|\.)(?:0?[1,3-9]|1[0-2])\2))(?:(?:1[6-9]|[2-9]\d)?\d{2})$|^(?:29(\/|-|\.)0?2\3(?:(?:(?:1[6-9]|[2-9]\d)?(?:0[48]|[2468][048]|[13579][26])|(?:(?:16|[2468][048]|[3579][26])00))))$|^(?:0?[1-9]|1\d|2[0-8])(\/|-|\.)(?:(?:0?[1-9])|(?:1[0-2]))\4(?:(?:1[6-9]|[2-9]\d)?\d{2})$/',$out);
		if($res == 1){
			switch($iDateFormat){
				case PiRespose::GET_DATE_COBOL :
					$d = explode('/',$out);
					if(count($d)!=3){return(false);}
					return((strlen($d[2]) == 2 ? '20'.$d[2] : $d[2]).str_pad($d[1],2,'0',STR_PAD_LEFT).str_pad($d[0],2,'0',STR_PAD_LEFT));
				break;
				case PiRespose::GET_DATE_CSV :
					// TODO
				default:
					return $out;
			}
		}else{
			return false;
		}
	}

	public function system($iVar){
		if(array_key_exists($iVar,$this->postPi)){
			return $this->postPi[$iVar];
		}else{
			$this->error("Portal 1 Response : Nessuna variabile di sistema {$iVar} definita in POST" );
		}
	}

	public function getDB($iDB = false){
		if($iDB){
			if(array_key_exists($iDB,$this->db)){
				return $this->db[$iDB];
			}else{
				$this->error("Non esiste alcuna DB <b>{$iDB}</b> registrato nel sistema");
			}
		}else{
			return $this->db[$this->config['db']];
		}
	}

	public function getUsr($iVar = false){
		if($iVar){
			if(array_key_exists($iVar,$this->config)){
				return $this->config[$iVar];
			}else{
				$this->error("Non esiste alcuna opzione <b>{$iVar}</b> registrata per l'utente");
			}
		}else{
			return $this->usr;
		}
	}

	public function chkGrp($iGrp){
		if($this->usr == 'root'){ return true; }
		return (isset($this->config['grp'][$iGrp]) ? $this->config['grp'][$iGrp] : $this->config['grpdef']) == 1;
	}

	public function getLocalPath($iPath = ""){
		$sep = strpos($iPath,"/") === 0 ? "" : '/';
		return $this->opt['root'].'modules/'.$this->postPi['module'].$sep.$iPath;
	}

	public function getRootPath($iPath = ""){
		$path = strpos($iPath,"/") === 0 ? substr($iPath,1) : $iPath;
		return $this->opt['root'].$path;
	}

	public function set($iKey,$iVal){
		if(!array_key_exists($iKey,$this->opt)){
			die("Portal 1 Response : L'opzione '{$iKey}' non esiste!");
		}
		$this->opt[$iKey] = $iVal;
		return $this;
	}

	public function get($iVal){
		if(!array_key_exists($iVal,$this->opt)){
			return false;
		}else{
			return $this->opt[$iVal];
		}
	}

	public function addHtml($iObjId, $iContent, $iType=self::HTML_INNER){
		$this->actions[] = array(
				'type'		=>	'html',
				'position'	=> 	$iType,
				'obj'		=>	$iObjId,
				'content'	=>	$iContent
			);
		return $this;
	}

	public function addWindow($iWidth,$iHeight,$iHeader,$iContent,$iFooter,$iCloseButton = true){
		$this->actions[] = array(
				'type'		=>	'win',
				'header'	=> 	$iHeader,
				'width'		=>	$iWidth,
				'height'	=>	$iHeight ?: 0, // ALtezza 0 vuol dire altezza automatica
				'footer'	=>	$iFooter,
				'content'	=>	$iContent,
				'closeButton' =>  $iCloseButton
			);
		return $this;
	}

	public function addScript($iScript, $iFinally = false){
		if($iFinally){
			$this->actionsFinally[] = array(
					'type'		=>	'script',
					'src'		=>	$iScript
				);
		}else{
			$this->actions[] = array(
					'type'		=>	'script',
					'src'		=>	$iScript
				);
		}
		return $this;
	}

	public function addMsgBox($iFace,$iMsg,$iOnClose=null){
		if($iOnClose == null){
			$action = Array('title' => 'Ok');
		}elseif(is_array($iOnClose)){
			$action = $iOnClose;
		}else{
			$action = Array('title' => 'Ok','onClick'=>$iOnClose);
		}

		$this->actions[] = array(
				'type'		=>	'message',
				'msg'		=>	$iMsg,
				'face'		=>  $iFace,
				'actions'	=>	Array($action)
			);
		return $this;
	}

	public function addInfoBox($iMsg,$iOnClose=null){
		if($iOnClose == null){
			$action = Array('title' => 'Ok','style'=>'blue');
		}elseif(is_array($iOnClose)){
			$action = $iOnClose;
		}else{
			$action = Array('title' => 'Ok', 'onClick'=>$iOnClose, 'style'=>'blue');
		}

		return $this->addMsgBox(self::MSG_INFO,$iMsg,$iOnClose);
	}

	public function addAlertBox($iMsg,$iOnClose=null){
		if($iOnClose == null){
			$action = Array('title' => 'Ok','style'=>'orange');
		}elseif(is_array($iOnClose)){
			$action = $iOnClose;
		}else{
			$action = Array('title' => 'Ok', 'onClick'=>$iOnClose, 'style'=>'orange');
		}

		return $this->addMsgBox(self::MSG_ALERT,$iMsg,$iOnClose);
	}

	public function addErrorBox($iMsg,$iOnClose=null){
		if($iOnClose == null){
			$action = Array('title' => 'Ok','style'=>'red');
		}elseif(is_array($iOnClose)){
			$action = $iOnClose;
		}else{
			$action = Array('title' => 'Ok', 'onClick'=>$iOnClose, 'style'=>'red');
		}

		return $this->addMsgBox(self::MSG_ERROR,$iMsg,$iOnClose);
	}

	public function addDialog($iFace,$iMsg,$iActions){
		$this->actions[] = array(
				'type'		=>	'message',
				'msg'		=>	$iMsg,
				'face'		=>  $iFace,
				'actions'	=>	$iActions
			);
		return $this;
	}

	public function addOkCancelDialog($iMsg,$iActionOk,$iActionCancel=null){
		$actions = Array();

		if($iActionCancel == null){
			$actions[] = Array('title' => 'Cancel','style'=>'red');
		}else{
			$actions[] = Array('title' => 'Cancel', 'onClick'=>$iActionCancel, 'style'=>'red');
		}
		$actions[] = Array('title' => 'OK','style'=>'red', 'onClick'=>$iActionOk);

		return $this->addDialog(self::MSG_INFO, $iMsg, $actions);
	}

	public function addYesNoCancelDialog($iMsg,$iActionYes,$iActionNo,$iActionCancel=null){
		$actions = Array();

		$actions[] = Array('title' => 'Si', 'onClick'=>$iActionYes);
		$actions[] = Array('title' => 'No', 'onClick'=>$iActionNo);

		if($iActionCancel == null){
			$actions[] = Array('title' => 'Cancel');
		}else{
			$actions[] = Array('title' => 'Cancel', 'onClick'=>$iActionCancel);
		}

		return $this->addDialog(self::MSG_INFO, $iMsg, $actions);
	}

	public function addFill($iObjId,$iFill,$iTypeGet=self::FILL_GETNAME){
		$this->actionsFill[] = array(
				'type'		=>	'fill',
				'get'		=>	$iTypeGet,
				'items'		=>  $iFill,
				'obj'		=>	$iObjId,
			);
		return $this;
	}

	public function addParseComponent($iHtmlId){
		$this->actions[] = array(
				'type'		=>	'component',
				'id'		=>	$iHtmlId
			);
		return $this;
	}

	public function info($iMsg){
		$this->action = $this->actionsFill = $this->actionsFinally = [];
		$this->opt['CloseLoader'] = true;
		$this->opt['CloseWin'] = true;
		$this->opt['DoItBefore'] = false;

		$this->addInfoBox($iMsg);

		$this->response();
	}

	public function error($iMsg){
		$this->action = $this->actionsFill = $this->actionsFinally = [];
		$this->opt['CloseLoader'] = true;
		$this->opt['CloseWin'] = true;
		$this->opt['DoItBefore'] = false;

		$this->addErrorBox($iMsg);

		$this->response();
	}

	public function alert($iMsg){
		$this->action = $this->actionsFill = $this->actionsFinally = [];
		$this->opt['CloseLoader'] = true;
		$this->opt['CloseWin'] = true;
		$this->opt['DoItBefore'] = false;

		$this->addAlertBox($iMsg);

		$this->response();
	}

	public function next($iCall=false){
		$this->opt['CallBack'] = $iCall!== false;
		$this->opt['NextCall'] = $iCall;
		return $this;
	}

	public function nextCommon($iCommon,$iParams = null){
		if(file_exists($this->opt['root'].'/common/'.$iCommon.'.php')){
			foreach($iParams as $k => $v){
				$$k = $v;
			}
			include $this->opt['root'].'/common/'.$iCommon.'.php';
		}else{
			$this->error("nextCommon : <b>{$iCommon}</b> non esiste!");
		}
	}

	public function response($iNoOutput = false){
		$res['response'] = array(
			'CloseLoader' 	=> ($this->opt['CloseLoader']?'1':'0'),
			'CloseWin'		=> ($this->opt['CloseWin']?'1':'0'),
			'DoItBefore'	=> ($this->opt['DoItBefore']?'1':'0')
		);

		$res['actions'] = array_merge($this->actions,$this->actionsFill,$this->actionsFinally);
		//$res['actions'] = $this->array_map_recursive(utf8_encode,$this->actions); //--> nel caso ci siano delle incompatibilit� con le codifiche
		if($iNoOutput){
			return(json_encode($res));
		}else{
			header('Content-type: application/json');
			die(json_encode($res));
		}
	}

	public function responseRaw($iContent = ''){
		die($iContent);
	}

	private function array_map_recursive($fn, $arr) {
		$rarr = array();
		foreach ($arr as $k => $v) {
			$rarr[$k] = is_array($v)
				? $this->array_map_recursive($fn, $v)
				: $fn($v);
		}
		return $rarr;
	}

	public function __destruct(){}
}
?>
