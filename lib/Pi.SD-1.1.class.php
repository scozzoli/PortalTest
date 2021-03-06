<?php
define('PI_SD_TAG',				'./lib/Pi.Tag-1.0.class.php');
define('PI_SD_SYSTEM',			'./lib/Pi.System.php');

include PI_SD_TAG;
include PI_SD_SYSTEM;
class PiSD{
	private $menu;
	private $tags;
	private $opt;
	private $modules;
	private $users;
	private $i18n;
	//private $moduleLoad;
	//private $db;
	private $inited;
	private $sysConfig;
	public $usr;

	public function __construct(){
		$this->opt = array(
				"theme"		=> "material",
				"style"		=> "blue",
				"title"		=> false, //"Portal 1 Verione 1.0",
				"subtitle"	=> "Strumenti Aggiuntivi per la Gestione dell'Informazione",
				"ico"		=> "",
				"ico-type"	=> "image/png",
				"charset"	=> "UTF-8",//"ISO-8859-1",
				"BaseURL"	=> "http://",
				"BasePage"	=> "index.php",
				"MID"		=> false,//"SYS_Login", //Strumento di default
				"GID"		=> false,//Gruppo menu di default
				"MSID"		=> "PI_MAIN_SESSION_ID", // Nome della variabile di sessione di principale
				"logo"		=> "mdi-camera-iris",
				"logoFont"	=> "mdi",
				"i18n"		=> false // indica se i nomi di sistema siano gestiti con i18n lato client (OLD),
		);

		$this->sysConfig = new PiSystem('./settings/');

		$this->menu = false;
		$this->tags = array();
		$this->modules = false;
		$this->users = false;
		$this->inited = false;
		$this->i18n = false;
	}
	public function set($iKey,$iVal){
		if(!array_key_exists($iKey,$this->opt)){
			die("Portal 1 SD : L'opzione '{$iKey}' non esiste!");
		}
		$this->opt[$iKey] = $iVal;
		return $this;
	}
	public function get($iKey){
		if(!array_key_exists($iKey,$this->opt)){
			return false;
		}else{
			return $this->opt[$iKey];
		}
	}
	/**
	 * Include una libreria esterna (JQery ecc....)
	 */
	public function includeLib($iSrc){
		$index_now = count($this->tags);
		$this->tags[] = new PiTAG('script');
		$this->tags[$index_now]->set('language','javascript');
		$this->tags[$index_now]->set('src',$iSrc);
		return $this;
	}

	/**
	 * Esegue uno script all'avvio
	 */
	public function includeScript($iSrc){
		$index_now = count($this->tags);
		$this->tags[] = new PiTAG('script');
		$this->tags[$index_now]->set('language','javascript');
		$this->tags[$index_now]->content($iSrc,false);
		$this->tags[$index_now]->cdata(false);

		return $this;
	}
	/**
	 * Funzione che esegue tutte le procedure necessarie per inizializzare l'utente
	 */
	public function initSession($iUsr,$iAutologin = false){

		$usr = $this->sysConfig->loadUsr();

		if(!isset($usr[$iUsr])){
			$this->menu = false;
			return false;
		}

		if($iAutologin && $usr[$iUsr]['use_pwd']){
			return false;
		}

		$this->i18n = $this->sysConfig->loadI18n();
		$grp = $this->sysConfig->loadGrp();
		$mod = $this->sysConfig->loadMod();
		$allMenus = $this->sysConfig->loadMenu();
		$menu = $allMenus[$usr[$iUsr]["menu"]];

		ksort($menu);

		$this->opt["theme"] = $usr[$iUsr]["theme"];
		$this->opt["style"] = $usr[$iUsr]["style"];

		$this->modules = $mod;
		$this->usr = $usr[$iUsr];

		$out = array();

		foreach($menu as $k => $v){

			$tmpList = array();
			$chkList = array();

			if(isset($v["list"])){
				foreach($v["list"] as $kmod => $lMod){
					if(!isset($mod[$lMod])){ continue; }
					$tmp = $mod[$lMod];
					$LPU = $usr[$iUsr]["grp"][$tmp["grp"]] ?: $usr[$iUsr]["grpdef"];
					if($LPU == 0){ continue; }
					if($usr[$iUsr]['acc_dev']=="0" && $tmp['stato']=='DEV'){ continue; }
					if($usr[$iUsr]['acc_err']=="0" && $tmp['stato']=='ERR'){ continue; }
					if($usr[$iUsr]['acc_dis']=="0" && $tmp['stato']=='DIS'){ continue; }
					if($usr[$iUsr]['acc_priv']=="0" && $tmp['stato']=='PRIV'){ continue; }
					$tmp["id"] = $lMod;
					$tmp["grantuse"] = true; //--> Non dovrebbe servire
					$tmpList[] = $tmp;
					$chkList[$lMod] = true;
				}
			}

			$out[$k] = array(
				"des"	=>  $v["des"],
				"list"	=> $tmpList,
				"chklist" => $chkList,
				"hidden" => $v['hidden']
			);
		}

		$this->menu = $out;
		$this->inited = true;

		$dblist = $this->sysConfig->loadDB();

		if(!isset($_SESSION[MSID])){
			$_SESSION[MSID] = Array();
		}

		$_SESSION[MSID]['usr'] = $iUsr;
		$_SESSION[MSID]['config'] = $usr[$iUsr];
		$_SESSION[MSID]['db'] = $dblist;

		return true;
	}

