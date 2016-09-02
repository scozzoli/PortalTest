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
			';
	$pr->addHtml('container',$out)->response();
?>
