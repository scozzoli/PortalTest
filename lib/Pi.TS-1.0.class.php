<?
class PiTS{

	private $s_array;
	private $s_elem = 0;

	public function reset(){
		$this->s_elem = 0;
		$this->s_array = NULL;
	}

	public function set($col,$reverse = false){
		$this->s_elem++;
		$this->s_array[$this->s_elem-1]=array("col" => $col, "ord" => ($reverse ? '>' : '<'));
	}
	
	public function sort($in_tab){
		$tab = $in_tab;
		if(isset($in_tab['row'])){unset($tab['row']);}
		$sf_corpo='return (0);';
		for($i=$this->s_elem;$i!=0;$i--){
			$p = is_string($this->s_array[$i-1]["col"]) ? '"' : '';
			$sf_corpo='if ($a['.$p.$this->s_array[$i-1]["col"].$p.']==$b['.$p.$this->s_array[$i-1]["col"].$p.'])
				{'.$sf_corpo.'}
				else
				{return(strtoupper($a['.$p.$this->s_array[$i-1]["col"].$p.']) '.$this->s_array[$i-1]["ord"].' strtoupper($b['.$p.$this->s_array[$i-1]["col"].$p.']) ? 1: -1);}';
		}
		$sort_f=create_function('$a,$b',$sf_corpo);
		usort($tab,$sort_f);
		if(isset($in_tab['row'])){$tab['row'] = $in_tab['row'];}
		return($tab);
	}
}

?>