	/**
	 * Funzione per selezionare il modulo da caricare (e/o la sessione da visualizzare)
	 */
	public function select($iGID,$iMID){

		// Controllo che esista l'id del menù passato come parametro ... se no seleziono il primo disponibile
		if($iGID && isset($this->menu[$iGID]) && ($this->menu[$iGID]['hidden'] ?: 0 == 0)){
			$this->opt['GID'] = $iGID;
		}else{
			reset($this->menu);
			$this->opt['GID'] = key($this->menu);
		}

		// Controllo che il moduolo passato sia presente nel menù
		$this->opt['MID'] = false;
		if($iMID){
			if(array_key_exists($iMID, $this->menu[$this->opt['GID']]['chklist'])){
				$this->opt['MID'] = $iMID;
			}else{
				// Nel caso il modulo non sia nel gruppo specificato allora lo cerco negli altri... altrimenti lo lascio vuoto
				foreach($this->menu as $groupID => $group){
					if(array_key_exists($iMID, $group['chklist'])){
						$this->opt['GID'] = $groupID;
						$this->opt['MID'] = $iMID;
						break;
					}
				}
			}
		}

	}

	public function getModulePath(){
		if($this->opt['GID'] === false || $this->opt['MID'] === false ){
			return false;
		}else{
			return './modules/'.$this->modules[$this->opt['MID']]['path'];
		}
	}

	public function getModule($iMID){
		if (isset($this->mod[$iMID])){
			return $this->mod[$iMID];
		}else{
			return false;
		}
	}

	/// Metodi Privati

	private function getModuleIcon($iMID){
		return('mdi '.$this->modules[$iMID]['icon']);
	}

	private function getString($iStr,$iScope){
		if($this->opt['i18n']){
			if($iStr){
				if($iScope == 'menu'){
					return '<i18n scope="sys">menu:'.$this->usr['menu'].':'.$iStr.'</i18n>';
				}else{
					return '<i18n scope="sys">'.$iScope.':'.$iStr.'</i18n>';
				}
			}else{
				return false;
			}
		}else{
			switch($iScope){
				case 'mod':  return htmlentities($this->getLangString($this->modules[$iStr]['nome']));
				case 'des':  return htmlentities($this->getLangString($this->modules[$iStr]['des']));
				case 'menu': return htmlentities($this->getLangString($this->menu[$iStr]["des"]));
			}
		}
	}

	private function getLangString($iCfg){
		$tr = $iCfg[$this->usr['lang']] ?: '';
		if(trim($tr) == ''){
			$tr = $iCfg[$this->i18n['defaultLang']] ?: '';
		}
		return $tr;
	}
	/// Metodi pubblici di output

