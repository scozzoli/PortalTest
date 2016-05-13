<?php

	$out='
					
	<div class="panel" data-pic="calendar : { year:2016, month:5, request : { Q : \'Win_Show_All_Day\' } }">
		<div data-event="start : \'2016-05-18\'"> Test di evento </div>
		<div data-event="start : \'2016-05-18\'"> Test di evento 2</div>
		<div data-event="start : \'2016-05-18\'"> Test di evento 3</div>
		<div data-event="start : \'2016-05-18\'"> Test di evento 4</div>
		<div data-event="start : \'2016-05-18\'"> Test di evento 5</div>
		<div data-event="start : \'2016-05-18\'"> Test di evento 6</div>
		<div data-event="start : \'2016-05-20\'"> Fuffole</div>
		<div data-event="start : \'2016-05-21\'"> Fuffole</div>
	</div>
	';


	$pr->addHtml('container',$out)->response();

?>
