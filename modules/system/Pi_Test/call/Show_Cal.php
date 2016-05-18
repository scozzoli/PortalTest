<?php



	$out='
					
	<div class="panel" data-pic="calendar : { year:2016, month:5, maxEvents: 3, request : { Q : \'Win_Show_All_Day\', Uffa : \'ciao\' } }">
		<div data-event="start : \'2016-05-18\', icon:\'mdi-check\'"> Test di evento </div>
		<div data-event="start : \'2016-05-18\'"> Test di evento 2</div>
		<div data-event="start : \'2016-05-18\'"> Test di evento 4</div>
		<div data-event="start : \'2016-05-18\'"> Test di evento 3</div>
		<div data-event="start : \'2016-5-18\'"> Test di evento 5</div>
		<div data-event="start : \'2016-5-18\'"> Test di evento 6</div>
		<div data-event="start : \'2016-05-20\', class:\'green\' " > Fuffole</div>
		<div data-event="start : \'2016-05-21\'"> Fuffole</div>
		<div data-event="start : \'2016-04-26\'"> Fuffole</div>
		<div data-event="start : \'2016-06-01\'"> Fuffole dopo</div>
	</div>
	
	<div class="panel" data-pic="calendar : { year:2016, month:12, request : { Q : \'Win_Show_All_Day\' } }">
		<div data-event="start : \'2016-12-10\'"> Primo evento </div>
		<div data-event="start : \'2016-11-29\'"> prima </div>
		<div data-event="start : \'2017-01-01\'"> dopo </div>
	</div>
	';
	
	//$out = '<div class="panel">
	//	<table class="form">
	//		<tr>';
	//for($i = 1; $i< 13; $i++){
	//	if(($i % 2) == 1){
	//		$out .= '</tr><tr>';
	//	}
	//	$out .= '<td><div data-pic="calendar : { year:2016, month:'.$i.', maxEvents: 3, request : { Q : \'Win_Show_All_Day\', Uffa : \'ciao\' } }"></div></td>';
	//}
	//$out .='</tr></table></div>';

	$pr->addHtml('container',$out)->response();

?>