	public function renderList(){
		$out = '<div class="pi-list">';
		foreach($this->menu[$this->opt['GID']]['list'] as $k => $v){
			$link = $this->opt["BaseURL"].$this->opt["BasePage"].'?GID='.$this->opt['GID'].'&MID='.$v["id"];

			$out .= '<a class="pi-mod pi-state-'.strtolower($v['stato']).'" href="'.$link.'">';
			$out .= '<div class="pi-icon"><i class="'.$this->getModuleIcon($v['id']).'"></i></div>';
			$out .= '<div class="pi-name">'.$this->getString($v['id'],'mod').'</div>';
			$out .= '<div class="pi-descr">'.$this->getString($v['id'],'des').'</div>';
			$out .= '</a>';
		}
		$out.='</div>';
		return $out;
	}

	public function getCalendarStyle(){
		if( $this->usr['events'] == 1){
			$events = json_decode(file_get_contents('./style/events.json'),true);
			$today = explode('-',date('Y-m-d'));
			$Y = intval($today[0]);
			$M = intval($today[1]);
			$D = intval($today[2]);
			$def = '';
			/// Recupero il default generale
			if(isset($events['default'])){
				$def = $events['default']['default'] ?: '';
				if(isset($events['default'][$M])){
					$def = $events['default'][$M][$D] ?: ( $events['default'][$M]['default'] ?: $def );
				}
			}
			/// Recupero il valore specifico del giorno (oppure rilascio il default)
			if(isset($events[$Y])){
				$def = $events[$Y]['default'] ?: $def;
				if(isset($events[$Y][$M])){
					$def = $events[$Y][$M][$D] ?: ( $events[$Y][$M]['default'] ?: $def );
				}
			}
		}else{
			$def = '';
		}
		
		return $def;
	}

