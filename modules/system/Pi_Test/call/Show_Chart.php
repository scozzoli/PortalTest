<?php

	$bar = Array(
		"type" => "bar",
		"lables" => Array("Primo","Secondo","Terzo","Quarto","Quinto"),
		"data" => Array(
			"Serie1" => Array(
				"color" => "blue",
				"data" => Array(1,1,1,1,5)
			),
			"Serie2" => Array(
				"color" => "red",
				"data" => Array(4,1,3,3,8)
			),
		),
	);
	//, height: \'600px\', width:\'200px\' <div data-labels="separator : \'!!\'"> Primo!!Secondo!!Terzo!!Quarto!!Quinto </div>
	$out = '
	<div class="panel">
		<div data-pic="gantt : {legendSize : 300}">
			<c-line title="prova di titolo">
				<c-title><b>Prova</b> di titlo</c-title>
				<c-task id="01" start="2017-03-01" end="2017-03-15"> Ciao bello lkh fiowh viuhv ipuh vipuhvq piuh fquiv hevuipr </c-task>
			</c-line>
			<c-line>
				<c-task id="02" start="2017-03-5" end="2017-04-05" class="blue"> Altro </c-task>
				<c-task id="03" start="2017-03-8" end="2017-04-05" class="red"> Altro </c-task>
			</c-line>
			<c-line>
				<c-task id="04" start="2017-03-20" end="2017-04-01" class="purple"> Altro </c-task>
			</c-line>
			<c-line onclick="alert(\'ciao\')">
				<c-title>Sequenza</c-title>
				<c-task id="xx" start="2017-03-21" class="green"> <b>Altro</b> </c-task>
				<c-task id="xx" start="2017-03-22" class="green"><span style="text-align:center"> 1 </span></c-task>
				<c-task id="xx" start="2017-03-23" class="green" onclick="pi.msg.info(\'ciao\')"> xx </c-task>
			</c-line>
		</div>
	</div>';

	$out .='<div class="panel"><div data-pic="gantt : {legendSize : 300}">';
	for($i = 0; $i < 100 ; $i ++){
		$out .= '<c-line  title="linea ti test '.$i.'">';
		$out .= '<c-title>Linea ti test <b>'.$i.'</b></c-title>';
		for($k = 0 ; $k< 5 ; $k++ ){
			$dataStart = mktime(0,0,0,date('n'),1+($k * 2),date('Y'));
			$dataEnd = mktime(0,0,0,date('n'),2+($k *2),date('Y'));
			$out.='<c-task start="'.date('Y-m-d',$dataStart).'" end="'.date('Y-m-d',$dataEnd).'" class="green"> '.$k.'</c-task>';
		}
		$out .= '</c-line>';
	}
	$out .='</div></div>';
	
	$out .='	
		<div data-pic="chart : { type : \'mixed\'}" style="width:30%; height:200px; float:left">
			<div data-labels="separator : \'!!\'"> Primo!!Secondo!!Terzo </div>
			<div data-chart=" type : \'bar\', data : { color : \'blue\', values : [1,2,3,4,5] } "> Serie 1 </div>
			<div data-chart=" type : \'bar\', data : { color : \'red\', values : [10,5,6,0,5] } "> Serie 2 </div>
			<div data-chart=" type : \'line\', data : { color : \'orange\', values : [10,5,6,0,5] } "> Serie 3 </div>
		</div>
		<div data-pic="chart : { type : \'line\'}" style="width:30%; height:200px; float:left">
			<div data-chart="data : { color : \'blue\', values : [1,2,3,4,5,15,-5,-3,6,9,12,15,16,20,5] } "> Serie 1 </div>
		</div>
		<div data-pic="chart : { type : \'area\'}" style="width:30%; height:200px; float:left">
			<div data-chart="data : { color : \'blue\', values : [1,2,3,4,5,15,-5,-3,6,9,12,15,16,20,5] } "> Serie 1 </div>
		</div>
		<div data-pic="chart : { type : \'bar\'}" style="width:30%; height:200px; float:left">
			<div data-chart="data : { color : \'purple\', values : [1,2,3,4,5,15,-5,-3,6,9,12,15,16,20,5] } "> Serie 1 </div>
		</div>
		<div data-pic="chart : { type : \'bar\'}" style="width:30%; height:200px; float:left">
			<div data-chart="data : { color : \'purple\', values : [1,2,3,4,5,15,-5,-3,6,9,12,15,16,20,5] } "> Serie 1 </div>
			<div data-chart="data : { color : \'orange\', values : [1,2,3,4,5,15] } "> Serie 2 </div>
			<div data-chart="data : { color : \'blue\', values : [null,4,5,15,-5,-3,6,9,12,15,16,20,5] } "> Seriona </div>
		</div>
		<div data-pic="chart : { type : \'pie\'}" style="width:30%; height:200px; float:left">
			<div data-chart="data : { color : \'purple\', values : [10,50,12,40] } "> Serie 1 </div>
		</div>
		<div data-pic="chart : { type : \'nut\'}" style="width:30%; height:200px; float:left">
			<div data-labels="separator : \'!!\'"> Primo!!Secondo!!Terzo!!OK </div>
			<div data-chart="data : { color : \'green\', values : [10,50,12,40] } "> Serie 1 </div>
		</div>
		<div data-pic="chart : { type : \'nut\'}" style="width:30%; height:200px; float:left">
			<div data-labels="separator : \'!!\'"> Primo!!Secondo!!Terzo!!OK </div>
			<div data-chart="data : { values : [10,50,12,40.55,4,15,5] } "> Serie 1 </div>
		</div>
		<div data-pic="chart : { type : \'polar\'}" style="width:30%; height:200px; float:left">
			<div data-labels="separator : \'!!\'"> Primo!!Secondo!!Terzo!!OK </div>
			<div data-chart="data : { color : \'green\', values : [15,50,32,40] } "> Serie 1 </div>
		</div>
		<div data-pic="chart : { type : \'radar\'}" style="width:30%; height:200px; float:left">
			<div data-labels="separator : \'!!\'"> Primo!!Secondo!!Terzo!!OK </div>
			<div data-chart="data : { color : \'purple\', values : [10,5,5,6] } "> Serie 1 </div>
			<div data-chart="data : { color : \'orange\', values : [1,4,2,4] } "> Serie 2 </div>
			<div data-chart="data : { color : \'blue\', values : [6,6,7,6] } "> Seriona </div>
		</div>';
	//$data = mktime(0,0,0,date('n'),1,date('Y'));
	
	$pr->addHtml('container',$out)->response();
?>
