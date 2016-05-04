<?
	function panelColor($color){
		$focus = '<div class="focus"> .focus </div>
							<div class="focus blue"> .focus .blue</div>
							<div class="focus orange"> .focus .orange</div>
							<div class="focus red"> .focus .red</div>
							<div class="focus green"> .focus .green</div>
							<div class="focus purple"> .focus .purple</div>';
		return '<tr>
					<th> <div class="focus '.$color.'">.focus  .'.$color.'</div> </th>
					<td>
						<div class="panel '.$color.'">
							'.$focus.'
							elem .panel
						</div>
					</td>
					<td>
						<div class="panel '.$color.'">
							<div class="header"> .panel &gt; .header </div>
							'.$focus.'
							elem .panel
						</div>
					</td>
					<td>
						<div class="panel '.$color.'">
							<div class="header"> .panel &gt; .header </div>
							'.$focus.'
							elem .panel
							<div class="footer"> .panel &gt; .footer </div>
						</div>
					</td>
					<td>
						<div class="panel">
							<div class="header '.$color.'"> .panel &gt; .header </div>
							'.$focus.'
							elem .panel
						</div>
					</td>
					<td>
						<div class="panel">
							<div class="header '.$color.'"> .panel &gt; .header </div>
							'.$focus.'
							elem .panel
							<div class="footer '.$color.'"> .panel &gt; .footer </div>
						</div>
					</td>
				</tr>';
	}
	
	$out = '		
			<div class="panel" data-pi-component="collapse">
				<div class="header">Informazioni generiche sugli stili</div>
				Gli stili applicabili agli elementi "div" sono definiti come pannelli <b>panel</b> ed hanno una struttura cos&iacute; composta :<br><br>
				<div class="focus blue">
					&lt;div class="<b>.panel</b> <i style="color:#888;"> colore </i>"&gt;<br>
					&nbsp;&nbsp;&nbsp;&nbsp; &lt;div class="<b>.header</b> <i style="color:#888;"> colore </i>"&gt; <i> Titolo della pagina</i> &lt;/div&gt;<br>
					&nbsp;&nbsp;&nbsp;&nbsp; &lt;div class="<b>.focus</b> <i style="color:#888;"> colore </i>"&gt; <i>Elemento in rilievo</i> &lt;/div&gt;<br>
					&nbsp;&nbsp;&nbsp;&nbsp; <i> Content </i><br>
					&nbsp;&nbsp;&nbsp;&nbsp; &lt;div class="<b>.footer</b> <i style="color:#888;"> colore </i>"&gt; <i>Fondo pagina (pulsnati)</i> &lt;/div&gt;<br>
					&lt;/div&gt;
				</div>
				<br>
				All\'interno degli header &eacute; possibile usare anche i <b>badge</b> (in combinata con le icone di MateriaDesigneIcons).<br>
				<br><br>
				<div class="focus orange">
					&lt;div class="<b>.panel</b> <i style="color:#888;"> colore </i>"&gt;<br>
					&nbsp;&nbsp;&nbsp;&nbsp; &lt;div class="<b>.header</b> <i style="color:#888;"> colore </i>"&gt; <br>
					&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp; <i> Titolo della pagina</i> <br>
					&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp; &lt;div class="<b>.badge</b> <i style="color:#888;"> small / large / xlarge </i>"&gt;<br>
					&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp; &lt;i class="<b>mdi mdi-<i style="color:#888;">nome icona</i></b>"&gt; &lt;/i&gt;<br>
					&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp; &lt;/div&gt;<br>
					&nbsp;&nbsp;&nbsp;&nbsp; &lt;/div&gt;<br>
					&lt;/div&gt;
				</div>
				
			</div>
			
			<div class="panel blue"> Esempi di stili e colori </div>
			
			<table width="100%">
				<tr>
					<th> .focus [.color] </th>
					<th> .panel [.color]</th>
					<th> .panel [.color] { .header } </th>
					<th> .panel [.color] { .header .footer } </th>
					<th> .panel { .header [.color] } </th>
					<th> .panel { .header [.color] .footer [.color] } </th>
					
				</tr>
				'.panelColor('').panelColor('blue').panelColor('orange').panelColor('red').panelColor('green').panelColor('purple').'
			</table>
			
			<div class="panel orange"> Esempi di badge </div>
			<table width="100%">
				<tr>
					<th> Piccolo [.badge .small]</th>
					<th> Normale [.badge]</th>
					<th> Grande [.badge .large]</th>
					<th> Extra [.badge .xlarge]</th>
				</tr>
				<tr>
					<td> <div class="panel"><div class="header"> Titolo della finestra <div class="badge small"><i class="mdi mdi-camera-iris"></div></div></div></td>
					<td> <div class="panel"><div class="header"> Titolo della finestra <div class="badge "><i class="mdi mdi-camera-iris"></div></div></div></td>
					<td> <div class="panel"><div class="header"> Titolo della finestra <div class="badge large"><i class="mdi mdi-camera-iris"></div></div></div></td>
					<td> <div class="panel"><div class="header"> Titolo della finestra <div class="badge xlarge"><i class="mdi mdi-camera-iris"></div></div></div></td>
				</tr>
			</table>
		';
	$pr->addHtml('container',$out)->response();
?>