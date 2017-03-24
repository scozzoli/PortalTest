<?php
	function getStyle($style){
		$out = '<span class="'.$style.'"> Normale (span) </span>';
		$out.= '<i class="'.$style.'"> Corsivo (i) </i>';
		$out.= '<b class="'.$style.'"> Grassetto (b) </b>';
		$out.= '<u class="'.$style.'"> Sottolineato (u) </u>';
		return $out;
	}
	
	$out = '		
			<div class="panel">
				<div class="header">Immagini</div>
				Gli stili applicabili agli elementi <i class="focus"> span, i, u, b </i> servono per cambiare velocemente il colore degli elementi mantenendo il tema:<br>
				Questi stili sono:
				<div class="focus blue">
					<ul>
						<li> <b>focus</b> <i>Colore principale del tema tonalit&aacute; scura</i> </li>
						<li> <b>disabled</b> <i>Colore principale del tema tonalit&aacute; chiara</i> </li>
						<li> 
							<b>blue</b> <i>Tonalit&aacute; scura del blu</i> 
							<ul><li><b>blue disabled</b> <i>Tonalit&aacute; chiara del blu</i> </li></ul>
						</li>
						<li> 
							<b>orange</b> <i>Tonalit&aacute; scura di arancione</i> 
							<ul><li><b>orange disabled</b> <i>Tonalit&aacute; chiara del arancione</i> </li></ul>
							</li>
						<li> 
							<b>red</b> <i>Tonalit&aacute; scura del rosso</i> 
							<ul><li><b>red disabled</b> <i>Tonalit&aacute; chiara del rosso</i> </li></ul>
						</li>
						<li> 
							<b>green</b> <i>Tonalit&aacute; scura del verde</i> 
							<ul><li><b>green disabled</b> <i>Tonalit&aacute; chiara del verde</i> </li></ul>
						</li>
						<li> 
							<b>purple</b> <i>Tonalit&aacute; scura del viola</i> 
							<ul><li><b>purple disabled</b> <i>Tonalit&aacute; chiara del viola</i> </li></ul>
						</li>
					</ul>
				</div>
				<br>
				<table width="100%" style="text-align:center;">
					<tr>
						<th></th>
						<th><i>Nessuno stile</i></th>
						<th>.disabled</th>
					</tr>
					<tr>
						<th><i>Nessuno stile</i></th>
						<td> '.getStyle('').' </td>
						<td> '.getStyle('disabled').' </td>
					</tr>
					<tr>
						<th>.focus</th>
						<td> '.getStyle('focus').' </td>
						<td>  </td>
					</tr>
					<tr>
						<th>.blue</th>
						<td> '.getStyle('blue').' </td>
						<td> '.getStyle('blue disabled').' </td>
					</tr>
					<tr>
						<th>.orange</th>
						<td> '.getStyle('orange').' </td>
						<td> '.getStyle('orange disabled').' </td>
					</tr>
					<tr>
						<th>.red</th>
						<td> '.getStyle('red').' </td>
						<td> '.getStyle('red disabled').' </td>
					</tr>
					<tr>
						<th>.green</th>
						<td> '.getStyle('green').' </td>
						<td> '.getStyle('green disabled').' </td>
					</tr>
					<tr>
						<th>.purple</th>
						<td> '.getStyle('purple').' </td>
						<td> '.getStyle('purple disabled').' </td>
					</tr>
				</table>
			</div>
			<div class="panel">
				<div class="header"> Icon Font (MaterialDesignIcons)</div>
				Le icone sono tutte derivate dal Material Design Iconset e si inseriscono usando il tag <b class="focus">&lt;i&gt;</b>. <br>
				Di default le dimensioni del font sono di <b>16px</b>, esistono per&oacute; delle classi che permettono di modificare direttamente questo valore senza usare l\'attrubuto style:<br>
				<br>
				<div class="focus orange">
					<ul>
						<li><b>l2</b> - 24px</li>
						<li><b>l3</b> - 32px</li>
						<li><b>l4</b> - 48px</li>
						<li><b>l5</b> - 64px</li>
					</ul>
				</div>
				<br><br>
				<table width="100%" style="text-align:center;">
					<tr>
						<th>.mdi .mdi-black-mesa</th>
						<th>.mdi .mdi-black-mesa .l2</th>
						<th>.mdi .mdi-black-mesa .l3</th>
						<th>.mdi .mdi-black-mesa .l4</th>
						<th>.mdi .mdi-black-mesa .l5</th>
					</tr>
					<tr>
						<td> <i class="mdi mdi-black-mesa" /></td>
						<td> <i class="mdi mdi-black-mesa l2" /></td>
						<td> <i class="mdi mdi-black-mesa l3" /></td>
						<td> <i class="mdi mdi-black-mesa l4" /></td>
						<td> <i class="mdi mdi-black-mesa l5" /></td>
					</tr>
				</table>
			</div>';
	$pr->addHtml('container',$out)->response();
?>