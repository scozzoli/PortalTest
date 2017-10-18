<?php
	class PiPhone{
		private $number;
		private $format;
		private $prefix;
		private $special;
		private $naz_prefix;
		private $type;
		private $cellprefix;
		
		public function __construct(){
			$this->format = array(
					'std'		=>	'(<b>:P:</b>) :N2:',
					'int+'		=>	'+:I: (<b>:P:</b>) :N3:',
					'int0'		=>	'00:I: (<b>:P:</b>) :N3:'
			);
			$this->number = array(
				'number'	=>	0,
				'prefix'	=>	0,
				'iso'		=>	'IT',
				'inter'		=> 	'39'
			);
			$this->naz_prefix = array(
				'39'		=>	'IT',
				'33'		=>	'FR',
				'356'		=>	'MT',
				'1'			=>	'US',
				'44'		=>	'UK'
			);
			$this->prefix['IT'] = array('004191','010','011','0121','0122','0123','0124','0125','0131','0141','0142','0143','0144','015','0161','0163','0165','0166','0171','0172','0173','0174','0175','0182','0183','0184','0185','0187','019','02','030','031','0321','0322','0323','0324','0331','0332','0341','0342','0343','0344','0345','0346','035','0362','0363','0364','0365','0371','0372','0373','0374','0375','0376','0377','0381','0382','0383','0384','0385','0386','039','040','041','0421','0422','0423','0424','0425','0426','0427','0428','0429','0431','0432','0433','0434','0435','0436','0437','0438','0439','0442','0444','0445','045','0461','0462','0463','0464','0465','0471','0472','0473','0474','0481','049','050','051','0521','0522','0523','0524','0525','0532','0533','0534','0535','0536','0541','0542','0543','0544','0545','0546','0547','055','0564','0565','0566','0571','0572','0573','0574','0575','0577','0578','0583','0584','0585','0586','0587','0588','059','06','070','071','0721','0722','0731','0732','0733','0734','0735','0736','0737','0742','0743','0744','0746','075','0761','0763','0765','0766','0771','0773','0774','0775','0776','0781','0782','0783','0784','0785','0789','079','080','081','0823','0824','0825','0827','0828','0831','0832','0833','0835','0836','085','0861','0862','0863','0864','0865','0871','0872','0873','0874','0875','0881','0882','0883','0884','0885','089','090','091','0921','0922','0923','0924','0925','0931','0932','0933','0934','0935','0941','0942','095','0961','0962','0963','0964','0965','0966','0967','0968','0971','0972','0973','0974','0975','0976','0981','0982','0983','0984','0985','099');
			//$this->prefix['IT'] = array('04191','10','11','121','122','123','124','125','131','141','142','143','144','15','161','163','165','166','171','172','173','174','175','182','183','184','185','187','19','2','30','31','321','322','323','324','331','332','341','342','343','344','345','346','35','362','363','364','365','371','372','373','374','375','376','377','381','382','383','384','385','386','39','40','41','421','422','423','424','425','426','427','428','429','431','432','433','434','435','436','437','438','439','442','444','445','45','461','462','463','464','465','471','472','473','474','481','49','50','51','521','522','523','524','525','532','533','534','535','536','541','542','543','544','545','546','547','55','564','565','566','571','572','573','574','575','577','578','583','584','585','586','587','588','59','6','70','71','721','722','731','732','733','734','735','736','737','742','743','744','746','75','761','763','765','766','771','773','774','775','776','781','782','783','784','785','789','79','80','81','823','824','825','827','828','831','832','833','835','836','85','861','862','863','864','865','871','872','873','874','875','881','882','883','884','885','89','90','91','921','922','923','924','925','931','932','933','934','935','941','942','95','961','962','963','964','965','966','967','968','971','972','973','974','975','976','981','982','983','984','985','99');
			$this->prefix['FR'] = array('442','559','556','549','233','495','476','235','320','562','491','4','467','240','493','326','235','477','494','388','494','5','247','470','144','674','164','642');
			$this->prefix['MT'] = array('626','227');
			$this->prefix['US'] = array();
			$this->prefix['UK'] = array();
			$this->special['IT'] = array('800','899','892');
			$this->special['FR'] = array();
			$this->special['MT'] = array();
			$this->special['US'] = array();
			$this->special['UK'] = array();
			$this->cellprefix['IT'] = array('3');
			$this->cellprefix['FR'] = array('603','607','609','61','620','627','630','632','638','640','648','653','655','660','668','67','68','698','699');
			$this->cellprefix['MT'] = array();
			$this->cellprefix['US'] = array();
			$this->cellprefix['UK'] = array();
		}
		
		private function get_iso($naz_pref){
			$length = 3;
			while ($length > 0){
				if(isset($this->naz_prefix[substr($naz_pref,0,$length)])){
					$this->number['inter'] = substr($naz_pref,0,$length);
					$this->number['iso'] = $this->naz_prefix[substr($naz_pref,0,$length)];
					return $length;
				}
				$length--;
			}
			return 0;
		}
		
		public function set($in_number){
			$index = 0;
			$length = 6;
			$lengthcell = 6;
			$this->number['prefix'] = '';
			$this->number['inter'] = '39';
			$this->number['iso'] = 'IT';
			if(substr($in_number,$index,2) == '00'){
				$to_inc = $this->get_iso(substr($in_number,$index+2));
				if($to_inc > 0){
					$index += (2+$to_inc);
				}
			}
			// Controllo che sia un numero di cellulare
			
			if((substr($in_number,$index,1)=='3') && ($this->number['iso'] == 'IT')){
				$this->number['prefix'] = substr($in_number,$index,3);
				$this->number['number'] = substr($in_number,$index+3);
				//$this->number['perfix'] = 'CELLUARE';
				$this->type = 'cell';
			}else{
				$this->number['prefix'] = '';
				$this->number['number'] = substr($in_number,$index);
				while ($length > 0){
					if(array_search(substr($in_number,$index,$length),$this->special[$this->number['iso']]) !== false){
						$this->number['prefix'] = substr($in_number,$index,$length);
						$this->number['number'] = substr($in_number,$index+$length);
						$this->type = 'special';
						return $this;
					}elseif(array_search(substr($in_number,$index,$length),$this->prefix[$this->number['iso']]) !== false){
						$this->number['prefix'] = substr($in_number,$index,$length);
						$this->number['number'] = substr($in_number,$index+$length);
						$this->type = 'normal';
						return $this;
					}elseif(array_search(substr($in_number,$index,$length),$this->cellprefix[$this->number['iso']]) !== false){
						$this->number['prefix'] = substr($in_number,$index,$length);
						$this->number['number'] = substr($in_number,$index+$length);
						$this->type = 'cell';
						return $this;
					}
					$length--;
				}
			}
			return $this;
		}
		
		public function create_format($in_id, $in_format){
			$this->format[$in_id] = $in_format;
			return $this;
		}
		
		public function get($format){
			$out = $this->format[$format];
			$out = str_replace(':I:',$this->number['inter'],$out);
			$out = str_replace(':P:',$this->number['prefix'],$out);
			$n2 = $n3 = $n4 = '';
			$len = strlen($this->number['number']);
			for($i=0; $i<$len; $i++){
				if((($i%2) == 0) && ($i!=0) && ($i+2 <= $len)){ $n2 .= ' '; }
				if((($i%3) == 0) && ($i!=0) && ($i+3 <= $len)){ $n3 .= ' '; }
				if((($i%4) == 0) && ($i!=0) && ($i+4 <= $len)){ $n4 .= ' '; }
				$n2 .= $this->number['number'][$i];
				$n3 .= $this->number['number'][$i];
				$n4 .= $this->number['number'][$i];
			}
			$out = str_replace(':N:',$this->number['number'],$out);
			$out = str_replace(':N2:',$n2,$out);
			$out = str_replace(':N3:',$n3,$out);
			$out = str_replace(':N4:',$n4,$out);
			return($out);
		}
		
		public function type(){
			return $this->type;
		}
		public function __destruct(){}
	}
?>