	public function render($iContent = ""){
		$mod = $this->modules[$this->opt['MID']];
		$sidemenu = $this->usr['showsidemenu'] == 0 ? 'pi-hide-menu' : '';

		$title = $this->opt["title"] ?: $this->getString($this->opt['MID'],'mod'); // $mod['nome'];
		$title = $title ?: $this->getString($this->opt['GID'],'menu'); //$this->menu[$this->opt["GID"]]["des"];
		$crlf = "\n";
		$out = '<!DOCTYPE html>';
		$out.= $crlf.'<html><head><title>'.str_replace(Array('<i18n scope="sys">','</i18n>'),Array('',''),$title).'</title>';
		$out.= $crlf.'<meta http-equiv="Content-Type" content="text/html" charset="'.$this->opt["charset"].'" />';
		$out.= $crlf.'<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=0.5, maximum-scale=2">';
		if($mod){
			$out.= '<LINK rel="icon" href="./style/favicon.php?img='.$mod['icon'].'" type="image/png" />';
		}elseif($this->opt["ico"] != ""){
			$out.= '<LINK rel="icon" href="./style/favicon.php" type="image/png" />';
		}
		$out.= $crlf.'<link href="./style/common.php" rel="stylesheet" type="text/css" />';
		$out.= $crlf.'<link href="./style/theme.php?theme='.$this->opt["theme"].'&style='.$this->opt["style"].'" rel="stylesheet" type="text/css" />';
		for($i=0; $i!=count($this->tags);$i++){ $out.=$crlf.$this->tags[$i]->render(); }
		$out.= $crlf.'</head>';
		$out.= $crlf.'<body class="pi-body '.$this->getCalendarStyle().'">';
		$out.= $crlf.'	<div class="pi-modal pi-win hide"><div class="pi-modal-content hide"></div></div>';
		$out.= $crlf.'	<div class="pi-modal pi-message hide"><div class="pi-modal-content hide"></div></div>';
		$out.= $crlf.'	<div class="pi-modal pi-loader hide"><div class="pi-modal-content hide"></div></div>';
		$out.= $crlf.'	<div class="pi-wrapper">';
		$out.= $crlf.'		<div class="pi-top">';
		$out.= $crlf.'			<div class="pi-logout" onclick="window.location=\'./logout.php\'">';
		$out.= $crlf.'				<div class="pi-user">'.$this->usr["nome"].' <i class="mdi mdi-logout"></i> </div>';
		$out.= $crlf.'			</div>';
		if($this->opt['logoFont']){ //nel caso mi si passi un logo in formato immagine
			$out.= $crlf.'			<div class="pi-logo"><i class="'.$this->opt['logoFont'].' '.$this->opt['logo'].'"></i></div>';
		}else{ //nel caso mi si passi un logo nel formato webfont
			$out.= $crlf.'			<div class="pi-logo"><img src="'.$this->opt['logo'].'"></div>';
		}
		$out.= $crlf.'			<div class="pi-title">'.($mod ? $this->getString($this->opt['MID'],'mod') : $title).'</div>';
		$out.= $crlf.'			<div class="pi-descr">'.($mod ? $this->getString($this->opt['MID'],'des') : $this->opt["subtitle"]).'</div>';
		$out.= $crlf.'			<div class="pi-menu">';
		$out.= $crlf.'				<ul>';
		foreach($this->menu as $k => $v){
			if($v['hidden'] ?: 0 == 1){ continue; }
			$style = $k == $this->opt['GID'] ? 'pi-selected' : '';
			$out.= $crlf.'					<li class="'.$style.'">';
			$out.= $crlf.'						<a href="./index.php?GID='.$k.'">'.$this->getString($k,'menu').'</a>';
			$out.= $crlf.'						<ul>';
			foreach($v['list'] as $idx => $voice){
				$link = $this->opt["BaseURL"].$this->opt["BasePage"].'?GID='.$k.'&MID='.$voice['id'];
				$out.= $crlf.'							<li class="pi-voice">';
				$out.= $crlf.'								<a href="'.$link.'">';
				$out.= $crlf.'									<i class="'.$this->getModuleIcon($voice['id']).'"> </i>';
				$out.= $crlf.'									<div class="pi-title">'.$this->getString($voice['id'],'mod').'</div>';
				//$out.= $crlf.'									<div class="pi-descr">'.htmlentities($voice['des']).'</div>';
				$out.= $crlf.'								</a>';
				$out.= $crlf.'							</li>';
			}
			$out.= $crlf.'						</ul>';
			$out.= $crlf.'					</li>';
		}
		$out.= $crlf.'				</ul>';
		$out.= $crlf.'			</div>';
		$out.= $crlf.'		</div>';
		$out.= $crlf.'	<div class="pi-body '.$sidemenu.'">';
		$out.= $crlf.'		<div class="pi-side-menu">';
		$out.= $crlf.'			<ul>';
		foreach($this->menu[$this->opt['GID']]['list'] as $idx => $voice){
			$style = $voice['id'] == $this->opt['MID'] ? 'pi-selected' : '';
			$link = $this->opt["BaseURL"].$this->opt["BasePage"].'?GID='.$this->opt['GID'].'&MID='.$voice['id'];
			$out.= $crlf.'				<a href="'.$link.'">';
			$out.= $crlf.'					<li class="'.$style.'">';
			$out.= $crlf.'						<div class="pi-icon"> <i class="'.$this->getModuleIcon($voice['id']).'"> </i> </div>';
			$out.= $crlf.'						<div class="pi-title"> '.$this->getString($voice['id'],'mod').' </div>';
			$out.= $crlf.'						<div class="pi-descr"> '.$this->getString($voice['id'],'des').' </div>';
			$out.= $crlf.'					</li>';
			$out.= $crlf.'				</a>';
		}
		$out.= $crlf.'			</ul>';
		$out.= $crlf.'		</div>';
		$out.= $crlf.'		<span id="Pi_Mod_Vars">';

		//$out.= $crlf.'			<input type="hidden" name="root" value="'.str_repeat('../',substr_count($mod['path'],'/')+1).'">';
		$out.= $crlf.'			<input type="hidden" name="MSID" value="'.$this->opt['MSID'].'">';
		$out.= $crlf.'			<input type="hidden" name="SID" value="PI_MOD_'.($this->opt['MID'] ?: 'null').'">';
		$out.= $crlf.'			<input type="hidden" name="module" value="'.($mod ? $mod['path'] : '' ).'">';

		$out.= $crlf.'		</span>';
		$out.= $crlf.'		<div class="pi-content">'.$iContent.'</div>';
		$out.= $crlf.'	</div>';
		$out.= $crlf.'	</div>';
		$out.= $crlf.'</body>';
		$out.= $crlf.'</html>';

		return $out;

	}
	public function __destruct(){}
}
?>
