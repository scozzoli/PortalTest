<?
	$option = '<option> Option 1 </option><option> Option 2 </option><option> Option 3 </option>';
	$out = '<div class="panel">
				<div class="header">Campi di input</div>
				I campi di input sono formattati in automatico (senza la necessit&aacute; di impostare stili particolari).<br>
				Gli stili vengono impostati solo per defininire il livello di "importanza del campo"<br><br>

				<table width="100%" style="text-align:center;">
					<tr>
						<th> Tipologia </th>
						<th> <i>Nessuno stile applicato</i></th>
						<th> .ale </th>
						<th> .err </th>
						<th> <i>Disabilitato</i> </th>
						<th> .ale <i>Disabilitato</i></th>
						<th> .err <i>Disabilitato</i></th>
					</tr>
					<tr>
						<th> input text </th>
						<td> <input type="text" value="testo"> </td>
						<td> <input type="text" class="ale" value="testo"> </td>
						<td> <input type="text" class="err" value="testo"> </td>
						<td> <input type="text" value="testo" disabled> </td>
						<td> <input type="text" class="ale" value="testo" disabled> </td>
						<td> <input type="text" class="err" value="testo" disabled> </td>
					</tr>
					<tr>
						<th> input file </th>
						<td id="ciao"> <input type="file" name="test" multiple> </td>
						<td> <input type="file" class="ale" "> </td>
						<td> <input type="file" class="err" > </td>
						<td> <input type="file"  disabled> </td>
						<td> <input type="file" class="ale"  disabled> </td>
						<td> <input type="file" class="err"  disabled> </td>
					</tr>
					<tr>
						<th> select </th>
						<td> <select value="testo">'.$option.'</select> </td>
						<td> <select class="ale" value="testo">'.$option.'</select> </td>
						<td> <select class="err" value="testo">'.$option.'</select> </td>
						<td> <select value="testo" disabled>'.$option.'</select> </td>
						<td> <select class="ale" value="testo" disabled>'.$option.'</select> </td>
						<td> <select class="err" value="testo" disabled>'.$option.'</select> </td>
					</tr>
					<tr>
						<th> textarea </th>
						<td> <textarea value="testo"> Testo </textarea> </td>
						<td> <textarea class="ale"> Testo </textarea> </td>
						<td> <textarea class="err"> Testo </textarea> </td>
						<td> <textarea value="testo" disabled> Testo </textarea> </td>
						<td> <textarea class="ale" disabled> Testo </textarea> </td>
						<td> <textarea class="err" disabled> Testo </textarea> </td>
					</tr>
					<tr>
						<th> checkbox </th>
						<td>
							<input type="checkbox" id="chk1"> Checkbox <br/>
							<input type="checkbox" id="chk2" checked> Checkbox <br/>
						</td>
						<td>  </td>
						<td>  </td>
						<td>
							<input type="checkbox" id="chk3" disabled> Checkbox <br/>
							<input type="checkbox" id="chk4" disabled checked> Checkbox <br/>
						</td>
						<td>  </td>
						<td>  </td>
					</tr>
					<tr>
						<th> radio </th>
						<td>
							<input type="radio" id="rad1" name="radio"> Radio <br/>
							<input type="radio" id="rad2" name="radio" checked> Radio <br/>
						</td>
						<td>  </td>
						<td>  </td>
						<td>
							<input type="radio" name="radio2" disabled> Radio <br/>
							<input type="radio" name="radio2" disabled checked> Radio <br/>
						</td>
						<td>  </td>
						<td>  </td>
					</tr>
				</table>
				<br><br>
				<div class="focus blue">
					la larghezza di default dei campi &eacute; di 150px, esistono della calssi modificatrici che permettono di impostare velocemente le dimensioni all\'interno degli elementi:<br>
					<b>double</b>: 300px (ossia il doppio dello standard)<br>
					<b>full</b> : dimensione massima meno 20px (che risulatno essere i margini standard dei container)<br><br>
					<table class="form">
						<tr>
							<th> <i>no style</i> </th>
							<td> <input type="text" value="150px"> </td>
						</tr>
						<tr>
							<th> .double </th>
							<td> <input type="text" class="double" value="300px"> </td>
						</tr>
						<tr>
							<th> .full </th>
							<td> <input type="text" class="full" value="100% - 20px"> </td>
						</tr>
					</table>
				</div>


			</div>



			<div class="panel">
				<div class="header"> Stili dei pulsanti </div>
				I pulsanti sono stilizzati di default e non richiedono elementi aggiuntivi, quindi sono solo del tipo:<br><br>

				<div class="focus blue">
					&lt;button&gt; <i>testo bottone</i> &lt;/button&gt;<br>
					&lt;button class="icon"&gt; &lt;i class="<b>mdi mdi-<i style="color:#888;">nome icona</i></b>"&gt; &lt;/i&gt; &lt;/button&gt;<br>
				</div>
				<br>

				<table width="100%" style="text-align:center;">
					<tr>
						<th>tipologia</th>
						<th>Normale</th>
						<th>Normale + immagine</th>
						<th>.icon</th>
						<th>Disattivato</th>
						<th>Disattivato + immagine</th>
						<th>.icon Disattivato</th>
					</tr>
					<tr>
						<th>nessuno stile</th>
						<td><button>Pulsante</button></td>
						<td><button><i class="mdi mdi-camera-iris"></i> Pulsante</button></td>
						<td><button class="icon"><i class="mdi mdi-camera-iris"></i></button></td>
						<td><button disabled>Pulsante</button></td>
						<td><button disabled><i class="mdi mdi-camera-iris"></i> Pulsante</button></td>
						<td><button class="icon" disabled><i class="mdi mdi-camera-iris"></i></button></td>
					</tr>
					<tr>
						<th>.blue</th>
						<td><button class="blue">Pulsante</button></td>
						<td><button class="blue"><i class="mdi mdi-camera-iris"></i> Pulsante</button></td>
						<td><button class="blue icon"><i class="mdi mdi-camera-iris"></i></button></td>
						<td><button class="blue" disabled>Pulsante</button></td>
						<td><button class="blue" disabled><i class="mdi mdi-camera-iris"></i> Pulsante</button></td>
						<td><button class="blue icon" disabled><i class="mdi mdi-camera-iris"></i></button></td>
					</tr>
					<tr>
						<th>.orange</th>
						<td><button class="orange">Pulsante</button></td>
						<td><button class="orange"><i class="mdi mdi-camera-iris"></i> Pulsante</button></td>
						<td><button class="orange icon"><i class="mdi mdi-camera-iris"></i></button></td>
						<td><button class="orange" disabled>Pulsante</button></td>
						<td><button class="orange" disabled><i class="mdi mdi-camera-iris"></i> Pulsante</button></td>
						<td><button class="orange icon" disabled><i class="mdi mdi-camera-iris"></i></button></td>
					</tr>
					<tr>
						<th>.red</th>
						<td><button class="red">Pulsante</button></td>
						<td><button class="red"><i class="mdi mdi-camera-iris"></i> Pulsante</button></td>
						<td><button class="red icon"><i class="mdi mdi-camera-iris"></i></button></td>
						<td><button class="red" disabled>Pulsante</button></td>
						<td><button class="red" disabled><i class="mdi mdi-camera-iris"></i> Pulsante</button></td>
						<td><button class="red icon" disabled><i class="mdi mdi-camera-iris"></i></button></td>
					</tr>
					<tr>
						<th>.green</th>
						<td><button class="green">Pulsante</button></td>
						<td><button class="green"><i class="mdi mdi-camera-iris"></i> Pulsante</button></td>
						<td><button class="green icon"><i class="mdi mdi-camera-iris"></i></button></td>
						<td><button class="green" disabled>Pulsante</button></td>
						<td><button class="green" disabled><i class="mdi mdi-camera-iris"></i> Pulsante</button></td>
						<td><button class="green icon" disabled><i class="mdi mdi-camera-iris"></i></button></td>
					</tr>
					<tr>
						<th>.purple</th>
						<td><button class="purple">Pulsante</button></td>
						<td><button class="purple"><i class="mdi mdi-camera-iris"></i> Pulsante</button></td>
						<td><button class="purple icon"><i class="mdi mdi-camera-iris"></i></button></td>
						<td><button class="purple" disabled>Pulsante</button></td>
						<td><button class="purple" disabled><i class="mdi mdi-camera-iris"></i> Pulsante</button></td>
						<td><button class="purple icon" disabled><i class="mdi mdi-camera-iris"></i></button></td>
					</tr>
				</table>
			</div>';
	$pr->addHtml('container',$out)->response();
?>
