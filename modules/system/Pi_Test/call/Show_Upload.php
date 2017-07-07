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

			<table id="ciccia">
								
	<tbody><tr><th width="100px"></th>
		<th width="100px" style="text-align:center;">Gestione</th>
		<th width="100px" style="text-align:center;">Condivisione</th>
		<th width="100px" style="text-align:center;">Lettura</th>
		<th width="100px" style="text-align:center;">Scrittura</th>
							
		</tr><tr>
			<th style="font-weight: bold;">Tutti</th>
		
			<td style="text-align:center;">
				<input type="hidden" name="PermessiUser" value="0">
				<input class="checkPerm" id="checkPermG-0" data-type="G" data-idnumb="0" type="checkbox" name="PermessiG" data-pi-inputparse="true"><label for="checkPermG-0"></label>
			</td>
			
			<td style="text-align:center;">
				<input class="checkPerm" id="checkPermC-0" data-type="C" data-idnumb="0" type="checkbox" name="PermessiC" data-pi-inputparse="true"><label for="checkPermC-0"></label>
			</td>

			<td style="text-align:center;">
				<input class="checkPerm" id="checkPermL-0" data-type="L" data-idnumb="0" type="checkbox" name="PermessiL" data-pi-inputparse="true"><label for="checkPermL-0"></label>
			</td>
			
			<td style="text-align:center;">
				<input class="checkPerm" id="checkPermS-0" data-type="S" data-idnumb="0" type="checkbox" name="PermessiS" data-pi-inputparse="true"><label for="checkPermS-0"></label>
			</td>										
		</tr>

		<tr>
			<th style="font-weight: bold;">Contabilita</th>
		
			<td style="text-align:center;">
				<input type="hidden" name="PermessiUser" value="4">
				<input class="checkPerm" id="checkPermG-1" data-type="G" data-idnumb="1" type="checkbox" name="PermessiG" data-pi-inputparse="true"><label for="checkPermG-1"></label>
			</td>
			
			<td style="text-align:center;">
				<input class="checkPerm" id="checkPermC-1" data-type="C" data-idnumb="1" type="checkbox" name="PermessiC" data-pi-inputparse="true"><label for="checkPermC-1"></label>
			</td>

			<td style="text-align:center;">
				<input class="checkPerm" id="checkPermL-1" data-type="L" data-idnumb="1" type="checkbox" name="PermessiL" data-pi-inputparse="true"><label for="checkPermL-1"></label>
			</td>
			
			<td style="text-align:center;">
				<input class="checkPerm" id="checkPermS-1" data-type="S" data-idnumb="1" type="checkbox" name="PermessiS" data-pi-inputparse="true"><label for="checkPermS-1"></label>
			</td>										
		</tr>

		<tr>
			<th style="font-weight: normal;">Betta</th>
		
			<td style="text-align:center;">
				<input type="hidden" name="PermessiUser" value="2">
				<input class="checkPerm" id="checkPermG-2" data-type="G" data-idnumb="2" type="checkbox" name="PermessiG" checked="" data-pi-inputparse="true"><label for="checkPermG-2"></label>
			</td>
			
			<td style="text-align:center;">
				<input class="checkPerm" id="checkPermC-2" data-type="C" data-idnumb="2" type="checkbox" name="PermessiC" checked="" data-pi-inputparse="true"><label for="checkPermC-2"></label>
			</td>

			<td style="text-align:center;">
				<input class="checkPerm" id="checkPermL-2" data-type="L" data-idnumb="2" type="checkbox" name="PermessiL" checked="" data-pi-inputparse="true"><label for="checkPermL-2"></label>
			</td>
			
			<td style="text-align:center;">
				<input class="checkPerm" id="checkPermS-2" data-type="S" data-idnumb="2" type="checkbox" name="PermessiS" checked="" data-pi-inputparse="true"><label for="checkPermS-2"></label>
			</td>										
		</tr>

		<tr>
			<th style="font-weight: normal;">Massimo</th>
		
			<td style="text-align:center;">
				<input type="hidden" name="PermessiUser" value="1">
				<input class="checkPerm" id="checkPermG-3" data-type="G" data-idnumb="3" type="checkbox" name="PermessiG" checked="" data-pi-inputparse="true"><label for="checkPermG-3"></label>
			</td>
			
			<td style="text-align:center;">
				<input class="checkPerm" id="checkPermC-3" data-type="C" data-idnumb="3" type="checkbox" name="PermessiC" checked="" data-pi-inputparse="true"><label for="checkPermC-3"></label>
			</td>

			<td style="text-align:center;">
				<input class="checkPerm" id="checkPermL-3" data-type="L" data-idnumb="3" type="checkbox" name="PermessiL" checked="" data-pi-inputparse="true"><label for="checkPermL-3"></label>
			</td>
			
			<td style="text-align:center;">
				<input class="checkPerm" id="checkPermS-3" data-type="S" data-idnumb="3" type="checkbox" name="PermessiS" checked="" data-pi-inputparse="true"><label for="checkPermS-3"></label>
			</td>										
		</tr>

		<tr>
			<th style="font-weight: normal;">Rossella</th>
		
			<td style="text-align:center;">
				<input type="hidden" name="PermessiUser" value="3">
				<input class="checkPerm" id="checkPermG-4" data-type="G" data-idnumb="4" type="checkbox" name="PermessiG" data-pi-inputparse="true"><label for="checkPermG-4"></label>
			</td>
			
			<td style="text-align:center;">
				<input class="checkPerm" id="checkPermC-4" data-type="C" data-idnumb="4" type="checkbox" name="PermessiC" data-pi-inputparse="true"><label for="checkPermC-4"></label>
			</td>

			<td style="text-align:center;">
				<input class="checkPerm" id="checkPermL-4" data-type="L" data-idnumb="4" type="checkbox" name="PermessiL" data-pi-inputparse="true"><label for="checkPermL-4"></label>
			</td>
			
			<td style="text-align:center;">
				<input class="checkPerm" id="checkPermS-4" data-type="S" data-idnumb="4" type="checkbox" name="PermessiS" data-pi-inputparse="true"><label for="checkPermS-4"></label>
			</td>										
		</tr>
															
	</tbody>
</table>
<button onclick="pi.request(\'ciccia\')"> TEST </button>

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
