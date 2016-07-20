<?
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
			</div>';
	$pr->addHtml('container',$out)->response();
?>
