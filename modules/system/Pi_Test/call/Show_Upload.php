<?php
	$option = '<option> Option 1 </option><option> Option 2 </option><option> Option 3 </option>';
	$out = '<div class="panel" id="test_upload">
				<table class="form">
					<tr>
						<th>File</th>
						<td><input type="file" multiple name="filetest"></td>
						<td>
							<button onClick="pi.request(\'test_upload\',\'Upload\')">Upload</button>
						</td>
					</tr>
				</table>
				<input type="text" data-pic=" datepicker : { timepicker : true, format: \'d/m/Y H:i\' } ">
				
			</div>
			
			<div class="panel" id="test_multi">
				<select name="cars" multiple style="height: 200px;">
					<option value="volvo">Volvo</option>
					<option value="saab">Saab</option>
					<option value="opel">Opel</option>
					<option value="audi">Audi</option>
				</select>
				<input type="text" name="text" value="uno">
				<input type="text" name="text" value="due">
				
				<input type="radio" name="radio" value="uno">
				<input type="radio" name="radio" value="due">
				<input type="text" name="radio" value="tre">

				<input type="checkbox" name="chk">
				<input type="checkbox" name="chk">
				<input type="checkbox" name="chk">
				
<button onclick="pi.request(\'test_multi\',\'Multi\')"> test </button>

			</div>

			<table class="lite green" >
				<theader>
					<tr>
						<th>Titolo</th>
						<th>Titolo</th>
						<th>Titolo</th>
						<th>Titolo</th>
					</tr>
                </theader>
				<tbody>
					<tr> <td>xxx</td> <td>xxx</td> <td>xxx</td> <td>xxx</td> </tr>
					<tr> <td>xxx</td> <td>xxx</td> <td>xxx</td> <td>xxx</td> </tr>
					<tr> <td>xxx</td> <td>xxx</td> <td>xxx</td> <td>xxx</td> </tr>
					<tr> <td>xxx</td> <td>xxx</td> <td>xxx</td> <td>xxx</td> </tr>
					<tr> <td>xxx</td> <td>xxx</td> <td>xxx</td> <td>xxx</td> </tr>
					<tr> <td>xxx</td> <td>xxx</td> <td>xxx</td> <td>xxx</td> </tr>
					<tr> <td>xxx</td> <td>xxx</td> <td>xxx</td> <td>xxx</td> </tr>
					<tr> <td>xxx</td> <td>xxx</td> <td>xxx</td> <td>xxx</td> </tr>
					<tr> <td>xxx</td> <td>xxx</td> <td>xxx</td> <td>xxx</td> </tr>
					<tr> <td>xxx</td> <td>xxx</td> <td>xxx</td> <td>xxx</td> </tr>
					<tr> <td>xxx</td> <td>xxx</td> <td>xxx</td> <td>xxx</td> </tr>
					<tr> <td>xxx</td> <td>xxx</td> <td>xxx</td> <td>xxx</td> </tr>
					<tr> <td>xxx</td> <td>xxx</td> <td>xxx</td> <td>xxx</td> </tr>
					<tr> <td>xxx</td> <td>xxx</td> <td>xxx</td> <td>xxx</td> </tr>
					<tr> <td>xxx</td> <td>xxx</td> <td>xxx</td> <td>xxx</td> </tr>
					<tr> <td>xxx</td> <td>xxx</td> <td>xxx</td> <td>xxx</td> </tr>
					<tr> <td>xxx</td> <td>xxx</td> <td>xxx</td> <td>xxx</td> </tr>
					<tr> <td>xxx</td> <td>xxx</td> <td>xxx</td> <td>xxx</td> </tr>
					<tr> <td>xxx</td> <td>xxx</td> <td>xxx</td> <td>xxx</td> </tr>
					<tr> <td>xxx</td> <td>xxx</td> <td>xxx</td> <td>xxx</td> </tr>
					<tr> <td>xxx</td> <td>xxx</td> <td>xxx</td> <td>xxx</td> </tr>
					<tr> <td>xxx</td> <td>xxx</td> <td>xxx</td> <td>xxx</td> </tr>
					<tr> <td>xxx</td> <td>xxx</td> <td>xxx</td> <td>xxx</td> </tr>
					<tr> <td>xxx</td> <td>xxx</td> <td>xxx</td> <td>xxx</td> </tr>
					<tr> <td>xxx</td> <td>xxx</td> <td>xxx</td> <td>xxx</td> </tr>
					<tr> <td>xxx</td> <td>xxx</td> <td>xxx</td> <td>xxx</td> </tr>
					<tr> <td>xxx</td> <td>xxx</td> <td>xxx</td> <td>xxx</td> </tr>
				</tbody>
			</table>
			<div class="focus green ">
				<table class="form">
					<tr>
						<td style="width:40px;"><i class="mdi mdi-chevron-left l3"></i></td>
						<td style="width:100px;">
							<select class="small">
								<option> 1 / 4 </option>
								<option> 2 / 4 </option>
								<option> 3 / 4 </option>
								<option> 4 / 4 </option>
							</select>
						</td>
						<td style="width:40px;"><i class="mdi mdi-chevron-right l3"></i></td>
						<th>
							<select class="small">
								<option> 25 </option>
								<option> 50 </option>
								<option> 75 </option>
								<option> 100 </option>
							</select>
						</th>
					</tr>
				</table>
			</div>
			<br>
			<div class="blue lite" data-pic=" grid : {filtersId : \'data\', call : \'Udate_Grid\', id : \'PiGrid\', pages:[25,50,75,100], startPage : 3} ">
				<div data-col=" name: \'c1\' "> nome colonna </div>
				<div data-col=" name: \'c2\' "> nome colonna 2 </div>
				<div class="green" data-col=" name: \'c3\' "> nome colonna 3 </div>
				<div data-col=" name: \'c4\' "> nome colonna 4 </div>
			</div>';
	$pr->addHtml('container',$out)->response();
?>
