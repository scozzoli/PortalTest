<?
class PiTAG{
	private $name;
	private $attr = array();
	private $content_value = '';
	private $use_cdata = false;

	public function __construct($in_tag_name){
		$this->name = strtoupper($in_tag_name);
	}
	
	public function set($in_arg,$in_val=null){
		if($in_val === null){
			if(isset($this->attr[strtolower($in_arg)])){
				unset($this->attr[strtolower($in_arg)]);
			}
		}else{
			$this->attr[strtolower($in_arg)] = $in_val;
		}
		return $this;
	}
	public function get($in_arg){
		if(!isset($this->attr[strtolower($_in_arg)])){
			return false;
		}else{
			return $this->attr[strtolower($_in_arg)];
		}
	}
	public function content($in_content,$in_html_encode = false){
		$this->content_value = $in_html_encode ? htmlentities(utf8_decode($in_content)) : utf8_decode($in_content);
		return $this;
	}
	public function cdata($in_use_cdata){
		$this->use_cdata = $in_use_cdata === true;
		return $this;
	}
	public function render(){
		$out = '<'.$this->name;
		$k = array_keys($this->attr);
		for($i = 0;$i<count($k);$i++){
			$out.=' '.$k[$i].' = "'.$this->attr[$k[$i]].'"';
		}
		$out .='>';
		if($this->use_cdata){
			$out.='<![CDATA['.$this->content_value.']]>';
		}else{
			$out.=$this->content_value;
		}
		$out .= '</'.$this->name.'>';
		return $out;
	}
	public function __destruct(){
		unset($this->name);
		unset($this->content);
		unset($this->attr);
	}
}
?>
